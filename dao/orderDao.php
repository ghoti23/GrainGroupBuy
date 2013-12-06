<?php

class orderDao {
    private $pdoObject;

    public function connect($host, $pdo) {
        try {
            $result = $this->pdoObject = $pdo;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public function disconnect() {
        $pdo = $this->pdoObject;
        $pdo->close();
    }

    public function get($id, $user) {
        try {
            $sql = "select email, productId, groupBuyId, amount, p.* from (select email, productId, groupBuyId, sum(amount) as amount from user_product where groupBuyId = ? and email = ? group by email, productId, groupBuyId) up, product p where p.id = up.productId order by name";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($id, $user->getEmail()) );
            $results = $sth->fetchAll();
            $order = Order::load($results);
            if (!empty($order)) {
                $order->setSplit($this->selectGroupBuyOrderSplit($id, $user));
            }

            return $order;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getNumOfSplit($groupBuyId) {
        try {
            $sql = "Select count(id) as total from split where groupbuyId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyId) );
            $results = $sth->fetchall();
            foreach ($results as $row) {
                return $row["total"];
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getTotalPounds ($groupBuyID) {
        $productTotal = $this->getProductTotalPounds($groupBuyID);
        //	echo "<br />Product total: " . $productTotal;
        $splitTotal = $this->getSplitTotalPounds($groupBuyID);
        //	echo "<br />Split total: " . $splitTotal . "<br />";
        return $splitTotal+$productTotal;
    }

    public function getProductTotalPounds ($groupBuyID) {
        try {
            $sql = "select SUM(amount*pounds) as product_total from user_product join product on user_product.productID = product.id where groupBuyId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyID) );
            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    return $row["product_total"];
                }
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }

    public function getSplitTotalPounds ($groupBuyID) {
        try {
            $pounds = 0;
            $sql = "SELECT COUNT( s.productID ) as product_total, pounds FROM split s, product p WHERE s.productId = p.id AND groupBuyId =? GROUP BY s.productId";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyID) );
            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    $pounds += ($row["product_total"] * $row["pounds"]);
                }
            }

            return $pounds;

        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }

    }

    public function getUserTotalPounds ($groupBuyId, $user) {
        $productTotal = $this->getUserProductTotalPounds($groupBuyId, $user);
        $splitTotal = $this->getUserSplitTotalPounds($groupBuyId, $user);

        return $splitTotal + $productTotal;
    }

    public function getUserProductTotalPounds ($groupBuyId, $user) {
        try {
            $sql = "select SUM(amount*pounds) as product_total from user_product join product on user_product.productID = product.id where groupBuyId = ? AND email = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyId, $user->getEmail()) );
            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    return $row["product_total"];
                }
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }

    public function getUserSplitTotalPounds ($groupBuyId, $user) {
        try {
            $pounds = 0;
            $sql = "SELECT COUNT( s.productID ) as product_total, pounds FROM split s, product p WHERE s.productId = p.id AND groupBuyId = ? AND email = ? GROUP BY s.productId";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyId, $user->getEmail()) );
            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    $pounds += ($row["product_total"] * $row["pounds"]);
                }
            }

