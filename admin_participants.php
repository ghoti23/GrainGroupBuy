<?php require 'dao.php'; ?>
<?php require 'groupbuy.php'; ?>
<?php require 'grain.php'; ?>
<?php require 'order.php'; ?>
<?php require 'user.php'; ?>
<?php session_start();

    if ($user->getAdmin() != 1) {
		header("location:dashboard.php");
	}
	require 'properties.php';
    $dao = new dao();
	$dao->connect($host,$pdo);
	$user = $_SESSION['user'];
	
	$groupBuyID = strip_tags($_REQUEST["id"]);
	$dao->getGroupBuyParticipants($groupBuyID);
	
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)">
<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.2)">
<title>Group Buy - View Group Buy Participants</title>
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
      <?php include_once("analyticstracking.php") ?>
</head>
<body>
<form action="admin.php" method="POST">
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
                <i class=" icon-bar-chart"></i><span>Group Buy</span>
                </h4>
              </div>
              <!-- End .span6 -->
              <div class="span2">
					<h4>
					<a href="startGroupBuy.php" class="btn">Start Group Buy</a>
					</h4>
			  </div>
              <!-- End .span6 -->
            </div>
            <!-- End .row-fluid -->
          </div>
          <!-- End .title -->
          <div class="content">
	    	<?php
	    		$groupBuys = $dao->selectAllGroupBuy();

	    		if ($groupBuys) {
	    			print '<table class="table table-striped"><thead><th></th><th>Name</th></thead><tbody>';
	    			foreach ($groupBuys as $i => $value) {
	    				$groupBuy = $groupBuys[$i];
	    				print '<tr><td><input type="checkbox" name="groupBuy[]" value="' . $groupBuy->get_ID() . '" ></td><td><a href="startGroupBuy.php?id='.$groupBuy->get_ID().'">' . $groupBuy->get_title() . '</a></td><td><a href="export.php?id='.$groupBuy->get_ID().'" class="btn">Export User List</a></td><td><a href="exportProduct.php?id='.$groupBuy->get_ID().'" class="btn">Export Grain List</a></td><td><a href="exportProduct.php?id='.$groupBuy->get_ID().'" class="btn">Export Product List</a></td></tr>';
	    			}
	    			print '</tbody></table>';
	    		} else {
	    			print "There are no active group buys<br /><br />";
	    		}
	    	?>
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
              <i class="icon-globe"></i><span>Approve Users</span>
              </h4>
			</div>
			<div class="content">
	    	<?php
	    		$users = $dao->confirmUserList();
	    		if ($users) {
	    			print '<table class="table table-striped"><thead><th></th><th>Email</th><th>Username</th></thead><tbody>';
	    			foreach ($users as $i => $value) {
	    				$unconfirmedUser = $users[$i];		
	    				print '<tr><td><input type="hidden" name="confirmationCode[]" value="'.$unconfirmedUser->get_password().'"><input type="checkbox" name="confirmUsers[]" value="' . $unconfirmedUser->get_email() . '"></td><td>' . $unconfirmedUser->get_email()  . '</td><td>' . $unconfirmedUser->get_username() . '</td></tr>';
	    			}
	    			print '</tbody></table>';
					print '<input type="submit" value="Confirm" class="btn">';
	    		} else {
	    			print 'No users needing confirmation';
	    		}
	    	?>
            </div>
            <!-- End .title -->
            <div class="content">

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


  <div id="footer">
    <p>
      &copy; The Art of Beer 2012
    </p>
    <span class="company_logo"></span>
  </div>
</div>
</div>
<!-- /container -->
<!-- Le javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/jquery.sparkline.min.js"></script>
<script src="js/plugins/excanvas.compiled.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/fileinput.jquery.js"></script>
<script src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script src="js/jquery.touchdown.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/flot/jquery.flot.stack.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/flot/jquery.flot.pie.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/flot/jquery.flot.resize.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/jquery.peity.min.js"></script>
<script type="text/javascript" language="javascript" src="js/plugins/datatables/js/jquery.dataTables.js"></script>
<script src="js/plugins/justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
<script language="javascript" type="text/javascript" src="js/plugins/full-calendar/fullcalendar.min.js"></script>

<script language="javascript" type="text/javascript" src="js/jnavigate.jquery.min.js"></script>
<script type='text/javascript'>
    $(window).load(function() {
     $('#loading').fadeOut();
    });
      $(document).ready(function() {
      $('body').css('display', 'none');
      $('body').fadeIn(500);


      $("#logo a, #sidebar_menu a:not(.accordion-toggle), a.ajx").click(function() {
      event.preventDefault();
      newLocation = this.href;
      $('body').fadeOut(500, newpage);
      });
      function newpage() {
      window.location = newLocation;
      }
	  

    });
</script>
</form>
</body>
</html>