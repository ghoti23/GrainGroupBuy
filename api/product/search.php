<?php
require '../../dao/dao.php';
require '../../dao/productDao.php';
require '../../dao/groupBuyDao.php';
require '../../entity/groupbuy.php';
require '../../entity/product.php';
require '../../entity/user.php';
require '../../properties.php';
require '../../utils.php';
session_start();

$supplier = "ALL";
$search = strip_tags($_REQUEST["value"]);
$user = $_SESSION['user'];
if ($user == null) {
    header("location:index.php");
}
$productDao = new productDao();
$productDao->connect($host,$pdo);
if(isset($_REQUEST['id'])){
    $groupBuyId = strip_tags($_REQUEST["id"]);
    $groupBuyDao = new groupBuyDao();
    $groupBuyDao->connect($host,$pdo);
    $groupBuy = $groupBuyDao->get($groupBuyId);
    $supplier = $groupBuy->getSupplier();
    $products = $productDao->find($search,$supplier,1);
    $returnProducts = array();
    foreach ($products as $product) {
        $utils = new Utils();
        $product->setPrice($utils->getMarkupPrice($user,$product,$groupBuy));
        array_push($returnProducts,$product);
    }
} else {
    $products = $productDao->find($search,$supplier,0);
}

header('Content-type: application/json');
echo json_encode((array)$products, JSON_PRETTY_PRINT);
?>