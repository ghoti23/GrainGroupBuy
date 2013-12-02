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
                <div id="groupbuy-all">

                </div>
            </div>
        </div>
        <!-- End .box -->
    </div>
    <!-- End .row-fluid -->
    <div class="row-fluid">
        <div class="span12">
            <div class="box gradient">
                <div class="title">
                    <h4><i class="icon-resize-full"></i><span>Approve Members</span></h4>
                </div>
                <!-- End .title -->
                <div class="content">
                    <form method="POST" id="approveMember" name="approveMember">
                        <div id="approve-all">
                        </div>
                    </form>
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
<div id="viewModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<?php include_once("includes/footer.php")?>
</div>
<!-- /container -->
<script src="js/admin.js"></script>
<script id="body-tmpl" type="text/template">
    <table class="responsive table table-hover table-striped fontawesome-icons">
        <tbody>
        <%
        _.each(data, function (datum, index) { %>
            <tr>
                <td><a href="startGroupBuy.php?id=<%=datum.id%>"><%= datum.name %></a></td>
                <td><a href="export.php?id=<%=datum.id%>" class="btn btn-info">Export User List</a></td>
                <td><a href="export_paypal.php?id=<%=datum.id%>" class="btn btn-info">Export Paypal List</a></td>
                <td><a href="exportProduct.php?id=<%=datum.id%>" class="btn btn-info">Export Product List</a></td>
                <td><a href="admin_user.php?id=<%=datum.id%>" class="btn btn-info">User List Total</a></td>
            </tr>
        <% }); %>
        </tbody>
    </table>
</script>
<script id="approve-tmpl" type="text/template">

    <table id="datatable_example" class="responsive table table-striped" style="width:100%;margin-bottom:0; ">
        <thead>
        <tr>
            <th> </th>
            <th> Email </th>
            <th> Username </th>
        </tr>
        </thead>
        <tbody>
        <%
        _.each(data, function (datum, index) { %>
            <tr>
                <td><input type="checkbox" name="email[]" value="<%=datum.email%>"></td>
                <td><%= datum.email %></td>
                <td><%= datum.username %></td>
            </tr>
        <% }); %>
        <tr><td colspan="2"><a href="#" class="btn btn-info update" ><i class="icon-user"></i> Approve Member</a></td></tr>
        </tbody>
    </table>

</script>
</body>
</html>