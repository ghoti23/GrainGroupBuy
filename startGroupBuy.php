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

    if (!$_SESSION['admin'])  {
        header("location:dashboard.php");
    }

	$utils = new utils();
    $groupBuyDao = new GroupBuyDao();
    $groupBuyDao->connect($host,$pdo);
	$user = $_SESSION['user'];
	$valid=false;
	
	$groupBuy= new GroupBuy();
    if (isset($_POST["groupBuyName"])) {
        $groupBuy->setName(strip_tags($_POST["groupBuyName"]));
        $groupBuy->setStartDate(strip_tags($_POST["startDate"]));
        $endDate=strip_tags($_POST["endDate"]);
        if ($endDate == "") {
            $groupBuy->setEndDate( null );
        } else {
            $groupBuy->setEndDate( $endDate );
        }
        if (isset($_POST["quoteLink"])) {
            $groupBuy->setQuote(strip_tags($_POST["quoteLink"]));
        } else {
            $groupBuy->setQuote(null);
        }
        if (isset($_POST["notes"])) {
            $groupBuy->setNotes(strip_tags($_POST["notes"]));
        } else {
            $groupBuy->setNotes(null);
        }

        if (isset($_POST["order"])) {
            $groupBuy->setOrderSpreadsheet(strip_tags($_POST["order"]));
        } else {
            $groupBuy->setOrderSpreadsheet(null);
        }
        if (isset($_POST["catalog"])) {
            $groupBuy->setCatalog(strip_tags($_POST["catalog"]));
        } else {
            $groupBuy->setCatalog(null);
        }
        if ( isset($_POST["shipping"]) ) {
            $groupBuy->setShipping(strip_tags($_POST["shipping"]));
        } else {
            $groupBuy->setShipping(null);
        }
        if ( isset($_POST["supplier"]) ) {
            $groupBuy->setSupplier(strip_tags($_POST["supplier"]));
        } else {
            $groupBuy->setSupplier(null);
        }
        if ( isset($_POST["hops"]) ) {
            $groupBuy->setHopsOnly($utils->getFlag(strip_tags($_POST["hops"])));
        } else {
            $groupBuy->setHopsOnly("0");
        }
        if ( isset($_POST["grain"]) ) {
            $groupBuy->setGrainOnly($utils->getFlag(strip_tags($_POST["grain"])));
        } else {
            $groupBuy->setGrainOnly("0");
        }
        if ( isset($_POST["allowSplit"]) ) {
            $groupBuy->setAllowSplit($utils->getFlag(strip_tags($_POST["allowSplit"])));
        } else {
            $groupBuy->setAllowSplit("0");
        }
        if ( isset($_POST["numOfSplit"]) && $_POST["numOfSplit"] != "" ) {
            $groupBuy->setSplitAmt(strip_tags($_POST["numOfSplit"]));
        } else {
            $groupBuy->setSplitAmt(null);
        }
        if ( isset($_POST["id"]) ) {
            $groupBuy->setId(strip_tags($_REQUEST["id"]));
        }
        if ( isset($_POST["markup"]) ) {
            $groupBuy->setMarkup(strip_tags($_REQUEST["markup"]));
        }

        $dao = new groupBuyDao();
        $dao -> connect($host, $pdo);

        if ($groupBuy->getName() != "") {
            if ($groupBuy->getId() != "") {
                $dao->update($groupBuy);
            } else {
                $id=$dao->add($groupBuy,$user);
                $valid=true;
                $groupBuy->setID($id);
            }
        } else if ($editID != "") {
            $groupBuy=$groupBuyDao->get($editID);
        }
    }

    if (isset($_REQUEST["id"])) {
        $groupBuy=$groupBuyDao->get(strip_tags($_REQUEST["id"]));
    }


?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)">
    <meta http-equiv="Page-Exit" content="blendTrans(Duration=0.2)">
    <title>Group Buy - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
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
      <btn class="btn btn-la1rge btn-i1nfo responsive_menu icon_item" data-toggle="collapse" data-target="#sidebar">
       <i class="icon-reorder"></i>
      </btn>
      </li>
    </ul>
