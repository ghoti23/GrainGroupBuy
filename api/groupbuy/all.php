<?php
require '../../dao/dao.php';
require '../../dao/productDao.php';
require '../../dao/groupBuyDao.php';
require '../../entity/groupbuy.php';
require '../../entity/product.php';
require '../../properties.php';
session_start();

$groupBuyDao = new groupBuyDao();
$groupBuyDao->connect($host,$pdo);
$groupBuys = $groupBuyDao->all();


header('Content-type: application/json');
echo json_encode((array)$groupBuys, JSON_PRETTY_PRINT);
?>