<?php require 'dao/orderDao.php'; ?>
<?php require 'entity/groupbuy.php'; ?>
<?php require 'entity/order.php'; ?>
<?php require 'entity/user.php'; ?>
<?php require 'entity/product.php'; ?>
<?php require 'entity/split.php'; ?>
<?php require 'properties.php'; ?>
<?php session_start(); ?>
<?php
$dao = new orderDao();
$dao->connect($host,$pdo);
$user = $_SESSION['user'];

$groupBuyId = strip_tags($_REQUEST["groupBuyId"]);
$id = strip_tags($_REQUEST["id"]);

$dao->removeProductOrder($groupBuyId,$id,$user);

$link = "location:viewGroupBuy.php?id=" . $groupBuyId;
header($link);
?>