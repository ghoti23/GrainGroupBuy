<?php
require '../../dao/dao.php';
require '../../dao/productDao.php';
require '../../dao/orderDao.php';
require '../../dao/groupBuyDao.php';
require '../../entity/groupbuy.php';
require '../../entity/product.php';
require '../../entity/user.php';
require '../../properties.php';
session_start();
$productId = strip_tags($_REQUEST["id"]);
$groupBuyId = strip_tags($_REQUEST["groupBuyId"]);
$amount = strip_tags($_REQUEST["value"]);
$user = $_SESSION['user'];

$orderDao = new orderDao();
$orderDao->connect($host,$pdo);
$orderDao->addProductOrder($groupBuyId,$amount,$productId,$user);
header('Content-type: application/json');
$array = ['success' => true];
echo json_encode($array, JSON_PRETTY_PRINT);
?>