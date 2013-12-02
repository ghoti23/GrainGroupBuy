<?php
require '../../dao/orderDao.php';
require '../../properties.php';

$groupBuyId = strip_tags($_REQUEST["id"]);
$email = strip_tags($_REQUEST["user"]);
$paid = strip_tags($_REQUEST["paid"]);
$dao = new orderDao();
$dao -> connect($host, $pdo);
$dao->paid($groupBuyId,$email,$paid);
$link = "location:../../startGroupBuy.php?id=".$groupBuyId;
header($link);
?>