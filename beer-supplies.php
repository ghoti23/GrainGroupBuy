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
    header("location:index.php");
    return;
}

if (!isset($_REQUEST["type"])){
    $type = "top";
    $groupBuyDao = new groupBuyDao();
    $groupBuyDao -> connect($host, $pdo);
    $typeProducts = $groupBuyDao -> getTopSupplies();
} else {
    $type = strip_tags($_REQUEST["type"]);
    $productDao = new productDao();
    $productDao->connect($host, $pdo);
    $typeProducts = $productDao->getByTypeAndSubtype('supply', $type);
}

$sub_title = "Beer Additives & Supplies";
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
            <div class="col-md-2">
                <ul class="nav-simple">
                    <li <?php if ($type == 'top') {?>class="active"<?php } ?>><a href="beer-supplies.php">Top Sellers</a></li>
                    <li <?php if ($type == 'bag') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=bag">Bags</a></li>
                    <li <?php if ($type == 'barrel alt') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=barrel alt">Barrel Alternatives</a></li>
                    <li <?php if ($type == 'brewing sugar') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=brewing sugar">Belgian Candi</a></li>
                    <li <?php if ($type == 'caps') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=caps">Bottle Caps</a></li>
                    <li <?php if ($type == 'cleaner') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=cleaner">Cleaners</a></li>
                    <li <?php if ($type == 'fruit') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=fruit">Fruit Flavoring</a></li>
                    <li <?php if ($type == 'spice') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=spice">Herbs & Spices</a></li>
                    <li <?php if ($type == 'chips') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=chips">Oak Chips</a></li>
                    <li <?php if ($type == 'sanitizer') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=sanitizer">Sanitizers</a></li>
                    <li <?php if ($type == 'phadjuster') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=phadjuster">Water Treatment</a></li>
                    <li <?php if ($type == 'wax') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=wax">Wax</a></li>
                    <li <?php if ($type == 'spiral') {?>class="active"<?php } ?>><a href="beer-supplies.php?type=spiral">Wood Spirals</a></li>
                </ul>
            </div>
            <div class="col-md-7">
                <div class="well light">
                    <div class="detail-bar">
                        <div class="total"><?php print count($typeProducts); ?> Items</div>
                        <div class="filter">&nbsp;</div>
                    </div>
                    <div>
                        <?php
                        $products = $typeProducts;
                        include("includes/product-row.php");
                        ?>
                    </div>
                </div>

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