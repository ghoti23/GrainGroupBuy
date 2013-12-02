<?php
require '../../dao/userDao.php';
require '../../dao/groupBuyDao.php';
require '../../dao/orderDao.php';
require '../../entity/groupbuy.php';
require '../../entity/order.php';
require '../../entity/user.php';
require '../../entity/UserExport.php';
require '../../entity/UserOrder.php';
require '../../entity/product.php';
require '../../entity/split.php';
require '../../properties.php';
require '../../utils.php';

session_start();

$groupBuyId = strip_tags($_REQUEST["id"]);

if (!$_SESSION['admin'])  {
    header("location:dashboard.php");
}
$groupBuyID = strip_tags($_REQUEST["id"]);

$orderDao = new orderDao();
$orderDao->connect($host,$pdo);


$groupBuyDao = new groupBuyDao();
$groupBuyDao->connect($host,$pdo);

$userDao = new userDao();
$userDao->connect($host,$pdo);

$user = $_SESSION['user'];

$users = $groupBuyDao->getGroupBuyUsers($groupBuyID);

$groupBuyTotal= $orderDao->getTotalPounds($groupBuyID);

$groupBuy = $groupBuyDao->get($groupBuyID);

$shipping = number_format(($groupBuy->getShipping()/$groupBuyTotal),3);
$orderTotal = 0;
$outputUser = array();

$utils = new utils();
foreach ($users as $user) {
    $userOrders = array();
    $orderProduct=$orderDao->getGroupBuyProductOrder($groupBuyID,$user->getEmail());

    foreach ($orderProduct as $i => $value) {
        $foodTaxes=0;
        $nonFoodTaxes=0;
        $order = $orderProduct[$i];
        $product = $order->getProduct();
        $userExport = new UserExport();
        $userExport->setAmount($order->getAmount());
        $price=$utils->getMarkupPrice($user,$product,$groupBuy);
        $userExport->setPrice($price);
        $total=$price*$order->getAmount();
        $itemShipping=$shipping*$order->getAmount();
        $userExport->setShipping($itemShipping);
        if ($groupBuy->getTax()) {
            if ($product->getType() == "grain" || $product->getType() == "hops") {
                $foodTaxes=($total*$foodTax);
            } else {
                $nonFoodTaxes=($total*$otherTax);
            }
        }
        $userExport->setFoodTax($foodTaxes);
        $userExport->setNonFoodTax($nonFoodTaxes);
        $userExport->setProductId($product->getID());
        $userExport->setProductName($product->getName());
        $userExport->setVendor($product->getVendor());

        $total = $foodTaxes+$nonFoodTaxes+$itemShipping+$total;
        $userExport->setTotal(number_format($total,2));
        if ($userOrders == null) {
            $userOrders = array($userExport);
        } else {
            array_push($userOrders,$userExport);
        }

    }

    $orderSplit=$orderDao->getGroupBuyGrainSplitOrder($groupBuyID,$user->getEmail());

    foreach ($orderSplit as $row) {
        $product = Product::mapRow($row);
        $userExport = new UserExport();
        $userExport->setAmount($row["amount"] .' of ' .$row["splitAmt"]);
        $price=$utils->getMarkupPrice($user,$product,$groupBuy);
        $userExport->setPrice($price);
        if ($groupBuy->getTax()) {
            if ($product->getType() == "grain" || $product->getType() == "hops") {
                $foodTaxes=($total*$foodTax);
            } else {
                $nonFoodTaxes=($total*$otherTax);
            }
        }
        $userExport->setFoodTax($foodTaxes);
        $userExport->setNonFoodTax($nonFoodTaxes);
        $userExport->setProductId($product->getID());
        $userExport->setProductName($product->getName());
        $userExport->setVendor($product->getVendor());
        $itemShipping=$shipping*$order->getAmount();
        $userExport->setShipping($itemShipping);
        $total=$product->getPrice()*$order->getAmount()+$itemShipping;
        $userExport->setTotal($total);
        if ($userOrders == null) {
            $userOrders = array($userExport);
        } else {
            array_push($userOrders,$userExport);
        }
    }

    $userOrder = new UserOrder();
    $userOrder->setEmail($user->getEmail());
    $userOrder->setUsername($user->getUsername());
    $userOrder->setOrder($userOrders);
    array_push($outputUser,$userOrder);
}
echo json_encode($outputUser);
?>
