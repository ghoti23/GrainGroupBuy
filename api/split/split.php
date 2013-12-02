<?php
    require '../../dao/splitDao.php';
    require '../../dao/orderDao.php';
    require '../../properties.php';
    require '../../entity/product.php';
    require '../../entity/groupbuy.php';
    require '../../entity/user.php';
    session_start();

$splitDao = new splitDao();
$splitDao->connect($host,$pdo);
$user = $_SESSION['user'];
if ($user == null) {
    header("location:index.php");
}


$numOfSplit = strip_tags($_REQUEST["numOfSplit"]);
$productID= strip_tags($_REQUEST["id"]);
$quantity= strip_tags($_REQUEST["quantity"]);
$groupBuy=strip_tags($_REQUEST["groupBuyID"]);
			
//Check to see if user currently has an item available to split
$amount = $splitDao->isSplitAvailable($productID,$user,$groupBuy);

$orderDao = new orderDao();
$orderDao->connect($host,$pdo);
$isSuccess = true;

if ($quantity < $numOfSplit) {
    if ($amount>1) {
        $amount--;
        $orderDao->setProductOrder($groupBuy,$amount,$productID,$user);

    } else if ($amount == 1) {
        $orderDao->removeProductOrder($groupBuy,$productID,$user);
    } else {
        $isSuccess = false;
    }
    if ($isSuccess) {
        $orderDao=null;
        $splitDao->createSplit($numOfSplit,$productID,$quantity,$user,$groupBuy);
    }
}


$link = "location:../../viewGroupBuy.php?id=" . $groupBuy;
header($link);
?>