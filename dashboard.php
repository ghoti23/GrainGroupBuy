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

$user = $_SESSION['user'];
if ($user == null) {
    header("location:/index.php");
}

if (!isset($_REQUEST["type"])){
    $type = 'top';
} else {
    $type = strip_tags($_REQUEST["type"]);
}

$groupBuyDao = new groupBuyDao();
$groupBuyDao -> connect($host, $pdo);
$productDao = new productDao();
$productDao->connect($host, $pdo);

if (isset($_SESSION['activeGroupBuy'])) {
    $splitProducts = $productDao->getAllSplits($_SESSION['activeGroupBuy']);
}

$topProducts = $groupBuyDao->getTopProducts();

$sub_title = "Current Group Buy";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php") ?>
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="container">
    <div class="body-spacer">
        <?php include_once("includes/subnav.php")?>
        <div class="row">
            <div class="col-md-9">
                <?php
                if (isset($_SESSION['activeGroupBuy'])) {
                    $grainTotal = $orderDao -> getAllOrdersTotalPoundsByType($_SESSION['activeGroupBuy'], 'grain');
                    $hopTotal = $orderDao -> getAllOrdersTotalPoundsByType($_SESSION['activeGroupBuy'], 'hops');
                    $supplyTotal = $orderDao -> getAllOrdersTotalSupplies($_SESSION['activeGroupBuy']);
                    ?>

                    <article>
                        <div class="row-fluid stats clearfix heads-up">
                            <?php if ($groupBuy->getHopsOnly() != 0 && $groupBuy->getGrainOnly() != 0) {?>
                                <div class="col-md-4 stat">
                                    Total Grains
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format($grainTotal); ?> lbs</span>
                                </div>
                                <div class="col-md-4 stat">
                                    Total Hops
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format(round($hopTotal)); ?> lbs</span>
                                </div>
                                <div class="col-md-4 stat">
                                    Total Supplies
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format(round($supplyTotal)); ?></span>
                                </div>
                            <?php } elseif ($groupBuy->getHopsOnly() != 0) { ?>
                                <div class="col-md-6 stat">
                                    Total Hops
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format(round($hopTotal)); ?> lbs</span>
                                </div>
                                <div class="col-md-6 stat">
                                    Total Supplies
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format(round($supplyTotal)); ?></span>
                                </div>
                            <?php } elseif ($groupBuy->getGrainOnly() != 0) { ?>
                                <div class="col-md-6 stat">
                                    Total Grains
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format($grainTotal); ?> lbs</span>
                                </div>
                                <div class="col-md-6 stat">
                                    Total Supplies
                                    <div class="icon"><img src="/img/grain-icon.png" /></div>
                                    <span><?php print number_format(round($supplyTotal)); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </article>

                <?php
                    if (!empty($splitProducts)) {
                        $products = $splitProducts;
                        include("includes/product-split-row.php");
                    }

                }

                if (!empty($topProducts)) {
                    $products = $topProducts;
                    print "<h1 class='section'>Top Selling Products</h1>";
                    include("includes/product-row.php");
                }
                ?>

                <?php
                    $poundsTotal = $orderDao -> getAllOrdersTotalPounds(null);
                    $userTotal = $orderDao -> getUserOrderTotalPounds(null, $user);
                    $totalMembers = $userDao -> getTotalMembers();
                ?>
                <h1 class="section">All-Time Statistics</h1>
                <article>
                    <div class="row-fluid stats clearfix heads-up">
                        <div class="col-md-4 stat">
                            Total Members<br/>&nbsp;
                            <span><?php print number_format($totalMembers); ?></span>
                        </div>
                        <div class="col-md-4 stat">
                            Purchased Pounds<br/>(Everyone)
                            <span><?php print number_format(round($poundsTotal)); ?> lbs</span>
                        </div>
                        <div class="col-md-4 stat">
                            Purchased Pounds<br/>(You)
                            <span><?php print number_format(round($userTotal)); ?> lbs</span>
                        </div>
                    </div>
                </article>

            </div>
            <div class="col-md-3">
                <?php include_once("includes/right-nav.php")?>
            </div>
        </div>
    </div>
</div>
<?php include_once("includes/footer.php")?>
</body>
</html>



<?php
/*
if (empty($typeProducts)) {
    print "<li class='list-group-item light'>The are currently no active splits.</li>";
}

$index = 1;
foreach ($typeProducts as $productSplit) {
    $product = $productSplit -> getProduct();
    $price = $utils->getDisplayPrice($user, $product, $groupBuy);
    $vendor = $product->getVendor()
    ?>
    <li class="list-group-item light">
        <form class="order-add hidden" method="post">
            <input type="hidden" name="id" value="<?php print $product->getId()?>" />
            <span>How much?</span>

            <input type="button" class="btn grey cancel" value="Cancel" />
            <input type="submit" value="Save" />
        </form>
        <?php if (isset($activeGroupBuy)) {  ?>
            <a class="button add" href="#">Add</a>
        <?php } ?>
        <em><span><?php echo $index++ ?>.</span> <?php print $product->getName()?></em> <?php if (!empty($vendor)) { print ' - ' . $vendor; } ?>
        <?php $desc = $product->getDescription(); if (!empty($desc)) { ?>
            <div class="desc"><?php print $desc; ?></div>
        <?php } ?>
        <div><?php print $product->getDisplayUnits() . " @ " . '$' . $price ?> &nbsp;</div>
        <div><?php print "<b>" . $productSplit->getDisplayAmount() . "</b> of <b>" . $product->getPoundsWithUnit() . "</b>"?></div>
    </li>
<?php
}
*/
?>