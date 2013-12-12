<?php
require 'dao/userDao.php';
require 'dao/groupBuyDao.php';
require 'dao/orderDao.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/user.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';
session_start();
$user = $_SESSION['user'];
if ($user == null) {
    header("location:index.php");
}
if ($user->getAdmin() != 1) {
    header("location:dashboard.php");
}
$groupBuyID = strip_tags($_REQUEST["id"]);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Group Buy - User Group Buy Total</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="css/images/favicon.png">

    <link href="css/base.css" rel="stylesheet">
    <link href="css/manage.css" rel="stylesheet">
    <link href="css/grainbuy.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php include_once("includes/default-js.php") ?>
    <?php include_once("analyticstracking.php") ?>
</head>
<body>
<div id="loading">
    <img src="img/ajax-loader.gif">
</div>
<div id="responsive_part">
    <div class="logo">
        <a href="index.html"></a>
    </div>
    <ul class="nav responsive">
        <li>
            <btn class="btn btn-large btn-i1nfo responsive_menu icon_item" data-toggle="collapse" data-target="#sidebar">
                <i class="icon-reorder"></i>
            </btn>
        </li>
    </ul>
</div>
<!-- Responsive part -->
<div id="sidebar" class="collapse">
    <?php
    require_once ('includes/sidenav_admin.php');
    ?>
</div>
<div id="main">
    <div class="container">
        <div class="container_top">
            <div class="row-fluid ">

                <?php
                require_once('includes/header.php');
                ?>

                <div class="span4">

                </div>
            </div>
        </div>
        <!-- End container_top -->
        <div id="container2">
            <div class="row-fluid">
                <div class="box gradient">
                    <div class="title">
                        <div class="row-fluid">
                            <div class="span10">
                                <h4><i class="icon-user"></i><span>User List for Group Buy</span></h4>
                            </div>
                            <!-- End .span6 -->
                        </div>
                        <!-- End .row-fluid -->
                    </div>
                    <!-- End .title -->
                    <div class="content">
                        <table class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                            <thead>
                                <th>Paid?</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Wholesale Cost</th>
                                <th>Their Amount</th>
                                <th>Tax Paid</th>
                                <th>Profit</th>
                            </thead>
                            <tbody>


                            <?php
                            $dao = new groupBuyDao();
                            $dao -> connect($host, $pdo);
                            $orders = $dao->getGroupBuyUsers($groupBuyID);
                            $groupBuy = $dao->get($groupBuyID);
                            $dao = new orderDao();
                            $dao -> connect($host, $pdo);
                            $groupBuyTotalPounds = $dao->getTotalPounds($groupBuyID);
                            $utils = new Utils();
                            $overAllUserPaid=0;
                            $overAllWholeSale=0;
                            $overAllTax=0;

                            foreach ($orders as $order) {
                                $user = $order->getUser();
                                $total=0;
                                $foodTotal=0;
                                $otherTotal=0;
                                $wholeSaleCost=0;
                                $orderProduct = $dao -> selectGroupBuyOrderProduct($groupBuyID, $user);
                                $orderSplit = $dao -> selectGroupBuyOrderSplit($groupBuyID, $user);
                                $totalPounds = 0;
                                $tax=0;
                                $x=0;
                                if (is_array($orderProduct)) {
                                    $productTotal = 0;
                                    foreach ($orderProduct as $i => $value) {
                                        $order = $orderProduct[$i];
                                        $product = new Product();
                                        $product = $order -> getProduct();
                                        $price = $utils->getMarkupPrice($user,$product,$groupBuy) * $order -> getAmount();

                                        $wholeSaleCost = $wholeSaleCost+$utils->getWholeSalePrice($product,$groupBuyTotalPounds) * $order -> getAmount();
                                        $total = $total + $price;
                                        if ($product->getType() == 'grain' || $product->getType() == 'hops') {
                                            $foodTotal = $foodTotal + $price;
                                        } else {
                                            $otherTotal = $otherTotal + $price;
                                        }
                                        $totalPounds = $totalPounds+($product->getPounds() * $order -> getAmount());
                                    }//end foreach
                                }//end if

                                if (is_array($orderSplit)) {
                                    $splitTotal = 0;
                                    foreach ($orderSplit as $y => $value) {
                                        $order = $orderSplit[$y];
                                        $split = $order->getSplit();
                                        $product = $split -> getProduct();
                                        $pounds = ($product -> getPounds() / $split -> getSplitAmount());
                                        $totalPounds = $totalPounds+($product->getPounds() * $order -> getAmount());

                                        $price = $utils->getMarkupPrice($user,$product,$groupBuy)/$split->getSplitAmount();
                                        $wholeSalePrice = $utils->getWholeSalePrice($product,$groupBuyTotalPounds)/$split->getSplitAmount();

                                        $total = $total + ($price*$order->getAmount());
                                        $wholeSaleCost = $wholeSaleCost + ($wholeSalePrice*$order->getAmount());
                                        if ($product->getType() == 'grain' || $product->getType() == 'hops') {
                                            $foodTotal = $foodTotal + $price;
                                        } else {
                                            $otherTotal = $otherTotal + $price;
                                        }
                                    }
                                }
                                if ($groupBuy -> getShipping() != "") {
                                    $shipping = $groupBuy -> getShipping();
                                    $shipping = number_format(($shipping / $groupBuyTotalPounds),3);
                                    $shippingCosts = $shipping * $totalPounds;
                                    $total = $total + $shippingCosts;
                                }
                                $totalWithoutTax = $total;
                                if ($groupBuy->getTax()) {
                                    $tax=($foodTotal*$foodTax);
                                    $tax=$tax+($otherTotal*$otherTax);
                                    $total=$total+$tax;
                                }
                                $profit = $totalWithoutTax-$wholeSaleCost;
                                $overAllUserPaid=$overAllUserPaid+$total;
                                $overAllWholeSale=$overAllWholeSale+$wholeSaleCost;
                                $overAllTax = $overAllTax+$tax;
                                echo '<tr><td>';
                                if ($order->getPaid()) {
                                    echo 'Yes';
                                } else {
                                    echo 'No';
                                }
                                echo '</td><td>'.$user->getUsername().'</td><td>'.$user->getEmail().'</td><td>'.number_format($wholeSaleCost,2).'</td><td>'.number_format($totalWithoutTax,2).'</td><td>'.number_format($tax,2).'</td><td>'.number_format($profit,2).'</td></tr>';
                            }
                            $overAllProfit = $overAllUserPaid-$overAllWholeSale;
                            echo '<tr><td></td><td></td><td><strong>Total</strong></td><td>'.number_format($overAllWholeSale,2).'</td><td>'.number_format($overAllUserPaid,2).'</td><td>'.number_format($overAllTax,2).'</td><td>'.number_format($overAllProfit,2).'</td></tr>';
                            $art = number_format(($overAllUserPaid*.02),2);
                            $paypal = number_format((count($users)*.3)+($overAllUserPaid*.029),2);
                            echo '<tr><td></td><td></td><td><strong>Art Cut</strong></td><td></td><td></td><td></td><td>'.$art.'</td></tr>';
                            echo '<tr><td></td><td></td><td><strong>Paypal Cut</strong></td><td></td><td></td><td></td><td>'.$paypal.'</td></tr>';
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End .box -->
            </div>
            <!-- End .row-fluid -->
        </div>
        <!-- End #container -->
    </div>
    <div id="viewModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <?php include_once("includes/footer.php") ?>
</div>
<!-- /container -->
</body>
</html>