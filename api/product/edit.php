<?php
require '../../dao/dao.php';
require '../../dao/productDao.php';
require '../../dao/groupBuyDao.php';
require '../../entity/groupbuy.php';
require '../../entity/product.php';
require '../../properties.php';

session_start();
$product = new Product();
if ($_SESSION['admin'] && isset($_REQUEST["id"]))  {

    $product->setId(strip_tags($_REQUEST["id"]));
    if (isset($_REQUEST["name"])) {
        $product->setName(strip_tags($_REQUEST["name"]));
    }
    if (isset($_REQUEST["deactive"])) {
        $product->setDeactive( (strip_tags($_REQUEST["deactive"])));
    } else {
        $product->setDeactive("0");
    }
    if (isset($_REQUEST["country"])) {
        $product->setCountry(strip_tags($_REQUEST["country"]));
    }
    if (isset($_REQUEST["description"])) {
        $product->setDescription(strip_tags($_REQUEST["description"]));
    }
    if (isset($_REQUEST["pounds"])) {
        $product->setPounds($_REQUEST["pounds"]);
    }
    if (isset($_REQUEST["price"])) {
        $product->setPrice(strip_tags($_REQUEST["price"]));
    }
    if (isset($_REQUEST["price4000"])) {
        $product->setPrice4000($_REQUEST["price4000"]);
    }
    if (isset($_REQUEST["price8000"])) {
        $product->setPrice8000($_REQUEST["price8000"]);
    }
    if (isset($_REQUEST["price12000"])) {
        $product->setPrice12000($_REQUEST["price12000"]);
    }
    if (isset($_REQUEST["price32000"])) {
        $product->setPrice32000($_REQUEST["price32000"]);
    }
    if (isset($_REQUEST["supplier"])) {
        $product->setSupplier($_REQUEST["supplier"]);
    }
    if (isset($_REQUEST["split"])) {
        $product->setSplit($_REQUEST["split"]);
    }
    if (isset($_REQUEST["vendor"])) {
        $product->setVendor($_REQUEST["vendor"]);
    }
    if (isset($_REQUEST["type"])) {
        $product->setType($_REQUEST["type"]);
    }
    $productDao = new productDao();
    $productDao->connect($host,$pdo);
    $product = $productDao->edit($product);
}
$link = "location:../../admin_product.php";
header($link);
?>