<?php
require 'dao/splitDao.php';
require 'dao/userDao.php';
require 'dao/groupBuyDao.php';
require 'dao/orderDao.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/user.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
session_start();

$splitDao = new splitDao();
$splitDao->connect($host,$pdo);
$user = $_SESSION['user'];
$adminUser = "";
if (isset($_REQUEST["user"])) {
    $adminUser = strip_tags($_REQUEST["user"]);
}
$groupBuyId = strip_tags($_REQUEST["groupBuy"]);
$splitId = strip_tags($_REQUEST["id"]);

$redirect = "location:viewGroupBuy.php?id=".$groupBuyId;

if (($adminUser != "") && $_SESSION['admin']) {
	$user = $dao->getUser($adminUser);
	$redirect = $redirect."&user=".$adminUser;
	$adminUpdate=true;
}

$splitId = strip_tags($_REQUEST["id"]);
$success = $splitDao->add($splitId,1,$user->getEmail());

header($redirect);

?>