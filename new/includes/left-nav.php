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
<div class="well">
    <h4>History</h4>
    <div>
        <?php
        if (!empty($expiredOrders)) {
        foreach ($expiredOrders as $i => $value) {
            $expiredOrder = $expiredOrders[$i];
        ?>
            <dl>
                <dt><a href="/new/order.php?id=<?php print $expiredOrder->getId()?>"><?php print $expiredOrder->getName()?></a></dt>
                <dd><?php print $expiredOrder->getFormattedEndDate()?> <span></span></dd>
            </dl>
        <?php } ?>
        <?php } else {  ?>
            <dl>
                <dt>You have no previous orders.</dt>
                <dd></dd>
            </dl>
        <?php } ?>
    </div>
</div>
<div class="well">
    <h4>Site Statistics</h4>
    <dl>
        <dt>Total Members: <span><?php print number_format($totalMembers); ?></span></dt>
        <dd></dd>
    </dl>
    <dl>
        <dt>Purchased Pounds<br/>(Everyone): <span><?php print number_format(round($poundsTotal)); ?> lbs</span></dt>
        <dd></dd>
    </dl>
    <dl>
        <dt>Purchased Pounds<br/>(You): <span><?php print number_format(round($userTotal)); ?> lbs</span></dt>
        <dd></dd>
    </dl>
</div>