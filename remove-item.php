<?php
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';

session_start();
if (!isset($_SESSION['user'])){
    header("location:/new/index.php");
}

if (!isset($_SESSION['activeGroupBuy'])){
    header("location:/new/order.php");
}

$user = $_SESSION['user'];
$order_id = $_SESSION['activeGroupBuy'];
$orderDao = new orderDao();
$orderDao -> connect($host, $pdo);
$id = strip_tags($_REQUEST["id"]);
$orderDao->removeProduct($order_id, $id, $user);

header("location:/new/order.php");

?>