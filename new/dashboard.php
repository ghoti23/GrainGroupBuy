<?php
require '../dao/groupBuyDao.php';
require '../dao/userDao.php';
require '../dao/orderDao.php';
require '../dao/productDao.php';
require '../entity/user.php';
require '../entity/groupbuy.php';
require '../entity/order.php';
require '../entity/product.php';
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
} else {
    $productDao = new productDao();
    $productDao->connect($host, $pdo);
    $typeProducts = $productDao->getByType($type);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art of Beer Brewery - Group Buy - Dashboard</title>
    <link rel="stylesheet" href="/css/main.css" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php include_once("../analyticstracking.php") ?>
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
                        <li <?php if ($type == 'hops') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=hops">Hops</a></li>
                        <li <?php if ($type == 'grain') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=grain">Grains</a></li>
                        <li <?php if ($type == 'supplies') {?>class="active"<?php } ?>><a href="/new/dashboard.php?type=supplies">Supplies</a></li>
                    </ul>
                    <?php if ($type == 'top') {?>
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