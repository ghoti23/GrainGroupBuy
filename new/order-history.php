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
if (!isset($_SESSION['user'])){
    header("location:/new/index.php");
}

$user = $_SESSION['user'];

$orderDao = new orderDao();
$orderDao -> connect($host, $pdo);
$expiredOrders = $orderDao -> getOrderHistory($user);

$sub_title = "Order History"
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
            <div class="col-md-9">
                <div class="well light">
                    <div>
                        <?php
                        if (!empty($expiredOrders)) {
                        ?>
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                                </thead>
                                <tbody>
                            <?php
                            foreach ($expiredOrders as $i => $value) {
                                $expiredOrder = $expiredOrders[$i];
                                ?>
                                <tr>
                                    <td><a href="/new/order.php?id=<?php print $expiredOrder->getId()?>"><?php print $expiredOrder->getName()?></a></td>
                                    <td><?php print $expiredOrder->getFormattedStartDate()?></td>
                                    <td><?php print $expiredOrder->getFormattedEndDate()?></td>
                                </tr>
                            <?php } ?>
                            </table>
                        <?php } else {  ?>
                            <h3 class="msg">You have no previous orders.</h3>
                        <?php } ?>
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