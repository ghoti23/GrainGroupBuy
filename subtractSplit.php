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

$groupBuyId = strip_tags($_REQUEST["groupBuy"]);
$splitID = strip_tags($_REQUEST["id"]);
$adminUser="";
if (isset($_REQUEST["user"])) {
    $adminUser = strip_tags($_REQUEST["user"]);
}
$redirect = "location:viewGroupBuy.php?id=".$groupBuyId;
if (($adminUser != "") && $_SESSION['admin']) {
    $userDao = new userDao();
    $userDao->connect($host,$pdo);
    $user = $userDao->getUser($adminUser);
    $redirect = $redirect."&user=".$adminUser;
    $adminUpdate=true;
}
$splitDao->subtract($splitID,$user->getEmail());
//header($redirect);
?>