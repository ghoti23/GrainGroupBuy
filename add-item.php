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
    header("location:index.php");
}

if (!isset($_SESSION['activeGroupBuy'])){
    header("location:index.php");
}

$utils = new Utils;
$user = $_SESSION['user'];

$activeGroupBuy = $_SESSION['activeGroupBuy'];
$groupBuyDao = new groupBuyDao();
$groupBuyDao -> connect($host, $pdo);
$groupBuy = $groupBuyDao -> get($activeGroupBuy);

$productId = strip_tags($_REQUEST["id"]);
$amount = strip_tags($_REQUEST["value"]);

$orderDao = new orderDao();
$orderDao->connect($host,$pdo);
$orderDao->addProduct($activeGroupBuy, $amount, $productId, $user);
$currentOrder = $orderDao -> getOrder($activeGroupBuy, $user);
?>

<?php include_once("includes/order-detail-nav.php")?>