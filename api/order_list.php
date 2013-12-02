<?php
require 'dao/dao.php';
require 'entity/groupbuy.php';
require 'entity/grain.php';
require 'entity/order.php';
require 'entity/user.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
session_start();

$user = $_SESSION['user'];
$orders = $dao -> selectGroupBuyOrder($groupBuyID, $user);
$orderProduct = $dao -> selectGroupBuyOrderProduct($groupBuyID, $user);
$orderSplit = $dao -> selectGroupBuyOrderSplit($groupBuyID, $user);

?>

{
	groupBuyId:"1",
	totalPounds:"123",
	orders : [{
		"id" : "1",
		"name" : "text",
		"vendor" : "text",
		"pounds" : "2",
		"quanity" : "1",
		"price" : "1"
	}]
}
