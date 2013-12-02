<?php
require 'dao/splitDao.php';
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

if (!$_SESSION['admin'])  {
    header("location:dashboard.php");
}


?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)">
<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.2)">
<title>Group Buy - Manage Product</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="css/images/favicon.png">
<!-- Le styles -->
<link href="css/twitter/bootstrap.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet">
<link href="css/grainbuy.css" rel="stylesheet">
<script src="js/plugins/modernizr.custom.32549.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
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
      <btn class="btn btn-la1rge btn-i1nfo responsive_menu icon_item" data-toggle="collapse" data-target="#sidebar">
       <i class="icon-reorder"></i>
      </btn>
      </li>
    </ul>
</div> <!-- Responsive part -->
<div id="sidebar" class="collapse">
   <div class="logo">
    <a href="index.php"></a>
  </div>
  <ul id="sidebar_menu" class="navbar nav nav-list sidebar_box">
    <li class="accordion-group">
    <a class="dashboard" href="dashboard.php"><img src="img/menu_icons/dashboard.png">Dashboard</a>
	</li>
	<li  class="accordion-group opened">
 		<a  class="accordion-toggle widgets collapsed" href="#collapse1" data-parent="#sidebar_menu" data-toggle="collapse" href="dashboard.php"><img src="img/menu_icons/settings.png">Admin</a>
		<ul id="collapse1" class="accordion-body collapse in">
			<li class="active"><a href="manageProduct.php">Manage Product</a></li>
			<li><a href="manageGrains.php">Manage Grains</a></li>
			<li><a href="manageGrains.php">Manage Vendors</a></li>
		</ul>
	</li>
  </ul>
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
                <i class=" icon-bar-chart"></i><span>Start Group Buy</span>
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
			<form id="groupBuy" action="startGroupBuy.php" method="POST">
	    		<input type="hidden" name="id" value="">
	    		<table>
	    			<tr>
	    				<td>Name:</td>
	    				<td><input type="text" class="required" name="groupBuyName" value=""></td>
	    			</tr>
	    			<tr>
	    				<td>Start Date:</td>
	    				<td><input type="text" class="required" name="startDate" value=""></td>
	    			</tr> 
	    			<tr>
	    				<td>End Date:</td>
	    				<td><input type="text" name="endDate" value=""></td>
	    			</tr> 
	    			<tr>
	    				<td>Quote Link:</td>
	    				<td><input type="text" name="quoteLink" value=""></td>
	    			</tr> 

	    		</table>
				<input type="submit" name="Add" class="btn"> <a href="admin.php" class="btn">Cancel</a>
	    	</form>
          </div>
        </div>
        <!-- End .box -->
      </div>
      <!-- End .row-fluid -->
	</div>
    <!-- End #container -->
  </div>
    <?php include_once("includes/footer.php")?>
</body>
</html>