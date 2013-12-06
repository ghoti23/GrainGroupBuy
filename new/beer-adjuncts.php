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
    $typeProducts = $productDao->getByTypeAndSubtype('adjunct', $type);
}

$sub_title = "Beer Adjuncts";
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
        <?php include_once("includes/subnav.php")?>
        <div class="row">
            <div class="col-md-2">
                <ul class="nav-simple">
                    <li <?php if ($type == 'top') {?>class="active"<?php } ?>><a href="/new/beer-adjuncts.php">Top Sellers</a></li>
                    <li <?php if ($type == 'sugar') {?>class="active"<?php } ?>><a href="/new/beer-adjuncts.php?type=sugar">Belgian Candi Sugar</a></li>
                    <li <?php if ($type == 'cornsyrup') {?>class="active"<?php } ?>><a href="/new/beer-adjuncts.php?type=cornsyrup">Corn Syrup/Carbonation Drops</a></li>
                    <li <?php if ($type == 'honey') {?>class="active"<?php } ?>><a href="/new/beer-adjuncts.php?type=honey">Honey</a></li>
                    <li <?php if ($type == 'nonfermentables') {?>class="active"<?php } ?>><a href="/new/beer-adjuncts.php?type=nonfermentables">Non-Fermentables</a></li>
                </ul>
            </div>
            <div class="col-md-7">
                <div class="well light">
                    <div class="detail-bar">
                        <div class="total"><?php print count($typeProducts); ?> Items</div>
                        <div class="filter">Filter: </div>
                    </div>
                    <div>
                        <ul class="list-group">
                            <?php
                            $products = $typeProducts;
                            include("includes/product-row.php");
                            ?>
                        </ul>
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