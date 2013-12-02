<?php
require '../dao/groupBuyDao.php';
require '../dao/userDao.php';
require '../dao/orderDao.php';
require '../dao/productDao.php';
require '../entity/user.php';
require '../entity/groupbuy.php';
require '../entity/order.php';
require '../entity/product.php';
require '../entity/split.php';
require '../properties.php';
require '../utils.php';

session_start();
if (!isset($_SESSION['user'])){
    header("location:/new/index.php");
}

if (!isset($_REQUEST["id"])){
    $order_id = $_SESSION['activeGroupBuy'];
} else {
    $order_id = strip_tags($_REQUEST["id"]);
}

$user = $_SESSION['user'];

$orderDao = new orderDao();
$orderDao -> connect($host, $pdo);
$order = $orderDao->get($order_id, $user);
$order_products = $order -> getProduct();

$groupBuyDao = new groupBuyDao();
$groupBuyDao -> connect($host, $pdo);
$currentGroupBuy = $groupBuyDao -> get($order_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art of Beer Brewery - Group Buy - Order Detail</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="container">
    <div class="body-spacer">
        <div class="row">
            <div class="col-md-3">
                <?php include_once("includes/left-nav.php")?>
            </div>
            <div class="col-md-7">
                <div class="well light">
                    <h4>Order Details</h4>
                    <form class="product-info" action="/new/order.php" method="post">
                        <?php
                        if (!empty($order_products)) {
                        ?>
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total = 0;
                            $foodTotal = 0;
                            $otherTotal = 0;
                            foreach ($order_products as $product) {
                                $price = $utils->getMarkupPrice($user, $product, $currentGroupBuy);
                                $totalPrice = $price * $product->getAmount();
                                $total = $total + $totalPrice;
                                if ($product->getType() == 'grain' || $product->getType() == 'hops') {
                                    $foodTotal = $foodTotal + ($price*$product->getAmount());
                                } else {
                                    $otherTotal = $otherTotal + ($price*$product->getAmount());
                                }
                                ?>
                                <tr>
                                    <td><?php print $product->getId()?></td>
                                    <td class="ue"><em><?php print $product->getName() . "</em><div>" . $product->getVendor() . "</div>"?></td>
                                    <td>
                                        <?php print $product->getUnits() . " @ " . '$' . $price ?>
                                    </td>
                                    <td><?php print $product->getAmount()?></td>
                                    <td><?php print '$' . number_format($totalPrice, 2)?></td>
                                    <td><a href="/new/remove-item.php?id=<?php print $product->getId()?>">Remove</a></td>
                                </tr>
                            <?php
                            }
                            ?>

                            <?php
                            if ($currentGroupBuy -> getShipping() != "") {
                                $shipping = $groupBuy -> getShipping();
                                $shipping = number_format(($shipping / $groupBuyTotal),3);
                                $shippingCosts = $shipping * $totalPounds;
                                $total = $total + $shippingCosts;
                            ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><strong>Shipping:</strong></td>
                                    <td><?php print '$' . number_format($shippingCosts, 2)?></td>
                                </tr>
                            <?php
                            }
                            ?>

                            <?php
                            if ($currentGroupBuy->getTax()) {
                                $tax=($foodTotal*$foodTax);
                                $tax=$tax+($otherTotal*$otherTax);
                                $total=$total+$tax;
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><strong><?php print 'Tax<br/> (Food = '.($foodTax*100).'%)<br/>(Nonfood = '. ($otherTax*100).'%)' ?></strong></td>
                                    <td><?php print '$' . number_format($tax, 2)?></td>
                                </tr>
                            <?php
                            }
                            ?>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><strong>Total:</strong></td>
                                <td><?php print '$' . number_format($total, 2)?></td>
                            </tr>
                            </tbody>
                        </table>
                        <?php } else {  ?>
                            <dl>
                                <dt>The order is empty.</dt>
                                <dd></dd>
                            </dl>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <div class="col-md-2">
                <?php include_once("includes/right-nav.php")?>
            </div>
        </div>
    </div>

</div>
<?php include_once("includes/footer.php")?>
</body>
</html>