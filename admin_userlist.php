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
    <title>Group Buy - Admin</title>
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
                require_once ('includes/header.php');
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
                                <h4><i class=" icon-bar-chart"></i><span>Admin</span></h4>
                            </div>
                            <!-- End .span6 -->
                        </div>
                        <!-- End .row-fluid -->
                    </div>
                    <!-- End .title -->
                    <div class="content">
                        <div id="userList-all">

                        </div>
                        <div class="box gradient">
                            <div class="title">
                                <div class="row-fluid">
                                    <div class="span10">
                                        <h4><i class=" icon-bar-chart"></i><span>User</span></h4>
                                    </div>
                                    <div class="span2">
                                        <h4><span>Total - $123.24</span></h4>
                                    </div>
                                    <!-- End .span6 -->
                                </div>
                                <!-- End .row-fluid -->
                            </div>
                            <!-- End .title -->
                            <div class="content">
                                <table class="responsive table table-hover table-striped fontawesome-icons">
                                    <thead>
                                        <th>ID</th>
                                        <th>Vendor</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Shipping</th>
                                        <th>Food Tax</th>
                                        <th>Non Food Tax</th>
                                        <th>Total</th>
                                    </thead>
                                    <tr>
                                        <td>test</td>
                                        <td>test</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
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
    <?php include_once("includes/footer.php")?>
</div>
<!-- /container -->
<script src="js/admin-user.js"></script>
<script langauge="JavaScript">
    var groupBuyId = <?php echo $groupBuyID ?>
</script>
<script id="body-tmpl" type="text/template">
    <table class="responsive table table-hover table-striped fontawesome-icons">
        <tbody>
        <%
        _.each(data, function (datum, index) { %>
            <div class="box gradient">
                <div class="title">
                    <div class="row-fluid">
                        <div class="span10">
                            <h4><i class=" icon-bar-chart"></i><span><%=datum.username%></span></h4>
                        </div>
                        <div class="span2">
                            <h4><span>Total - $123.24</span></h4>
                        </div>
                        <!-- End .span6 -->
                    </div>
                    <!-- End .row-fluid -->
                </div>
                <!-- End .title -->
                <div class="content">
                    <table class="responsive table table-hover table-striped fontawesome-icons">
                        <thead>
                        <th>ID</th>
                        <th>Vendor</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Shipping</th>
                        <th>Food Tax</th>
                        <th>Non Food Tax</th>
                        <th>Total</th>
                        </thead>
                        <tr>
                            <td>test</td>
                            <td>test</td>
                        </tr>
                    </table>
                </div>
            </div>
        <% }); %>
        </tbody>
    </table>
</script>

</body>
</html>