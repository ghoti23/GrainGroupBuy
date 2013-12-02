<?php require '../../dao/splitDao.php'; ?>
<?php require '../../properties.php'; ?>
<?php require '../../entity/product.php'; ?>
<?php require '../../entity/groupbuy.php'; ?>
<?php require '../../entity/user.php'; ?>
<?php session_start(); ?>
<?php
$splitDao = new splitDao();
$splitDao->connect($host,$pdo);
header('Content-type: application/json');
if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
    $arr = array('message' => "not authenticated");
    json_encode($arr);
}
$user = $_SESSION['user'];

$id = strip_tags($_REQUEST["id"]);
$groupBuy = strip_tags($_REQUEST["groupBuy"]);

echo $splitDao->add($id, $user->getEmail())
?>