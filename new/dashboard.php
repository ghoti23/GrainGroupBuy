<?php
require '../dao/groupBuyDao.php';
require '../dao/userDao.php';
require '../dao/orderDao.php';
require '../dao/productDao.php';
require '../entity/user.php';
require '../entity/groupbuy.php';
require '../entity/order.php';
require '../entity/product.php';
require '../entity/ProductSplit.php';
require '../entity/split.php';
require '../properties.php';
require '../utils.php';

session_start();

$user = $_SESSION['user'];
if ($user == null) {
    header("location:/new/index.php");
}

if (!isset($_REQUEST["type"])){
    $type = 'top';
} else {
    $type = strip_tags($_REQUEST["type"]);
}

$groupBuyDao = new groupBuyDao();
$groupBuyDao -> connect($host, $pdo);

if ($type == 'top') {
    $topGrains = $groupBuyDao -> getTopGrains();
    $topHops = $groupBuyDao -> getTopHops();
    $topSupplies = $groupBuyDao -> getTopSupplies();
} else if ($type == 'split' && isset($_SESSION['activeGroupBuy'])) {
    $productDao = new productDao();
    $productDao->connect($host, $pdo);
    $typeProducts = $productDao->getAllSplits($_SESSION['activeGroupBuy']);
} else {
    $productDao = new productDao();
    $productDao->connect($host, $pdo);
    $typeProducts = $productDao->getByType($type);
}

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
                    <h4>Products</h4>
                    <ul class="nav nav-pills">
                        <li <?php if ($type == 'top') {?>class="active"<?php } ?>><a href="/new/dashboard.php">Top Sellers</a></li>
                        <li <?php if ($type == 'split') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=split">Active Splits</a></li>
                        <?php if ($groupBuy->getHopsOnly() != 0) {?><li <?php if ($type == 'hops') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=hops">Hops</a></li><?php } ?>
                        <?php if ($groupBuy->getGrainOnly() != 0) {?><li <?php if ($type == 'grain') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=grain">Grains</a></li><?php } ?>
                        <li <?php if ($type == 'supplies') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=supplies">Supplies</a></li>
                    </ul>
                    <?php if ($type == 'top') {?>
                        <?php if ($groupBuy->getHopsOnly() != 0) {?>
                        <h5>
                            <a class="pull-right" href="/new/dashboard.php?type=hops">Browse All Hops</a>
                            Top Selling Hops
                        </h5>
                        <div>
                            <ul class="list-group">
                                <?php
                                $products = $topHops;
                                include("includes/product-row.php");
                                ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <?php if ($groupBuy->getGrainOnly() != 0) {?>
                        <h5>
                            <a class="pull-right" href="/new/dashboard.php?type=grain">Browse All Grains</a>
                            Top Selling Grains
                        </h5>
                        <div>
                            <ul class="list-group">
                                <?php
                                $products = $topGrains;
                                include("includes/product-row.php");
                                ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <h5>
                            <a class="pull-right" href="/new/dashboard.php?type=supplies">Browse All Supplies</a>
                            Top Selling Supplies
                        </h5>
                        <div>
                            <ul class="list-group">
                                <?php
                                $products = $topSupplies;
                                include("includes/product-row.php");
                                ?>
                            </ul>
                        </div>
                    <?php } else if ($type == 'split') { ?>
                        <div>
                            <ul class="list-group">
                                <?php

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
                                            <select name="value">
                                                <?php
                                                if ($product->getType() == "grain") {
                                                    if ($product->getSplit() > 0) {
                                                        $count = 1;
                                                        $orderUnit = $product->getPounds() / $product->getSplit();
                                                        for ($i = .5; $i <= 10; $i += .5) {
                                                            print "<option value='" . $i . "'>" . $count++ * $orderUnit . " lbs</option>";
                                                        }
                                                    }
                                                    else {
                                                        for ($i = 1; $i <= 10; $i++) {
                                                            print "<option value='" . $i . "'>" . $i * $product->getPounds() . " lbs</option>";
                                                        }
                                                    }
                                                }
                                                elseif ($product->getType() == "hops") {
                                                    for ($i = 1; $i <= 11; $i++) {
                                                        print "<option value='" . ($i / 11) . "'>" . $i . " lbs</option>";
                                                    }
                                                }
                                                else {
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        print "<option value='" . $i . "'>" . $i . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <input type="button" class="btn grey cancel" value="Cancel" />
                                            <input type="submit" value="Save" />
                                        </form>
                                        <a class="button add" href="#">Add</a>
                                        <em><span><?php echo $index++ ?>.</span> <?php print $product->getName()?></em> <?php if (!empty($vendor)) { print ' - ' . $vendor; } ?>
                                        <?php $desc = $product->getDescription(); if (!empty($desc)) { ?>
                                            <div class="desc"><?php print $desc; ?></div>
                                        <?php } ?>
                                        <div><?php print $product->getDisplayUnits() . " @ " . '$' . $price ?> &nbsp;</div>
                                        <div><?php print "<b>" . $productSplit->getDisplayAmount() . "</b> of <b>" . $product->getPoundsWithUnit() . "</b>"?></div>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div>
                            <ul class="list-group">
                                <?php
                                    $products = $typeProducts;
                                    include("includes/product-row.php");
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
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