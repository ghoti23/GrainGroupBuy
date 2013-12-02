<?php
class dao {	
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
	
	public function getGroupBuyParticipants($groupBuyID){
		$sql="select distinct u.username_txt from groupbuy g left join groupbuy_split gs on g.ID = gs.groupbuy_ID left join user_groupbuy ug on  g.ID = ug.groupbuy_ID left join user_product up on  g.ID = ug.groupbuy_ID left join user_split us on gs.split_ID = us.split_ID left join user u on u.email_txt = us.email_txt or u.email_txt = up.email_txt or u.email_txt = ug.email_txt where g.ID = ?";
		$pdo = $this->pdoObject;
		$sth=$pdo->prepare($sql);
		$sth->execute(array ($email, $splitId) );	
		$results = $sth->fetchAll();
		return $results;		
	}
	
	

	

	
	public function addGroupBuySplit($splitId,$quantity,$email) {
		try {
			$sql = "select * from user_split where email_txt = ? and split_ID = ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($email, $splitId) );	
			$results = $sth->fetchAll();
			$quantity=0;
			foreach ($results as $row) {
				$quantity =  $row["quantity_int"];
			}
			if ($quantity == "") {
				$quantity=0;
			}

			if ($quantity > 0) {
				$quantity = $quantity+1;
				$sql = "UPDATE user_split set quantity_int = ? where email_txt = ? and split_ID = ?";
				$sth=$pdo->prepare($sql);
				$sth->execute(array ( $quantity,$email,$splitId) );
			} else {
				$sql = "INSERT INTO user_split (quantity_int, email_txt, split_ID) VALUES (?,?,?)";			
				$sth=$pdo->prepare($sql);
				$sth->execute(array ( 1,$email,$splitId) );				
			}				

		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	public function subtractGroupBuySplit($splitId,$quantity,$email) {
		try {
			$sql = "select quantity_int from user_split where email_txt = ? and split_ID = ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($email, $splitId) );	
			$results = $sth->fetchAll();
			foreach ($results as $row) {
				$quantity =  $row["quantity_int"];
			}
			
			$quantity = $quantity-1;
			
			$sql = "UPDATE user_split set quantity_int = ? where email_txt = ? and split_ID = ?";
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $quantity,$email,$splitId) );
				

		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}






	

	public function getGroupBuyGrainOrder($groupbuy,$user) {
		try {
			$sql = "SELECT distinct email_txt,groupbuy_ID,amount_int, graintype.ID, graintype.name_txt as grain_name, vendor_txt, pounds_int, price2000_txt, price4000_txt, price8000_txt, price12000_txt, price32000_txt from groupbuy left join user_groupbuy on groupbuy.ID = user_groupbuy.groupbuy_ID join graintype on graintype.ID = user_groupbuy.grain_ID WHERE groupbuy.ID = ? and user_groupbuy.email_txt = ? ORDER BY graintype.name_txt";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupbuy,$user) );
			$results = $sth->fetchAll();		
			$orders = Order::loadOrders($results);
			return $orders;
		} catch (Exception $e) {
			echo $e->getMessage();		
		}
	}
	
	public function getGroupBuyProductsOnly($groupbuy) {
		try {
			$sql = "SELECT DISTINCT user.email_txt,user_product.groupbuy_ID,user_product.amount_int,product.product_ID,product.type_txt,product.name_txt,product.price_txt,product.description_txt,product.vendor_txt FROM groupbuy JOIN user_product ON groupbuy.ID = user_product.groupbuy_ID JOIN product ON product.product_ID = user_product.product_ID JOIN user ON user_product.email_txt = user.email_txt LEFT JOIN user_groupbuy ON groupbuy.ID = user_groupbuy.groupbuy_ID AND user_groupbuy.email_txt = user.email_txt where grain_ID is null and groupbuy.ID=?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupbuy) );
			$results = $sth->fetchAll();		
			$orders = Order::loadOrders($results);
			return $orders;
		} catch (Exception $e) {
			echo $e->getMessage();		
		}	
	}
	


	public function getGroupBuyProductSplitOrder($groupbuy,$user) {
		try {
			$sql = "SELECT s.split_int,us.email_txt, u.username_txt,p.product_ID, p.price_txt AS product_price, p.vendor_txt AS product_vendor, p.name_txt AS product_name, quantity_int,pounds_int AS total FROM groupbuy_split gs JOIN split s ON gs.split_ID = s.split_ID JOIN product p ON s.product_ID = p.product_ID  JOIN user_split us ON us.split_ID = s.split_ID JOIN user u ON us.email_txt = u.email_txt WHERE gs.groupbuy_ID = ? AND u.email_txt = ? ";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupbuy,$user) );
			$results = $sth->fetchAll();		
			return $results;
		} catch (Exception $e) {
			echo $e->getMessage();		
		}
	}	


	public function loadUser ($email) {
		try {
			$sql = 'Select * from user where email = ?';
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($email) );
			$results = $sth->fetchAll();
			$user = User::load($results);
			
			return $user;
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}	
	}
		




	public function selectAllGroupBuy () {
		try {
			$sql = 'Select distinct `groupbuy`.`ID`,`groupbuy`.`name_txt`,`owner`.`username_txt` AS `owner_txt`,`owner`.`email_txt` AS `ownerEmail_txt`,`groupbuy`.`start_dt`,`groupbuy`.`end_dt` from `groupbuy` `groupbuy` join `user` `owner` on `owner`.`email_txt` = `groupbuy`.`owner_txt` left join `user_groupbuy` on `groupbuy`.`ID` = `user_groupbuy`.`groupbuy_ID` left join `user` on `user`.`email_txt` = `user_groupbuy`.`email_txt` left join `graintype` on `graintype`.`ID` = `user_groupbuy`.`grain_ID`  order by start_dt';
			$pdo = $this->pdoObject;
			$results=$pdo->query($sql);
			$orders = GroupBuy::loadGroupBuys($results);				
			return $orders;
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}	
	}
	public function selectOwnerGroupBuy ($user) {
		try {
			$sql = 'Select distinct `groupbuy`.`ID`,`groupbuy`.`name_txt`,`owner`.`username_txt` AS `owner_txt`,`owner`.`email_txt` AS `ownerEmail_txt`,`groupbuy`.`start_dt`,`groupbuy`.`end_dt` from `groupbuy` `groupbuy` join `user` `owner` on `owner`.`email_txt` = `groupbuy`.`owner_txt` left join `user_groupbuy` on `groupbuy`.`ID` = `user_groupbuy`.`groupbuy_ID` left join `user` on `user`.`email_txt` = `user_groupbuy`.`email_txt` left join `graintype` on `graintype`.`ID` = `user_groupbuy`.`grain_ID`  where (end_dt > CURRENT_DATE() or end_dt is null) and owner.email_txt = ? and start_dt <= CURRENT_DATE()';
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $user->get_email() ) );
			$results = $sth->fetchAll();
			$orders = GroupBuy::loadGroupBuys($results);				
			return $orders;
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}	
	}
	

	
	public function getGrainTotalPounds ($groupBuyID) {
		try {
			$sql = "select SUM(amount_int*pounds_int) as grain_total from user_groupbuy join graintype on user_groupbuy.grain_ID = graintype.ID where groupbuy_ID = ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupBuyID) );
			$results = $sth->fetchAll();
			if ($results != null) {
				foreach ($results as $row) {
					return $row["grain_total"];
				}
			} else {
				return 0;
			}	
		} catch (Exception $e) {
			echo "Error: ". $e->getMessage();
		}
	}


	public function activeGroupBuy($groupBuyID) {
		try {
			$sql = "select groupbuy.ID from groupbuy where (end_dt >= CURRENT_DATE() or end_dt is null) and start_dt <= CURRENT_DATE()";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupBuyID) );
			$results = $sth->fetchAll();

			$ID = 0;

			foreach ($results as $row) {
				$ID = $row["ID"];
			}
			if ($ID > 0) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}		
	}


	public function selectGroupBuyOrderSplit($groupBuy, $user) {
		try {
			$sql = "SELECT *,g.name_txt as grain_name,p.name_txt as product_name, available FROM user_split us join groupbuy_split gs on us.split_ID = gs.split_ID join split s on us.split_ID = s.split_ID join splitavailable_view sav on sav.split_ID = s.split_ID  left join graintype g on g.ID = s.grain_ID  left join product p on p.product_ID = s.product_ID where gs.groupbuy_ID = ? and us.email_txt = ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupBuy,$user->get_email()) );
			$results = $sth->fetchAll();
			$orders = Split::loadSplits($results);
			return $orders;
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
    }

	public function getGrain($id) {
		try {
			$sql = "Select *,name_txt as grain_name from graintype where ID=?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($id) );
			$results = $sth->fetchAll();
			$grain = Grain::load($results);			
			return $grain;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function getProduct($id) {
		try {
			$sql = "Select *,name_txt as product_name from product where product_ID=?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($id) );
			$results = $sth->fetchAll();
			$product = Product::load($results);			
			return $product;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function selectAllGrain() {
		try {
			$sql = 'Select *,name_txt as grain_name from graintype';
			$pdo = $this->pdoObject;
			$results=$pdo->query($sql);
			$grains = Grain::loadMultiple($results);
			return $grains;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	
	//User functions
	public function addUser($user) {
		try {
			//Check to make sure email_txt and username_txt are not in use
			$sql = "Select * FROM user email_txt = ? or username_txt=?";

			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($user->getEmail(), $user->getUsername()) );
			$count = $sth->rowCount();

			if ($count == 0) {
				$sql = "INSERT INTO user (email,username,password,state,city) VALUES (?,?,?,?,?)";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute( array ($user->getEmail(), $user->getUsername(), $user->getPassword(), $user->getState(), $user->getCity()) );
				return true;
			} else {
				return false;
			}
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function login($user) {
		try {
			$sql = "Select * FROM user where email_txt = ? and password_txt = ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $user->getEmail(),$user->get_password() ) );
			$count = $sth->rowCount();		

			if ($count == 0) {
				return null;
			} else {
				$x=0;
				$results = $sth->fetchall();
				$user = new User();
				foreach ($results as $row) {
					$user->set_username($row["username_txt"]);
					$user->set_email($row["email_txt"]);
					$user->set_admin($row["admin_flag"]);
					$user->set_approve($row["approved_flag"]);	
				}	
				return $user;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}
	public function getUser($email) {
		try {
			$sql = "Select * FROM user where email_txt = ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $email ) );
			$count = $sth->rowCount();		

			if ($count == 0) {
				return null;
			} else {
				$x=0;
				$results = $sth->fetchall();
				$user = new User();
				foreach ($results as $row) {
					$user->set_username($row["username_txt"]);
					$user->set_email($row["email_txt"]);
					$user->set_admin($row["admin_flag"]);
					$user->set_approve($row["approved_flag"]);	
				}	
				return $user;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}	
	public function confirm($user,$confirmation) {
		try {
			$sql = "Select * FROM user where email_txt = ? and password_txt = ?";			
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $user->get_email(),$confirmation ) );
			$count = $sth->rowCount();		

			if ($count == 0) {
				return false;
			} else {
				$sql = "UPDATE user SET approved_flag=1 where email_txt=?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute( array ($user->get_email()) );
				return true;				
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}
	
	public function adminConfirm($user,$confirmation) {
		try {
			$sql = "Select * FROM user where email_txt = ? and password_txt = ?";						
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $user,$confirmation ) );
			$count = $sth->rowCount();		

			if ($count == 0) {
				return false;
			} else {
				$sql = "UPDATE user SET approved_flag=1 where email_txt=?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute( array ($user) );
				return true;				
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}	
	}
	
	public function confirmUserList() {
		try {
			$sql = "Select * from user where approved_flag = 0 or approved_flag is null";
			$pdo = $this->pdoObject;
			$results=$pdo->query($sql);
			$users = User::loadMultiple($results);	
			return $users;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function findGrain($searchString) {
		try {
			$sql = "Select *,name_txt as grain_name from graintype where (ID like '%".$searchString."%' OR name_txt like '%" . $searchString . "%' OR vendor_txt like '%". $searchString."%') and deactive=0 ORDER BY vendor_txt,grain_name";
			$pdo = $this->pdoObject;
			$results=$pdo->query($sql);
			$grains = Grain::loadMultiple($results);
			return $grains;			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function findOther($searchString) {
		try {
			$sql = "Select *,name_txt as product_name from product where (product_ID like '%".$searchString."%' OR name_txt like '%" . $searchString . "%' OR vendor_txt like '%". $searchString."%') and deactive=0 ORDER BY vendor_txt,product_name";
			$pdo = $this->pdoObject;
			$results=$pdo->query($sql);
			$products = Product::loadMultiple($results);
			return $products;			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function fullGroupBuyOrder($user,$groupBuyID) {
		try {
			$sql = "SELECT distinct * from groupbuy left join user_product on groupbuy.ID = user_product.groupbuy_ID left join user_groupbuy on groupbuy.ID = user_groupbuy.groupbuy_ID inner join graintype on grain_ID = graintype.ID WHERE groupbuy.ID = ? GROUP BY user_groupbuy.email_txt";			
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupBuyID) );
			$results = $sth->fetchall();
			$groupBuy = GroupBuy::loadGroupBuy($results);		
			$orders = Order::loadOrders($results);
			$groupBuy->set_order($orders);			
			return $groupBuy;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}	

	public function fullGroupBuyOrderProduct($groupBuyID) {
		try {
			//Loads full bags
			$sql = "SELECT vendor_txt, product.product_ID, product.name_txt, pounds_int, SUM( amount_int ) AS amount, price_txt FROM groupbuy INNER JOIN user_product ON user_product.groupbuy_ID = groupbuy.ID INNER JOIN product ON product.product_ID = user_product.product_ID  WHERE groupbuy.ID=? GROUP BY product_ID ORDER BY vendor_txt, product_ID";			
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupBuyID) );
			$results = $sth->fetchall();
			$grains = Product::loadMultiple($results);
			$grainArray = array();
			foreach ($grains as $i => $value) {
				$grain = $grains[$i];
				$grainArray[$grain->get_ID()] = $grain;
			}
			//Loads split bags
			$sql = "select vendor_txt,p.product_ID,name_txt,pounds_int, count(p.product_ID) as amount, price_txt from split s join groupbuy_split gs on s.split_ID = gs.split_ID and groupbuy_id = ? join product p on s.product_ID = p.product_ID where s.product_ID is not null group by p.product_ID";			
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ($groupBuyID) );
			$results = $sth->fetchall();
			$grains = Product::loadMultiple($results);
			foreach ($grains as $i => $value) {
				$splitGrain = $grains[$i];
				if (array_key_exists($splitGrain->get_ID(), $grainArray)) {
					$grain = $grainArray[$splitGrain->get_ID()];
					$grain->set_amount($grain->get_amount()+$splitGrain->get_amount());
					$grainArray[$splitGrain->get_ID()] = $grain;
				} else {
					$grainArray[$splitGrain->get_ID()] = $splitGrain;
				}

			}
			return $grainArray;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}		
	public function addGrainOrder($groupBuy_ID,$amount_int,$grain_ID,$user) {
		try {
			$sql = "Select amount_int FROM user_groupbuy where email_txt = ? and grain_ID = ? and groupbuy_ID= ?";
			$pdo = $this->pdoObject;
			$sth=$pdo->prepare($sql);
			$sth->execute(array ( $user->get_email(),$grain_ID,$groupBuy_ID ) );
			$count = $sth->rowCount();	
			if ($count == 0) {	
				$sql = "INSERT INTO user_groupbuy (email_txt, groupbuy_ID, grain_ID, amount_int) VALUES (?, ?, ?, ?)";			
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ( $user->get_email(),$groupBuy_ID,$grain_ID,$amount_int) );
			} else {
				$sql = "UPDATE user_groupbuy set amount_int = ? where groupbuy_ID = ? and email_txt = ? and grain_ID = ?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($amount_int,$groupBuy_ID,$user->get_email(),$grain_ID) );
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function removeGrainOrder($groupBuy_ID,$grain_ID,$user) {
		$sql = "DELETE from user_groupbuy where groupbuy_ID = ? and grain_ID = ? and email_txt = ?";
		$pdo = $this->pdoObject;
		$sth=$pdo->prepare($sql);
		$sth->execute(array ($groupBuy_ID,$grain_ID,$user->get_email()) );
	}

	public function removeSplitOrder($groupBuy_ID,$split_ID,$user) {
		$sql = "DELETE from user_split where split_ID = ? and email_txt = ?";
		$pdo = $this->pdoObject;
		$sth=$pdo->prepare($sql);
		$sth->execute(array ($split_ID,$user->get_email()) );
		
		$sql = "Select (split_int - available) as amount_left from split s, splitavailable_view sav where s.split_id = sav.split_id";
		$pdo = $this->pdoObject;
		$sth->execute(array ($split_ID) );
		$results = $sth->fetchall();
		foreach ($results as $row) {
			if ($row["amount_left"] == 0) {
				$sql = "DELETE from split where split_ID = ?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($split_ID) );
				
				$sql = "DELETE from groupbuy_split where split_ID = ?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($split_ID) );
			}
		}		
			
			
		
	}	
	



	
	public function updateGrainOrder($groupBuy_ID,$amount_int,$grain_ID,$user) {
		try {	
			if ($amount_int == 0) {	
				$sql = "DELETE FROM user_groupbuy where groupbuy_ID = ? and email_txt = ? and grain_ID = ?";		
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($groupBuy_ID,$user->get_email(),$grain_ID) );
			} else {
				$sql = "UPDATE user_groupbuy set amount_int = ? where groupbuy_ID = ? and email_txt = ? and grain_ID = ?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($amount_int,$groupBuy_ID,$user->get_email(),$grain_ID) );
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}	
	public function updateProductOrder($groupBuy_ID,$amount_int,$product_ID,$user) {
		try {	
			if ($amount_int == 0) {	
				$sql = "DELETE FROM user_product where groupbuy_ID = ? and email_txt = ? and product_ID = ?";		
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($groupBuy_ID,$user->get_email(),$product_ID) );
			} else {
				$sql = "UPDATE user_product set amount_int = ? where groupbuy_ID = ? and email_txt = ? and product_ID = ?";
				$pdo = $this->pdoObject;
				$sth=$pdo->prepare($sql);
				$sth->execute(array ($amount_int,$groupBuy_ID,$user->get_email(),$product_ID) );
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	

}
?>