<?php
class splitDao {	
	private $pdoObject;	
	
	public function connect($host, $pdo) {
		try {
			$this->pdoObject = $pdo;
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
		return null;
	}
	
	public function disconnect() {
		$pdo = $this->pdoObject;
		$pdo->close();
	}
	
	public function splitItem($id,$groupBuyId) {
		$sql="select * from product where id = ?";
		$pdo = $this->pdoObject;
		$sth=$pdo->prepare($sql);
		$sth->execute(array ($id) );	
		$results = $sth->fetchAll();
		$product = Product::load($results);
		
		$sql="select * from groupbuy where id = ?";
		$pdo = $this->pdoObject;
		$sth=$pdo->prepare($sql);
		$sth->execute(array ($groupBuyId) );
		$results = $sth->fetchAll();
		$groupbuy = GroupBuy::load($results);

        $split = $product->getSplit();
		if (empty( $split )) {
            $split = $product->getPounds();
        }

		if ($groupbuy->getSplitAmt() != null && $groupbuy->getSplitAmt() < $split) {
			$split = $groupbuy->getSplitAmt();
		}
		
		$arr = array('id' => $product->getId(), 'name' => $product->getName(), 'vendor' => $product->getVendor(), 'splitAmt' => $split, 'groupBuyId' => $groupBuyId);

		return json_encode($arr);
	}

    public function add($splitId,$quantity,$email) {
        try {
            $sql = "select * from user_split where email = ? and splitId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($email, $splitId) );
            $results = $sth->fetchAll();
            $currentQuantity=0;
            foreach ($results as $row) {
                $currentQuantity =  $row["amount"];
            }
            if ($currentQuantity == "") {
                $currentQuantity=0;
            }

            if ($currentQuantity > 0) {
                $quantity = $quantity+$currentQuantity;
                $sql = "UPDATE user_split set amount = ? where email = ? and splitId = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ( $quantity,$email,$splitId) );
            } else {
                $sql = "INSERT INTO user_split (amount, email, splitId) VALUES (?,?,?)";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ( $quantity,$email,$splitId) );
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function subtract($splitId,$email) {
        try {
            $sql = "select * from user_split where email = ? and splitId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($email, $splitId) );
            $results = $sth->fetchAll();
            $currentQuantity=0;
            foreach ($results as $row) {
                $currentQuantity =  $row["amount"];
            }
            if ($currentQuantity == "") {
                $currentQuantity=0;
            }

            if ($currentQuantity > 1) {
                $quantity = $currentQuantity-1;
                $sql = "UPDATE user_split set amount = ? where email = ? and splitId = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ( $quantity,$email,$splitId) );
            } else {
                $sql = "DELETE FROM user_split where email = ? and splitId = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($email,$splitId) );
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function remove($splitId,$user) {
        try {
            $sql = "DELETE from user_split where email = ? and splitId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($user->getEmail(), $splitId) );
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function isSplitAvailable($productId,$user,$groupBuyId) {
        try {
            $amount=0;
            //Finds if user ordered more than one before just deleting
            $sql = "Select amount FROM user_product where productId = ? and email = ? and groupBuyId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $productId,$user->getEmail(),$groupBuyId ) );
            $results = $sth->fetchall();
            foreach ($results as $row) {
                $amount = $row["amount"];
            }
            return $amount;
        } catch (Exception $ex) {

        }
    }
    public function createSplit($numOfSplit,$productId,$quantity,$user,$groupBuyId) {
        try {
            $sql = "INSERT INTO split (owner,productId,splitAmt,groupBuyId) VALUES (?,?,?,?)";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $user->getEmail(),$productId,$numOfSplit,$groupBuyId) );
            $splitId = $pdo->lastInsertId();
            $sql = "INSERT INTO user_split (splitId, email, amount) VALUES (?,?,?)";
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $splitId, $user->getEmail(), $quantity ) );
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>