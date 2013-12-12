<?php
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/ProductSplit.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';

session_start();

if (isset($_SESSION['user'])){
    header("location:dashboard.php");
}

$groupBuyDao = new groupBuyDao();
$groupBuyDao -> connect($host, $pdo);
$openOrders = $groupBuyDao -> selectCurrentGroupBuy();
if (!empty($openOrders)) {
    $activeGroupBuy = $openOrders[0];
} else {
    $nextGroupBuy = $groupBuyDao -> selectNextGroupBuy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php") ?>
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="container">
    <section class="home-hero">
        <h1>Offering bulk pricing for grains and hops to the Chicagoland area.</h1>
        <?php if (isset($activeGroupBuy) && $activeGroupBuy->isActive()) {?>
            <h2>We're open and accepting orders until<br> <?php print $activeGroupBuy->getFormattedEndDate()?>.</h2>
        <?php } elseif (isset($nextGroupBuy)) {?>
            <h2>Sorry, but the next buy will begin on<br> <?php print $nextGroupBuy->getFormattedStartDate()?>.</h2>
        <?php } else {?>
            <h2>We haven't determined the date for the next group buy.  We'll let you know soon.</h2>
        <?php } ?>
        <div class="button-content">
            <a href="login.php" class="button grey">Existing Account</a>
            <a href="signup.php" class="button">Request an Account</a>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3>What is a group buy?</h3>
                <p>A group buy is where a bunch of people purchase grains and other items collectively to get competitive pricing because of the large combined order.  It gives the collective buyers purchasing power and provide for great cost savings on items.</p>
            </div>
            <div class="col-md-4">
                <h3>Who runs them?</h3>
                <p>These buys are organized by Chicago Home Brewers Group.  They are a group of Chicago area homebrewers whose group buys are coordinated by Bill Mason(bmason1623) with help from cheesecake, ghoti, Neopol, starman & wagz.</p>
            </div>
            <div class="col-md-4">
                <h3>Who can participate?</h3>
                <p>Practically anyone can participate.  All we ask is that you reside in the Chicago area or neighboring states like WI, IN, IA and MI.  We do not ship.  Period.</p>
            </div>
        </div>
    </section>
</div>
<?php include_once("includes/footer.php")?>
</body>
</html>