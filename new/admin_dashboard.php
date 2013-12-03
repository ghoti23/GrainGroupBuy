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
    header("location:index.php");
}
if ($user->getAdmin() != 1) {
    header("location:dashboard.php");
}

if (!isset($_REQUEST["type"])){
    $type = 'top';
} else {
    $type = strip_tags($_REQUEST["type"]);
}

$groupBuyDao = new groupBuyDao();
$groupBuyDao->connect($host,$pdo);
$groupBuys = $groupBuyDao->all();

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
                <?php include_once("includes/admin-left-nav.php")?>
            </div>
            <div class="col-md-7">
                <div class="well light">
                    <h4>Group Buys</h4>
                    <div>
                        <ul class="list-group">

                            <?php
                            $index=1;
                            foreach ($groupBuys as $groupBuy) {?>
                            <li class="list-group-item light">
                                <em><span><?php echo $index ?>.</span> <?php print $groupBuy->getName()?><select name="groupBuyOptions<?php print $index ?>"  onchange="window.open(this.options[this.selectedIndex].value)"><option value=""></option><option value="export.php?id=<?php print $groupBuy->getId()?>">Export User List</option><option value="exportProduct.php?id=<?php print $groupBuy->getId()?>">Export Product List</option><option value="export_paypal.php?id=<?php print $groupBuy->getId()?>">Export PayPal List</option><option value="admin_user.php?id=<?php print $groupBuy->getId()?>">User List Total</option></select></em>
                            </li>
                            <?php
                                $index++;
                            }
                            ?>

                        </ul>
                    </div>
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