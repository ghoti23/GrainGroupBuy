<?php
$expiredOrders = $orderDao -> getOrderHistory($user);
$poundsTotal = $orderDao -> getAllOrdersTotalPounds(null);
$userTotal = $orderDao -> getUserOrderTotalPounds(null, $user);
$totalMembers = $userDao -> getTotalMembers();
?>
<?php if (isset($activeGroupBuy)) {  ?>
<div id="current-order" class="well">
    <?php include_once("includes/order-detail-nav.php")?>
</div>
<?php } ?>
<div class="hidden-sm hidden-xs">
    <?php include("general-nav.php")?>
</div>