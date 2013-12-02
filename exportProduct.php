<?php
require 'dao/userDao.php';
require 'dao/groupBuyDao.php';
require 'dao/orderDao.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/user.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
session_start();
	if (!$_SESSION['admin'])  {
		header("location:dashboard.php");
	}
    $groupBuyID = strip_tags($_REQUEST["id"]);
    $groupBuyDao = new groupBuyDao();
    $groupBuyDao->connect($host,$pdo);

    $orderDao = new orderDao();
    $orderDao->connect($host,$pdo);
    $groupBuyTotal= $orderDao->getTotalPounds($groupBuyID);

	$groupBuyID = strip_tags($_REQUEST["id"]);
	$products = $groupBuyDao->fullGroupBuyOrderGrain($groupBuyID);


	echo "vendor,ID,name,amount,wholesale price,total cost,supplier<br />";
	foreach ($products as $product) {
		if ($product->getType() == "grain") {
            $price = $product->getPrice()*$product->getPounds();
        } else {
            $price = $product->getPrice();
        }
        echo $product->getVendor() . ',' .$product->getId() .','. $product->getName() .',' . $product->getAmount() .','.number_format($price,2).',' . ($price*$product->getAmount()).','.$product->getSupplier(). '<br />';
	}
?>