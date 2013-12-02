<?php
require 'dao/dao.php';
require 'dao/productDao.php';
require 'dao/groupBuyDao.php';
require 'dao/orderDao.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/user.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
session_start();

$productDao = new productDao();
$dao = new groupBuyDao();
$dao->connect($host, $pdo);
$user = $_SESSION['user'];
$groupBuyID = strip_tags($_REQUEST["id"]);
$groupBuy = $dao->get($groupBuyID);
$search = "";
if (!empty($_REQUEST["search"])) {
    $search = strip_tags($_REQUEST["search"]);
}
$dao = new orderDao();
$dao->connect($host, $pdo);
$adminUpdate = false;
$adminUser = "";
if (!empty($_REQUEST["user"])) {
    $adminUser = strip_tags($_REQUEST["user"]);
}

if (($adminUser != "") && $_SESSION['admin']) {
    $user = $dao->getUser($adminUser);
    $adminUpdate = true;
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Group Buy - Add Grain</title>
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
            <btn class="btn btn-la1rge btn-i1nfo responsive_menu icon_item" data-toggle="collapse"
                 data-target="#sidebar">
                <i class="icon-reorder"></i>
            </btn>
        </li>
    </ul>
</div>
<!-- Responsive part -->
<div id="sidebar" class="collapse">
    <?php require_once('includes/sidenav.php'); ?>
</div>
<div id="main">
    <div class="container">
        <div class="container_top">
            <div class="row-fluid ">

                <?php require_once('includes/header.php'); ?>

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
                                <h4>
                                    <i class=" icon-bar-chart"></i><span><?php print $groupBuy->getName(); ?></span>
                                </h4>
                            </div>
                            <!-- End .span6 -->
                            <div class="span2">

                            </div>
                            <!-- End .span6 -->
                        </div>
                        <!-- End .row-fluid -->
                    </div>
                    <!-- End .title -->
                    <div class="content">
                        <div id="confirmation">
                        </div>
                        <div class="navbar">
                            <div class="navbar-inner">
                                <form method="POST" id="searchForm" class="navbar-form">
                                    <input type="hidden" name="id" value="<?php echo $groupBuyID; ?>">
                                    <div class="input-append">
                                        <input type="text" name="value" id="search" class="span2 search-query">
                                        <button type="submit" class="btn">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form id="addForm">
                            <div id="results-section">
                                <div class="intro">
                                    <p class="intro-byline">Get started by searching for an product.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End .box -->
            </div>
            <!-- End .row-fluid -->
            <div class="row-fluid">
                <div class="span12">
                    <div class="box gradient">
                        <div class="title">
                            <h4>
                                <i class="icon-globe"></i><span>Available Splits</span>
                            </h4>
                        </div>
                        <!-- End .title -->
                        <div class="content">
                            <table id="datatable_example" class="responsive table table-striped"
                                   style="width:100%;margin-bottom:0; ">
                                <thead>
                                <tr>
                                    <th> No</th>
                                    <th> Name</th>
                                    <th> Amount Per Split</th>
                                    <th> Amount Available</th>
                                    <th> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $x = 1;
                                $results = $dao->getAvailableSplits($groupBuyID);
                                foreach ($results as $row) {
                                    $addSplitURL = 'addSplit.php?id=' . $row["id"] . '&groupbuy=' . $groupBuyID;
                                    if ($adminUpdate) {
                                        $addSplitURL = $addSplitURL . "&user=" . $adminUser;
                                    }
                                    print '<tr><td>' . $x . '</td><td>' . $row["product_name"] . '</td><td>' . $row["pounds"] / $row["splitAmt"] . '</td><td>' . $row["available"] . '</td><td><a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" Add Split " href="' . $addSplitURL . '"><i class="icon-plus"></i></a></td></tr>';
                                    $x++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End .content -->
                    </div>
                    <!-- End .box -->
                </div>
                <!-- End .span6 -->

            </div>
            <!-- End .row-fluid -->
        </div>
        <!-- End #container -->
    </div>
    <?php include_once("includes/footer.php")?>
</div>
</div>
<!-- /container -->

<script src="js/add.js"></script>
<script id="body-tmpl" type="text/template">
        <% if (data.length > 0) { %>
        <input type="hidden" name="groupBuyId" value="<?php echo $groupBuyID?>" />
        <table class="responsive table table-hover table-striped fontawesome-icons">
            <thead>
            <tr>
                <th class="jv">Id</th>
                <th class="ue">Vendor</th>
                <th class="ue">Name</th>
                <th class="ue">Description</th>
                <th class="jv">Pounds</th>
                <th class="ue">Price</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <%
            _.each(data, function (datum, index) { %>
                <tr>
                    <td><input type="text" size="3" class="input-mini" name="<%=datum.id%>"></td>
                    <td class="ue"><%= datum.vendor %></td>
                    <td class="ue"><%= datum.name %></td>
                    <td class="ue"><%= datum.description %></td>
                    <td><%= datum.pounds %></td>
                    <td class="ue">$<%= datum.price %></td>
                    <td><a class="btn btn-small add" rel="tooltip" data-placement="left" data-original-title=" Add Product " data-addProduct="<%=datum.id%>"><i class="icon-plus"></i></a></td>
                </tr>
            <% }); %>
            </tbody>
        </table>
        <%} else {%>
            <div class="intro">
                <p class="intro-byline">Sorry, no products met your search.</p>
            </div>
        <%}%>
</script>
</body>
</html>