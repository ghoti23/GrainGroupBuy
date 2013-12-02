<?php require 'dao.php'; ?>
<?php require 'groupbuy.php'; ?>
<?php require 'grain.php'; ?>
<?php require 'order.php'; ?>
<?php require 'user.php'; ?>
<?php require 'product.php'; ?>
<?php require 'split.php'; ?>
<?php require 'properties.php'; ?>
<?php session_start(); ?>
<?php
$dao = new dao();
$dao->connect($host,$pdo);
$user = $_SESSION['user'];

$id = strip_tags($_REQUEST["id"]);
$grainID = strip_tags($_REQUEST["grainID"]);

$dao->removeGrainOrder($id,$grainID,$user);

$link = "location:viewGroupBuy.php?id=" . $id;
header($link);
?>