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
require 'utils.php';
session_start(); ?>
<html>
<head>
    <?php include_once("analyticstracking.php") ?>
</head>
<body>
<?php
if (!$_SESSION['admin'])  {
    header("location:dashboard.php");
}
$groupBuyID = strip_tags($_REQUEST["id"]);

$orderDao = new orderDao();
$orderDao->connect($host,$pdo);
$groupBuyTotal= $orderDao->getTotalPounds($groupBuyID);

$groupBuyDao = new groupBuyDao();
$groupBuyDao->connect($host,$pdo);

$userDao = new userDao();
$userDao->connect($host,$pdo);

$user = $_SESSION['user'];

$userOrders = $groupBuyDao->getGroupBuyUsers($groupBuyID);
$utils = new utils();


$groupBuy = $groupBuyDao->get($groupBuyID);

$shipping = number_format(($groupBuy->getShipping()/$groupBuyTotal),3);

foreach ($userOrders as $userOrder) {
    $user = $userOrder->getUser();
    $orderTotal = 0;

    $orderProduct=$orderDao->getGroupBuyProductOrder($groupBuyID,$user->getEmail());
    foreach ($orderProduct as $i => $value) {

        $order = $orderProduct[$i];
        $product = $order->getProduct();
        $ID=$product->getId();
        $vendor=$product->getVendor();
        $name=$product->getName();
        $amount=$order->getAmount();
        $pound=$product->getPounds()*$amount;
        $itemShipping=$shipping*$pound;
        $price=$utils->getMarkupPrice($user,$product,$groupBuy);
        $total=$price*$amount;

        $foodTaxes=0;
        $nonFoodTaxes=0;

        if ($groupBuy->getTax()) {

            if ($product->getType() == "grain" || $product->getType() == "hops") {
                $foodTaxes=($total*$foodTax);
            } else {
                $nonFoodTaxes=$tax+($total*$otherTax);
            }
        }
        $taxTotal = $foodTaxes+$nonFoodTaxes+$total;
        $orderTotal=$taxTotal+$orderTotal+$itemShipping;
    }
    $orderSplit=$orderDao->getGroupBuyGrainSplitOrder($groupBuyID,$user->getEmail());

    foreach ($orderSplit as $row) {
        $product = Product::mapRow($row);
        $ID=$row["id"];
        $vendor=$row["vendor"];
        $name=$row["name"];
        $amount=$row["amount"];
        $pound=$product->getPounds()/$row["splitAmt"];
        $itemShipping=$shipping*($pound*$amount);
        $price=$utils->getMarkupPrice($user,$product,$groupBuy)/$row["splitAmt"];
        $total=$price*$amount;

        $foodTaxes=0;
        $nonFoodTaxes=0;

        if ($groupBuy->getTax()) {
            if ($product->getType() == "grain" || $product->getType() == "hops") {
                $foodTaxes=($total*$foodTax);
            } else {
                $nonFoodTaxes=$tax+($total*$otherTax);
            }
        }
        $taxTotal = $foodTaxes+$nonFoodTaxes+$total;
        $orderTotal=$taxTotal+$orderTotal+$itemShipping;
    }
    echo  $user->getUsername() . ',' . $user->getEmail() . ',' .number_format($orderTotal,2).'<br />';
}


function round_up ( $value, $precision ) {
    $pow = pow ( 10, $precision );
    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
}
?>

</body>
</html>