<h4 class="head">
    <a href="/new/order.php?id=<?php print $activeGroupBuy?>" class="pull-right">Edit</a>
    My Order
</h4>
<?php
$total = 0;
$currentOrderProducts = $currentOrder->getProduct();
if (!empty($currentOrderProducts)) {
    foreach ($currentOrderProducts as $product) {
        $price = $utils->getMarkupPrice($user, $product, $groupBuy);
        $totalPrice = $price * $product->getAmount();
        $total = $total + $totalPrice;
        ?>
        <dl>
            <dt><?php print $product->getName()?> - <?php print $product->getVendor()?></dt>
            <dd><?php print $product->getUnits()?> @ <?php print '$' . $price?> <span><?php print '$' . number_format($totalPrice, 2)?></span></dd>
        </dl>
    <?php } ?>
<?php } else {  ?>
    <h4>My Order</h4>
    <dl>
        <dt>Your current order is empty.</dt>
        <dd></dd>
    </dl>
<?php } ?>
<dl>
    <dt class="total">
        Total:
        <span><a href="/new/order.php?id=<?php print $activeGroupBuy?>"><?php print '$' . number_format($total, 2)?></a></span></dt>
    <dd></dd>
</dl>