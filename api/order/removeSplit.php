<?php require '../../dao/splitDao.php'; ?>
<?php require '../../dao/orderDao.php'; ?>
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

$splitDao->remove($id,$user);
$array = ['success' => true];
echo json_encode($array, JSON_PRETTY_PRINT);
?>