            return $pounds;

        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }

    }

    public function selectGroupBuyOrderSplit($id, $user) {
        try {
            $sql = "SELECT splitId,email,amount,productId,splitAmt,groupBuyId,available,p.* FROM user_split us, split s, product p, splitavailable_view sav where sav.id = s.id and p.id = s.productId and s.id = us.splitId and s.groupbuyId = ? and us.email = ? order by p.name";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($id,$user->getEmail()) );
            $results = $sth->fetchAll();
            $splits = Split::loadMultiple($results);
            return $splits;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAvailableSplits($groupbuy) {
        try {
            $sql = "select distinct split.id,split.productId,split.splitAmt, product.pounds,CONCAT(product.name,' - ',product.vendor) as product_name, (splitAmt - split_count.total) as available, product.price,product.type from split join user_split on split.id = user_split.splitId join split_count on split.id = split_count.splitId join product on split.productId = product.id where split_count.total < split.splitAmt and split.groupBuyId = ? ORDER BY product_name";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupbuy) );
            $results = $sth->fetchAll();
            return $results;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getSplitAvailablity($splitId) {
        try {
            $sql = "select count(amount) as userAmt,splitAmt from user_split,split where splitId = ? and split.id = user_split.splitId";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($splitId) );
            $results = $sth->fetchAll();
            foreach ($results as $row) {
                $userAmt = $row["userAmt"];
                $splitAmt = $row["splitAmt"];
            }
            if ($splitAmt > $userAmt) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addProductOrder($groupBuy_ID,$amount_int,$product_ID,$user) {
        try {
            if (empty($amount_int) || $amount_int < 1) {
                $amount_int=1;
            }
            $sql = "Select amount FROM user_product where email = ? and productId = ? and groupBuyId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $user->getEmail(),$product_ID,$groupBuy_ID ) );

            $count=0;
            $results = $sth->fetchAll();
            foreach ($results as $row) {
                $amount = $amount_int +$row["amount"];
                $count = $row["amount"];
            }


            if ($count == 0) {
                $sql = "INSERT INTO user_product (email, groupBuyId, productId, amount) VALUES (?, ?, ?, ?)";;
                $pdo = $this->pdoObject;
                $sth=$pdo->prepare($sql);
                $sth->execute(array ( $user->getEmail(),$groupBuy_ID,$product_ID,$amount_int) );
            } else {
                $sql = "UPDATE user_product set amount = ? where groupBuyId = ? and email = ? and productId = ?";
                $amount = $amount + $amount_int;
                $pdo = $this->pdoObject;
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($amount,$groupBuy_ID,$user->getEmail(),$product_ID) );
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function setProductOrder($groupBuy_ID,$amount,$product,$user) {
        try {
            $sql = "UPDATE user_product set amount = ? where groupBuyId = ? and email = ? and productId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($amount,$groupBuy_ID,$user->getEmail(),$product) );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function removeProductOrder($groupBuyId,$productId,$user) {
        try {
            $sql = "DELETE from user_product where groupBuyId = ? and productId = ? and email = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyId,$productId,$user->getEmail()) );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getGroupBuyProductOrder($groupbuy,$user) {
        try {
            $sql = "SELECT distinct * from groupbuy join user_product on groupbuy.ID = user_product.groupbuyID join product on product.Id = user_product.productId WHERE groupbuy.ID = ? and user_product.email = ? ORDER BY product.name";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupbuy,$user) );
            $results = $sth->fetchAll();
            $orders = Order::loadMultiple($results);
            return $orders;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getGroupBuyGrainSplitOrder($groupbuy,$user) {
        try {
            $sql = "SELECT distinct * from groupbuy g join split s on g.id = s.groupBuyId join  user_split us on us.splitId = s.Id join product p on p.id = s.productId where g.ID = ? and us.email = ? order by p.name  ";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupbuy,$user) );
            $results = $sth->fetchAll();
            return $results;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function paid($groupBuyId,$email,$paid) {
        try {
            $sql = "Select paid FROM groupbuy_paid where email = ? and groupBuyId = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $email,$groupBuyId ) );
            $count = $sth->rowCount();

            if ($count == 0) {
                $sql = "INSERT INTO groupbuy_paid (groupBuyId,email,paid) VALUES (?, ?, ?)";;
                $pdo = $this->pdoObject;
                $sth=$pdo->prepare($sql);
                $sth->execute(array ( $groupBuyId,$email,$paid) );
            } else {
                $sql = "UPDATE user_product set paid = ? where groupBuyId = ? and email = ?";
                $pdo = $this->pdoObject;
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($paid,$groupBuyId,$email) );
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * New user_order functions
     */
    public function addProduct($groupBuy_ID, $amount, $product_ID, $user) {
        try {
            if (empty($amount)) {
                return;
            }

            $sql = "INSERT INTO user_order (email, groupBuyId, productId, amount) VALUES (?, ?, ?, ?)";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $user->getEmail(), $groupBuy_ID, $product_ID, $amount) );

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function removeProduct($groupBuyId, $productId, $user) {
        try {
            $sql = "DELETE from user_order where groupBuyId = ? and productId = ? and email = ?";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($groupBuyId, $productId, $user->getEmail()) );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getOrder($id, $user) {
        try {
            $sql = "select email, productId, groupBuyId, amount, p.* from (select email, productId, groupBuyId, sum(amount) as amount from user_order where groupBuyId = ? and email = ? group by email, productId, groupBuyId) up, product p where p.id = up.productId order by name";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($id, $user->getEmail()) );
            $results = $sth->fetchAll();
            $order = Order::load($results);

            return $order;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getOrderHistory($user)
    {
        try {
            $sql = 'select id, name, owner, owner AS ownerEmail, startDt, endDt from groupbuy g where id in (select groupBuyId from user_order where email = ?) and g.endDt <= CURRENT_DATE() order by endDt desc';
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array ($user->getEmail()));
            $results = $sth->fetchAll();
            $orders = GroupBuy::loadMultiple($results);
            return $orders;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAllOrdersTotalPounds ($groupBuyID) {
        try {
            $pdo = $this->pdoObject;
            if (empty($groupBuyID)) {
                $sql = "select SUM(amount*pounds) as product_total from user_order join product on user_order.productID = product.id";
                $sth=$pdo->prepare($sql);
                $sth->execute();
            } else {
                $sql = "select SUM(amount*pounds) as product_total from user_order join product on user_order.productID = product.id where groupBuyId = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($groupBuyID) );
            }

            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    return $row["product_total"];
                }
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }

    public function getAllOrdersTotalPoundsByType ($groupBuyID, $type) {
        try {
            $pdo = $this->pdoObject;
            if (empty($groupBuyID)) {
                $sql = "select SUM(amount*pounds) as product_total from user_order join product on user_order.productID = product.id where product.type = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($type));
            } else {
                $sql = "select SUM(amount*pounds) as product_total from user_order join product on user_order.productID = product.id where groupBuyId = ? and product.type = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($groupBuyID, $type) );
            }

            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    return $row["product_total"];
                }
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }

    public function getUserOrderTotalPounds ($groupBuyId, $user) {
        try {
            $pdo = $this->pdoObject;
            if (empty($groupBuyId)) {
                $sql = "select SUM(amount*pounds) as product_total from user_order join product on user_order.productID = product.id where email = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($user->getEmail()));
            } else {
                $sql = "select SUM(amount*pounds) as product_total from user_order join product on user_order.productID = product.id where groupBuyId = ? AND email = ?";
                $sth=$pdo->prepare($sql);
                $sth->execute(array ($groupBuyId, $user->getEmail()));
            }

            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    return $row["product_total"];
                }
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }

}