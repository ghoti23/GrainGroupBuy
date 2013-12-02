<?php

if (isset($_SESSION['activeGroupBuy'])){
    $activeGroupBuy = $_SESSION['activeGroupBuy'];
    $groupBuyDao = new groupBuyDao();
    $orderDao = new orderDao();
    $userDao = new userDao();
    $groupBuyDao -> connect($host, $pdo);
    $orderDao -> connect($host, $pdo);
    $userDao -> connect($host, $pdo);

    $groupBuy = $groupBuyDao -> get($activeGroupBuy);
    $currentOrder = $orderDao -> get($activeGroupBuy, $user);
    $expiredOrders = $groupBuyDao -> selectExpireGroupBuy();

    $groupBuyTotal = $orderDao -> getTotalPounds($activeGroupBuy);
    $totalMembers = $userDao -> getTotalMembers();
    $utils = new Utils;
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
                <dd><?php print $expiredOrder->getEndDate()?> <span>$61.60</span></dd>
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
    <h4>Social Statistics</h4>
    <dl>
        <dt>Total Members: <span><?php print $totalMembers; ?></span></dt>
        <dd></dd>
    </dl>
    <dl>
        <dt>Purchased Pounds<br/>(Everyone): <span><?php print $groupBuyTotal; ?> lbs</span></dt>
        <dd></dd>
    </dl>
    <dl>
        <dt>Purchased Pounds<br/>(You): <span>30 lbs</span></dt>
        <dd></dd>
    </dl>
</div>