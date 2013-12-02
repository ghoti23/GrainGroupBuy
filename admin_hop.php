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
    <title>Group Buy - Edit Grain</title>
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
    <?php require_once('includes/sidenav_admin.php'); ?>
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
                                    <i class=" icon-beaker"></i><span>Edit Product</span>
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
                        <div class="alert hide" id="confirmation">
                        </div>
                        <div class="navbar">
                            <div class="navbar-inner">
                                <form method="POST" id="searchForm" class="navbar-form">
                                    <div class="input-append">
                                        <input type="text" name="value" id="search" class="span2 search-query">
                                        <button type="submit" class="btn">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="results-section">
                            <div class="intro">
                                <p class="intro-byline">Get started by searching for an hop.</p>
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
</div>
<!-- /container -->

<script src="js/edit-product.js"></script>
<script id="body-tmpl" type="text/template">
    <form id="addProduct">
        <table class="responsive table table-hover table-striped fontawesome-icons">
            <thead>
            <tr>
                <th class="jv">Id</th>
                <th class="ue">Name</th>
                <th class="jv">Country</th>
                <th class="ue">AA %</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <%
            _.each(data, function (datum, index) { %>
                <tr>
                    <td><%=datum.id%></td>
                    <td class="ue"><%= datum.name %></td>
                    <td class="ue"><%= datum.country %></td>
                    <td class="ue"><%= datum.aa %></td>
                    <td><a class="btn btn-small edit" rel="tooltip" data-placement="left" data-original-title=" Edit Product " data-id="<%=datum.id%>"><i class="icon-edit"></i></a></td>
                </tr>
            <% }); %>
            </tbody>
        </table>
    </form>
</script>
<script id="edit-tmpl" type="text/template">
    <form id="editForm" method="POST" action="api/product/edit.php">
        <input type="hidden" name="id" value="<%=data.id%>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3><i class="icon-edit"></i> Edit Hop -  <%=data.name%></h3>
        </div>
        <div class="modal-body">
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Name</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="description" value="<%=data.name%>"/>
                </div>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Brewing Usage</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="country" value="<%=data.usage%>"/>
                </div>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Aroma</label>
                <input type="text" class="required" name="aroma" value="<%=data.aroma%>"/>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Substitutions</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="name" value="<%=data.substitution%>"/>
                </div>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Typical Style</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="vendor" value="<%=data.style%>"/>
                </div>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Storage Stability</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="price" value="<%=data.storage%>"/>
                </div>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Alpha Acids</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="price4000" value="<%=data.aa%>"/>
                </div>
            </div>
            <div class="control-group row-fluid">
                <label for="quantity" class="row-fluid ">Industry Information</label>
                <div class="controls row-fluid input-append">
                    <input type="text" class="required" name="price8000" value="<%=data.industry%>"/>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</script>
</body>
</html>