</div> <!-- Responsive part -->
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
	    	<?php
	    	if ($valid) {
	    		echo '<span class="label label-success">Successfully added new group buy</span><br /><br />';
	    	}

			?>
			<form id="groupBuy" action="startGroupBuy.php" method="POST">
	    		<input type="hidden" name="id" value="<?php echo $groupBuy->getID(); ?>">
	    		<table>
	    			<tr>
	    				<td>Name:</td>
	    				<td><input type="text" class="required" name="groupBuyName" value="<?php echo $groupBuy->getName() ?>"></td>
	    			</tr>
	    			<tr>
	    				<td>Start Date:</td>
	    				<td><input type="text" class="required" name="startDate" value="<?php echo $groupBuy->getStartDate() ?>"></td>
	    			</tr> 
	    			<tr>
	    				<td>End Date:</td>
	    				<td><input type="text" name="endDate" value="<?php echo $groupBuy->getEndDate() ?>"></td>
	    			</tr> 
	    			<tr>
	    				<td>Quote Link:</td>
	    				<td><input type="text" name="quoteLink" value="<?php echo $groupBuy->getQuote() ?>"></td>
	    			</tr> 
	     			<tr>
	    				<td>Hops Only Group Buy:</td>
	    				<td>							
							<?php if ($groupBuy->getHopsOnly()) { print  '<input type="checkbox" name="hops" value="1" checked />'; } else { print '<input type="checkbox" name="hops" value="1"  />';  } ?>Yes
						</td>
	    			</tr>	
	     			<tr>
	    				<td>Grain Only Group Buy:</td>
	    				<td>
		 					<?php if ($groupBuy->getGrainOnly()) { print  '<input type="checkbox" name="grain" value="1" checked />'; } else { print '<input type="checkbox" name="grain" value="1"  />';  } ?> Yes</td>
	    			</tr>	
	    			<tr>
	    				<td>Allow Splits</td>
	    				<td>
	    					<?php if ($groupBuy->getAllowSplit()) { print  '<input type="checkbox" name="allowSplit" value="1" checked />'; } else { print '<input type="checkbox" name="allowSplit" value="1"  />';  } ?> Yes
	    				</td>
	    			</tr>
	    			<tr>
	    				<td>Number of Split</td>
	    				<td><input type="text" name="numOfSplit" value="<?php echo $groupBuy->getSplitAmt() ?>" /> (Leave blank for unlimted)</td>
	    			</tr>
	    			<tr>
	    				<td>Notes:</td>
	    				<td><textarea name="notes"><?php echo $groupBuy->getNotes() ?></textarea></td>
	    			</tr>
	    			<tr>
	    				<td>Catalog:</td>
	    				<td><textarea name="catalog"><?php echo $groupBuy->getCatalog() ?></textarea></td>
	    			</tr>
	     			<tr>
	    				<td>Tax:</td>
                        <td><?php if ($groupBuy->getTax()) { print  '<input type="checkbox" name="tax" value="1" checked />'; } else { print '<input type="checkbox" name="tax" value="1"  />';  } ?> Yes (Food = <?php echo $foodTax?>; Other = <?php echo $otherTax?>)</td>
	    			</tr> 
	      			<tr>
	    				<td>Shipping:</td>
	    				<td><input type="text" name="shipping" value="<?php echo $groupBuy->getShipping() ?>"/></td>
	    			</tr>
                    <tr>
                        <td>Supplier(s):</td>
                        <td><input type="text" name="supplier" value="<?php echo $groupBuy->getSupplier() ?>"/> (Leave blank for all vendors)</td>
                    </tr>
                    <tr>
                        <td>Markup Percentage:</td>
                        <td><input type="text" name="markup" value="<?php echo $groupBuy->getMarkup() ?>"/> (If you want the markup to be 5% put in .05)</td>
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
	 <div class="row-fluid">
        <div class="span12">
          <div class="box gradient">
            <div class="title">
              <h4>
              <i class="icon-globe"></i><span>View User Order</span>
              </h4>
            </div>
            <!-- End .title -->
            <div class="content">
              <table id="datatable_example" class="responsive table table-striped" style="width:100%;margin-bottom:0; ">
              <thead>
              <tr>
                <th class="jv no_sort">
                   Paid
                </th>
                <th class="jv no_sort">
                  No
                </th>
                <th class="jv no_sort">
                  Username
                </th>
                <th class="ue">
                  Email
                </th>
                <th>
                    Action
                </th>
              </tr>
              </thead>
              <tbody>
 				  <?php
                    $id = $groupBuy->getID();
                    if (!empty($id)) {
                        $groupBuyDao = new GroupBuyDao();
                        $groupBuyDao->connect($host,$pdo);
                        $orders = $groupBuyDao->getGroupBuyUsers($groupBuy->getID());
                        $x=1;
                        foreach ($orders as $order) {
                            $user = $order->getUser();
                            print '<tr><td>';
                            if ($order->getPaid()) {
                                print  '<input type="checkbox" name="paid" value="1" checked />';
                            } else {
                                print '<input type="checkbox" name="paid" value="1"  />';
                            }
                            print '<td><td>' . $x . '</td><td>' . $user->getUsername() . '</td><td>' . $user->getEmail() . '</td><td><a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" add " href="viewGroupBuy.php?id='.$groupBuy->getId().'&user='.$user->getEmail().'">Edit Order</a> ';
                            if ($order->getPaid()) {
                                print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" add " href="api/order/paid.php?paid=0&id='.$groupBuy->getId().'&user='.$user->getEmail().'">Did Not Pay</a>';
                            } else {
                                print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" add " href="api/order/paid.php?paid=1&id='.$groupBuy->getId().'&user='.$user->getEmail().'">Paid</a>';
                            }
                            print '</td></tr>';
                            $x++;
                        }
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
    <!-- End #container -->
  </div>
    <?php include_once("includes/footer.php")?>
</div>
</div>

</body>
</html>