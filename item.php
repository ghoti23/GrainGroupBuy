<?php
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';

session_start();
if (!isset($_SESSION['user'])){
    header("location:index.php");
}

if (!isset($_REQUEST["id"])){
    header("location:dashboard.php");
}

$user = $_SESSION['user'];
$item_id = strip_tags($_REQUEST["id"]);
$activeGroupBuy = $_SESSION['activeGroupBuy'];

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $amount = strip_tags($_REQUEST["value"]);

    $orderDao = new orderDao();
    $orderDao->connect($host, $pdo);
    $orderDao->addProductOrder($activeGroupBuy, $amount, $item_id, $user);
    header("location:dashboard.php");
}

$productDao = new productDao();
$productDao->connect($host, $pdo);
$item = $productDao->get($item_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art of Beer Brewery - Group Buy - Item Detail</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
<?php include_once("includes/header.php") ?>
<div class="container">
    <div class="body-spacer">
        <div class="row">
            <div class="col-md-3">
                <?php include_once("includes/left-nav.php")?>
            </div>
            <div class="col-md-7">
                <div class="well light">
                    <h4>Product Information</h4>
                    <div class="product-info">
                        <h3><?php print $item->getName()?></h3>
                        <h6>Vendor: <?php echo $item->getVendor()?></h6>
                        <h6>Supplier: <?php echo $item->getSupplier()?></h6>
                        <p><?php echo $item->getDescription()?></p>
                    </div>
                    <form class="product-info" action="/item.php" method="post">
                        <input type="hidden" name="id" value="<?php print $item->getId()?>" />
                        <div class="text-right">
                            <input type="text" name="value" value="1" maxlength="3">
                        </div>
                        <div class="text-right">
                            <input type="submit" value="Submit">
                        </div>

                    </form>
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