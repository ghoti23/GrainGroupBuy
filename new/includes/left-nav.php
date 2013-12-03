<?php
if (isset($_SESSION['activeGroupBuy'])){
    $expiredOrders = $orderDao -> getOrderHistory($user);
    $groupBuyTotal = $orderDao -> getAllOrdersTotalPounds($activeGroupBuy);
    $userTotal = $orderDao -> getUserOrderTotalPounds($activeGroupBuy, $user);
    $totalMembers = $userDao -> getTotalMembers();
}
?>

<div id="current-order" class="well">
    <?php if (isset($activeGroupBuy)) {  ?>
        <?php include_once("includes/order-detail-nav.php")?>
    <?php } ?>
</div>
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
    <h4>Statistics</h4>
    <dl>
        <dt>Total Members: <span><?php print $totalMembers; ?></span></dt>
        <dd></dd>
    </dl>
    <dl>
        <dt>Purchased Pounds<br/>(Everyone): <span><?php print round($groupBuyTotal); ?> lbs</span></dt>
        <dd></dd>
    </dl>
    <dl>
        <dt>Purchased Pounds<br/>(You): <span><?php print round($userTotal); ?> lbs</span></dt>
        <dd></dd>
    </dl>
</div>