<?php
require 'dao/groupBuyDao.php';
 ?>
<?php
require 'entity/groupbuy.php';
?>
<?php
require 'entity/product.php';
?>
<?php
require 'entity/order.php';
?>
<?php
require 'entity/user.php';
?>
<?php session_start();
    if(!isset($_SESSION['user'])) {
        header( 'Location: index.php' ) ;
    }
	$user = $_SESSION['user'];
?>
<?php
require 'properties.php';
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<title>Group Buy - Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo $_SESSION['admin'] ?>">
		<meta name="author" content="<?php echo $user->getAdmin(); ?>">
		<link rel="shortcut icon" href="css/images/favicon.png">

		<link href="css/base.css" rel="stylesheet">
		<link href="css/manage.css" rel="stylesheet">
		<link href="css/grainbuy.css" rel="stylesheet">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
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
		</div>
		<!-- Responsive part -->
		<div id="sidebar" class="collapse">
			<div class="logo">
				<a href="index.php"></a>
			</div>
			<ul id="sidebar_menu" class="navbar nav nav-list sidebar_box">
				<li class="accordion-group active">
					<a class="dashboard" href="dashboard.php"><img src="img/menu_icons/dashboard.png">Dashboard</a>
				</li>
                <li >
                    <a class="faq" href="faq.php"><img src="img/menu_icons/question.png"> FAQs</a>
                </li>
                <li>
                    <a class="calculator" href="calculators.php"><i class="ui-icon-calculator"></i> Calculators</a>
                </li>
			</ul>
            <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Left Nav - Small Rectangle -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:180px;height:150px"
                 data-ad-client="ca-pub-5071928133115505"
                 data-ad-slot="3662734270"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
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
									<div class="span6">
										<h4><i class=" icon-bar-chart"></i><span>Group Buys</span></h4>
									</div>
									<!-- End .span6 -->

									<!-- End .span6 -->
								</div>
								<!-- End .row-fluid -->
							</div>
							<!-- End .title -->
							<div class="content">
								Active Group Buys
								<table class="table table-striped">
									<tbody>
										<?php $dao = new groupBuyDao();
										$dao -> connect($host, $pdo);
										$openOrders = $dao -> selectCurrentGroupBuy();
										foreach ($openOrders as $i => $value) {
											$order = $openOrders[$i];
											print '<tr><td><a href="viewGroupBuy.php?id=' . $order -> getId() . '">' . $order -> getName() . '</a></td><td>' . $order -> getOwner() . '</td></tr>';
										}
										?>
									</tbody>
								</table>
								<br />
								<br />
								Completed Group Buys
								<table class="table table-striped">
									<tbody>
										<?php $openOrders = $dao -> selectExpireGroupBuy($user -> getEmail());
										foreach ($openOrders as $i => $value) {
											$order = $openOrders[$i];
											print '<tr><td><a href="viewCompletedGroupBuy.php?id=' . $order -> getId() . '">' . $order -> getName() . '</a></td><td>' . $order -> getOwner() . '</td></tr>';
										}
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
			<?php include_once("includes/footer.php")
			?>
		</div>
		</div>
		<!-- /container -->
		<?php include_once("includes/default-js.php")
		?>
	</body>
</html>