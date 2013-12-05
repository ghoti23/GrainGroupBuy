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

$active_edit = false;
if (isset($_SESSION['activeGroupBuy'])) {
    $active_edit = ($_SESSION['activeGroupBuy'] == $order_id);
}

$user = $_SESSION['user'];

$orderDao = new orderDao();
$orderDao -> connect($host, $pdo);
$order = $orderDao->getOrder($order_id, $user);
$order_products = $order -> getProduct();

$groupBuyDao = new groupBuyDao();
$groupBuyDao -> connect($host, $pdo);
$currentGroupBuy = $groupBuyDao -> get($order_id);
$groupBuyTotal = $orderDao -> getAllOrdersTotalPounds($order_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php")?>
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
                    <h3 class="upper">
                        <a class="pull-right link" href="/new/dashboard.php">Back to Products</a>
                        <?php print $currentGroupBuy->getName()?>
                    </h3>
                    <div class="row detail-item">
                        <div class="col-md-2"><h4>Started:</h4></div>
                        <div class="col-md-10"><?php print $currentGroupBuy->getFormattedStartDate()?></div>
                    </div>
                    <div class="row detail-item">
                        <div class="col-md-2"><h4>Ended:</h4></div>
                        <div class="col-md-10"><?php print $currentGroupBuy->getFormattedEndDate()?></div>
                    </div>
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
                                <th <?php if (!$active_edit) { ?>colspan="2"<?php } ?>>Total</th>
                                <?php if ($active_edit) { ?>
                                    <th>&nbsp;</th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total = 0;
                            $foodTotal = 0;
                            $otherTotal = 0;
                            $totalPounds = 0;
                            foreach ($order_products as $product) {
                                $price = $utils->getMarkupPrice($user, $product, $currentGroupBuy);
                                $displayPrice = $utils->getDisplayPrice($user, $product, $groupBuy);
                                $totalPrice = $price * $product->getAmount();
                                $totalPounds = $totalPounds + ($product->getPounds() * $product->getAmount());
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
                                        <?php print $product->getDisplayUnits() . " @ " . '$' . $displayPrice ?>
                                    </td>
                                    <td><?php print $product->getDisplayAmount()?></td>
                                    <td <?php if (!$active_edit) { ?>colspan="2"<?php } ?>><?php print '$' . number_format($totalPrice, 2)?></td>
                                    <?php if ($active_edit) { ?>
                                    <td>
                                        <a href="/new/remove-item.php?id=<?php print $product->getId()?>">Remove</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php
                            }
                            ?>

                            <?php
                            if ($currentGroupBuy -> getShipping() != "") {
                                $shipping = $currentGroupBuy -> getShipping();
                                $shipping = number_format(($shipping / $groupBuyTotal), 3);
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
                                $tax = ($foodTotal*$foodTax);
                                $tax = $tax + ($otherTotal*$otherTax);
                                $total = $total+$tax;
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