<?php require 'dao.php'; ?>
<?php require 'groupbuy.php'; ?>
<?php require 'grain.php'; ?>
<?php require 'order.php'; ?>
<?php require 'user.php'; ?>
<?php require 'product.php'; ?>
<?php require 'properties.php'; ?>
<!DOCTYPE html 
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Creating worksheets</title>
    <style>
    body {
      font-family: Verdana;      
    }
    </style>    
  </head>
  <body>
    <?php
    // load Zend Gdata libraries
    require_once 'Zend/Loader.php';
    // Gmail email address and password for google spreadsheet
	$user = "chicagogroupbuy@gmail.com";
	$pass = "homebrewing101";

	// Google Spreadsheet ID (You can get it from the URL when you view the spreadsheet)
	$GSheetID = "0AsZE-BcO_kBLdHdWT1NIa2VSM256Z2R3TVhsaEMtVWc";

	// od6 is the first worksheet in the spreadsheet
	$worksheetID="od6";

	// Include the loader and Google API classes for spreadsheets
	require_once('Zend/Loader.php');
	Zend_Loader::loadClass('Zend_Gdata');
	Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
	Zend_Loader::loadClass('Zend_Http_Client');
	
	// Authenticate on Google Docs and create a Zend_Gdata_Spreadsheets object.            
	$service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
	$spreadsheetService = new Zend_Gdata_Spreadsheets($client);

	$feed = $spreadsheetService->getSpreadsheetFeed();
	$spreadsheetKey="";
	$query = new Zend_Gdata_Spreadsheets_ListQuery();
	$query->setSpreadsheetKey($GSheetID);
	$query->setWorksheetId($worksheetID);
    $listFeed = $spreadsheetService->getListFeed($query);
	DeleteWorkSheetData($listFeed,$spreadsheetService);

	$dao = new dao();
	$dao->connect($host,$pdo);
	$user = $_SESSION['user'];
	$groupBuyID = strip_tags($_REQUEST["id"]);
	$users = $dao->getGroupBuyUsers($groupBuyID);
	$groupBuyTotal= $dao->getTotalPounds($groupBuyID);
	foreach ($users as $userList) {
		echo ($userList->get_email() . "<br />");
		$user=$dao->loaduser($userList->get_email());
		$orders=$dao->getGroupBuyGrainOrder($groupBuyID,$user->get_email());
	
		foreach ($orders as $i => $value) {
			$order = $orders[$i];
			$grain = $order->get_grain();
			$ID=$grain->get_ID();
			$vendor=$grain->get_vendor();
			$name=$grain->get_name();
			$pound=$grain->get_pound();
			$amount=$order->get_amount();

			$price = getPrice($grain,$groupBuyTotal);
			$total=$price*$pound*$amount;
			$rowData = array('email' => $order->get_email(), 'username' => $user->get_username(), 'id' => $ID, 'vendor' => $vendor, 'name' => $name, 'price' => number_format($price,2), 'amount' => $pound, 'total' => number_format($total,2), 'split' => 'no');
			$insertedListEntry = $spreadsheetService->insertRow($rowData,$GSheetID,$worksheetID);		
		}
		$orderProduct=$dao->getGroupBuyProductOrder($groupBuyID,$user->get_email());
		foreach ($orderProduct as $i => $value) {	
			$order = $orderProduct[$i];
			$product = $order->get_product();		
			$ID=$product->get_ID();	
			$vendor=$product->get_vendor();		
			$name=$product->get_name();
			$amount=$order->get_amount();			
			$total=$product->get_price()*$amount;
			$rowData = array('email' => $order->get_email(), 'username' => $user->get_username(), 'id' => $ID, 'vendor' => $vendor, 'name' => $name, 'price' => number_format($price,2), 'amount' =>$amount, 'total' => number_format($total,2), 'split' => 'no');
			$insertedListEntry = $spreadsheetService->insertRow($rowData,$GSheetID,$worksheetID);
		}	
		$orderSplit=$dao->getGroupBuySplitOrder($groupBuyID,$user->get_email());
		foreach ($orderSplit as $row) {
			$ID="";
			$price="";
			$vendor="";
			$name="";
			$amount="";

			$amount = $row["total"];
			$splitAmt = $row["split_int"];
			if ($row["grainID"] != null) {
				$grain = new Grain();
				$grain->set_price($row["price2000_txt"]);
				$grain->set_price4000($row["price4000_txt"]);
				$grain->set_price8000($row["price8000_txt"]);
				$grain->set_price12000($row["price12000_txt"]);
				$grain->set_price32000($row["price32000_txt"]);
				$pounds = $row["grain_pounds"]/$splitAmt;
				$ID=$row["grainID"];
				$price = getPrice($grain,$groupBuyTotal);
				$vendor=$row["grain_vendor"];
				$name=$row["grain_name"];
				$rowData = array('email' => $row["email_txt"], 'username' => $row["username_txt"], 'id' => $ID, 'vendor' => $vendor, 'name' => $name, 'price' => number_format($price,2), 'amount' => $pounds, 'total' => number_format(($price*$pounds)*$amount,2), 'split' => 'yes');
				$insertedListEntry = $spreadsheetService->insertRow($rowData,$GSheetID,$worksheetID);
			} else {
				$ID=$row["product_ID"];
				$price=$row["product_price"];
				$vendor=$row["product_vendor"];
				$name=$row["product_name"];
				$rowData = array('email' => $row["email_txt"], 'username' => $row["username_txt"], 'id' => $ID, 'vendor' => $vendor, 'name' => $name, 'price' => number_format($price/$splitAmt,2), 'amount' => $amount, 'total' => number_format(($price/$splitAmt)*$amount,2), 'split' => 'yes');
				$insertedListEntry = $spreadsheetService->insertRow($rowData,$GSheetID,$worksheetID);
			}

			
		}		
			
	}	
	
	echo "Exported File";
	
	function getPrice($grain,$groupBuyTotal) {
		$price=$grain->get_price();
		if ($groupBuyTotal >= 2000 && $groupBuyTotal < 8000) {
			$price=$grain->get_price4000();
		} else if ($groupBuyTotal >= 8000 && $groupBuyTotal < 12000) {
			$price=$grain->get_price8000();
		} else if ($groupBuyTotal >= 12000 && $groupBuyTotal < 32000) {
			$price=$grain->get_price12000();
		} else if ($groupBuyTotal >= 32000) {
			$price=$grain->get_price32000();
		}
		return $price;		
	}
	

	function DeleteWorkSheetData($feed,$spreadSheetService)
	{
		echo "Deleting Files <br />";
		foreach($feed->entries as $row) { 
			$spreadSheetService->deleteRow($row);
		}
	}
    ?>



  </body>
<html>