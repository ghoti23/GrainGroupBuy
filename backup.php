<?php
require 'dao/dao.php';
 ?>
<?php
require 'entity/groupbuy.php';
?>
<?php
require 'entity/grain.php';
?>
<?php
require 'entity/order.php';
?>
<?php
require 'entity/user.php';
?>
<?php
require 'entity/product.php';
?>
<?php
require 'entity/split.php';
?>
<?php session_start(); ?>
<?php
require 'properties.php';
?>
<?php $dao = new dao();
	$dao -> connect($host, $pdo);

	$user = $_SESSION['user'];
	if ($user == null) {
		header("location:index.php");
	}
	$adminUpdate = false;
	$adminUser = strip_tags($_REQUEST["user"]);
	if (($adminUser != "") && $_SESSION['admin']) {
		$user = $dao -> getUser($adminUser);
		$adminUpdate = true;
	}
	$groupBuyID = strip_tags($_REQUEST["id"]);
	$grain = strip_tags($_POST["grain"]);
	$amount = $_POST["amount"];
	$amountProduct = $_POST["amountProduct"];
	$product = $_POST["product"];
	$count = count($amount);

	//Verify Active Group Buy
	$active = $dao -> activeGroupBuy($groupBuyID);
	if (!$active && !$_SESSION['admin']) {
		header("location:dashboard.php");
	}

	for ($i = 0; $i < $count; $i++) {
		if ($amount[$i] != "") {
			$dao -> updateGrainOrder($groupBuyID, strip_tags($amount[$i]), strip_tags($grain[$i]), $user);

		}
	}
	$count = count($amountProduct);
	for ($i = 0; $i < $count; $i++) {
		if ($amountProduct[$i] != "") {
			$dao -> updateProductOrder($groupBuyID, strip_tags($amountProduct[$i]), strip_tags($product[$i]), $user);

		}
	}

	$groupBuy = $dao -> selectGroupBuy($groupBuyID);
	$orders = $dao -> selectGroupBuyOrder($groupBuyID, $user);
	$numOfSplit = $dao -> getNumOfSplit($groupBuyID);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<title>Group Buy - View Group Buy</title>
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
			require_once('includes/sidenav.php');
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
										<h4><i class=" icon-bar-chart"></i><span>
											<?php print $groupBuy -> get_title();
											if ($adminUpdate) {
												print " - Viewing " . $user -> get_username() . " order";
											}
										?>
										</span></h4>
									</div>
									<!-- End .span6 -->
									<div class="span2">
										<h4><a href="addGrain.php?id=<?php echo $groupBuyID; ?>" class="btn btn-info"><i class="icon-plus"></i> Add Item</a></h4>
									</div>
									<!-- End .span6 -->
								</div>
								<!-- End .row-fluid -->
							</div>
							<!-- End .title -->
							<div class="content">
								<p>Owner: <?php print $groupBuy -> get_owner(); ?></p>
								<p>Notes: <?php print $groupBuy -> get_notes(); ?></p>
								<p>Catalog: <?php print $groupBuy -> get_catalog(); ?></p>
								<?php
								if ($groupBuy -> get_quote() != "") {
									echo "<p>Quote: " . $groupBuy -> get_quote() . "</p>";
								}
								if ($groupBuy -> get_tax() != "") {
									echo "<p>Tax: " . $groupBuy -> get_tax() . "</p>";
								}
								if ($groupBuy -> get_shipping() != "") {
									echo "<p>Shipping: " . $groupBuy -> get_shipping() . "</p>";
								}
							?>
								<p>
									Total Pounds Ordered: <?php $groupBuyTotal= $dao->getTotalPounds($groupBuyID); print $groupBuyTotal?></p>
									<form action="viewGroupBuy.php" method="POST" id="viewGroupBuy">
										<input type="hidden" name="id" value="<?php echo $groupBuyID; ?>">
										<table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
											<thead>
												<tr>
													<th class="no_sort">Quantity </th>
													<th class="no_sort to_hide_phone">Item</th>
													<th class="no_sort to_hide_phone">Price</th>
													<th class="no_sort">Total Price</th>
													<th class="ms no_sort ">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php $orderProduct = $dao -> selectGroupBuyOrderProduct($groupBuyID, $user);
												$orderSplit = $dao -> selectGroupBuyOrderSplit($groupBuyID, $user);
												$totalPounds = 0;
												foreach ($orders as $i => $value) {
													$order = $orders[$i];
													$grain = $order -> get_grain();
													$price = $grain -> getPoundPrice($groupBuyTotal);
													$total = $total + ($grain -> get_pound() * $price * $order -> get_amount());
													$totalPounds = $totalPounds + ($grain -> get_pound() * $order -> get_amount());
													$removeGrainURL = 'removeGrain.php?id=' . $groupBuyID . '&grainID=' . $grain -> get_ID();
													if ($adminUpdate) {
														$removeGrainURL = $removeGrainURL . "&user=" . $adminUser;
													}

													print '<tr><td><input type="hidden" name="grain[]" value="' . $grain -> get_ID() . '"><input type="text" name="amount[]" class="input-mini" value="' . $order -> get_amount() . '" ></td>';
													print '<td>' . $grain -> get_name() . " - " . $grain -> get_vendor() . "<br />Pounds " . $grain -> get_pound() . '</td>';
													print '<td>$' . number_format($price * $grain -> get_pound(), 2) . '</td>';
													print '<td>$' . number_format($grain -> get_pound() * $price * $order -> get_amount(), 2) . '</td>';
													print '<td class="ms"><div class="btn-group1">';
													if ($groupBuy -> allowSplit($numOfSplit)) {
														print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-toggle="modal" data-original-title=" Split " data-item-id="'.$grain->get_ID().'" href="#viewModal"><i class="icon-resize-full"></i></a>';
													}
													print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a><a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove" href="' . $removeGrainURL . '"><i class="gicon-remove icon-white"></i></a></div></td>';
													$x = $x + 1;
												}//end for

												if (is_array($orderProduct)) {
													$productTotal = 0;
													foreach ($orderProduct as $i => $value) {
														$order = $orderProduct[$i];
														$product = $order -> get_product();
														$price = $product -> get_price() * $order -> get_amount();
														$total = $total + $price;
														print '<tr><td><input type="text" name="amountProduct[]" class="input-mini" value="' . $order -> get_amount() . '" ><input type="hidden" name="product[]" value="' . $product -> get_ID() . '"></td>';
														if ($product -> get_type() == 'hops') {
															$id = "#splitModal" . $x;
															print '<td>' . $product -> get_name() . ' - ' . $product -> get_vendor() . '<br />Pounds ' . $product -> get_pounds() . '</td>';
															print '<td>$' . number_format($product -> get_price(), 2) . '</td>';
															print '<td>$' . number_format($price, 2) . '</td>';
															print '<td class="ms"><div class="btn-group1">';
															if ($groupBuy -> allowSplit($numOfSplit)) {
																print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-toggle="modal" data-original-title=" Split " href="' . $id . '"><i class="icon-resize-full"></i></a>';
															}
															print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" edit " href="#"><i class="gicon-edit"></i></a><a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove" href="removeProduct.php?id=' . $groupBuyID . '&productID=' . $product -> get_ID() . '" ><i class="gicon-remove icon-white"></i></a></div></td>';
															$x = $x + 1;
														} else {
															$id = "#splitModal" . $x;
															print '<td>' . $product -> get_name() . ' - ' . $product -> get_vendor() . '</td>';
															print '<td>$' . number_format($product -> get_price(), 2) . '</td>';
															print '<td>$' . number_format($price, 2) . '</td>';
															print '<td class="ms"><div class="btn-group1">';
															if ($groupBuy -> allowSplit($numOfSplit)) {
																print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-toggle="modal" data-original-title=" edit " href="' . $id . '"><i class="icon-resize-full"></i></a>';
															}
															print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" edit "  href="#"><i class="gicon-edit"></i></a><a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove" href="removeProduct.php?id=' . $groupBuyID . '&productID=' . $product -> get_ID() . '"><i class="gicon-remove icon-white"></i></a></div></td>';
															$x = $x + 1;
														}

													}//end foreach
												}//end if

												if (is_array($orderSplit)) {
													$splitTotal = 0;
													foreach ($orderSplit as $y => $value) {
														$split = $orderSplit[$y];
														$product = $split -> get_product();
														$grain = $split -> get_grain();

														if ($grain -> get_ID() != "") {
															$grain = $dao -> getGrain($grain -> get_ID());
															$pounds = ($grain -> get_pound($groupBuyTotal) / $split -> get_totalSplit());
															$price = $grain -> getPoundPrice($groupBuyTotal);
															$total = $total + ($price * $pounds * $split -> get_amount());
															$removeSplitURL = 'removeSplit.php?id=' . $groupBuyID . '&splitID=' . $split -> get_splitID();

															print '<tr><td><input type="hidden" name="splitGrain[]" value="' . $split -> get_splitID() . '"><input type="text" name="amountSplitGrain[]" class="input-mini" value="' . $split -> get_amount() . '" ></td>';
															print '<td>' . $grain -> get_name() . " - " . $grain -> get_vendor() . "<br />Pounds " . number_format($pounds, 2) . '</td>';
															print '<td>$' . number_format($pounds * $price, 2) . '</td>';
															print '<td>$' . number_format($price * $pounds * $split -> get_amount(), 2) . '</td>';
															print '<td class="ms"><div class="btn-group1"> <a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a><a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove" href="' . $removeSplitURL . '"><i class="gicon-remove icon-white"></i></a></div></td>';
														} else {
															$product = $dao -> getProduct($product -> get_ID());
															$pounds = ($product -> get_pounds($groupBuyTotal) / $split -> get_totalSplit());
															$price = $product -> get_price() / $product -> get_pounds();
															$total = $total + ($price * $pounds * $split -> get_amount());
															$removeSplitURL = 'removeSplit.php?id=' . $groupBuyID . '&splitID=' . $split -> get_splitID();
															$addSplitURL = 'addSplit.php?id=' . $split -> get_splitID() . '&groupbuy=' . $groupBuyID;
															$subtractSplitURL = 'subtractSplit.php?id=' . $split -> get_splitID() . '&groupbuy=' . $groupBuyID;
															$totalPounds = $pounds * $split -> get_amount();
															if ($adminUpdate) {
																$removeSplitURL = $removeSplitURL . "&user=" . $adminUser;
																$addSplitURL = $addSplitURL . "&user=" . $adminUser;
																$subtractSplitURL = $subtractSplitURL . "&user=" . $adminUser;
															}

															print '<tr><td>' . $split -> get_amount() . '</td>';
															print '<td>' . $product -> get_name() . " - " . $product -> get_vendor() . "<br />Pounds " . number_format($pounds, 2) . '</td>';
															print '<td>$' . number_format($pounds * $price, 2) . '</td>';
															print '<td>$' . number_format($price * $pounds * $split -> get_amount(), 2) . '</td>';
															print '<td class="ms">';
															if ($split -> get_available() > 0) {
																print '<div class="btn-group1"><a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" add " href="' . $addSplitURL . '"><i class="icon-plus"></i></a>';
															}
															print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" subtract " href="' . $subtractSplitURL . '"><i class="icon-minus"></i></a><a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove" href="' . $removeSplitURL . '"><i class="gicon-remove icon-white"></i></a></div></td>';
														}
													}
												}
												if ($groupBuy -> get_shipping() != "") {
													$shipping = $groupBuy -> get_shipping();
													$shippingCosts = ($shipping / $groupBuyTotal) * $totalPounds;
													print '<tr><td></td><td>Shipping:</td><td></td><td>$' . number_format($shippingCosts, 2) . '</td><td></td></tr>';
												}
												print '<tr><td></td><td>Total:</td><td></td><td>$' . number_format($total, 2) . '</td><td></td></tr>';
											?>
</tbody>
										</table>
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
									<h4><i class="icon-resize-full"></i><span>Available Splits</span></h4>
								</div>
								<!-- End .title -->
								<div class="content">
									<table id="datatable_example" class="responsive table table-striped" style="width:100%;margin-bottom:0; ">
										<thead>
											<tr>
												<th> No </th>
												<th> Name </th>
												<th> Amount Per Split </th>
												<th> Amount Available </th>
												<th> Action </th>
											</tr>
										</thead>
										<tbody>
											<?php $x = 1;
											$results = $dao -> getAvailableSplits($groupBuyID);
											foreach ($results as $row) {
												$addSplitURL = 'addSplit.php?id=' . $row["split_ID"] . '&groupbuy=' . $groupBuyID;
												if ($adminUpdate) {
													$addSplitURL = $addSplitURL . "&user=" . $adminUser;
												}
												if ($row["grain_ID"] != null) {
													print '<tr><td>' . $x . '</td><td>' . $row["grain_name"] . '</td><td>' . number_format($row["grain_pounds"] / $row["total"], 2) . '</td><td>' . $row["available_int"] . '</td><td><a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" Add Split " href="' . $addSplitURL . '"><i class="icon-plus"></i></a></td></tr>';
												} else {
													print '<tr><td>' . $x . '</td><td>' . $row["product_name"] . '</td><td>' . $row["product_pounds"] / $row["total"] . '</td><td>' . $row["available_int"] . '</td><td><a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" Add Split " href="' . $addSplitURL . '"><i class="icon-plus"></i></a></td></tr>';
												}
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
			<?php include_once("includes/footer.php")
?>
		</div>
		<!-- /container -->
		<script id="body-tmpl" type="text/template">
		<table class="responsive table table-hover table-striped dataTable">
		    <thead>
		        <tr>
		            <th class="jv">No</th>
		            <th class="ue">Individual ID</th>
		            <th class="ue">First Name</th>
		            <th class="ue">Last Name</th>
		            <th class="ue">Date of Birth</th>
		            <th class="ue">Gender</th>
		            <th class="ue">Zip Code</th>
		            <th class="ue">Security Code</th>
		            <td class="jv">&nbsp;</td>
		        </tr>
		    </thead>
		    <tbody>
		    <% _.each(data, function(datum, index) { %>
		        <tr>
		            <td class="jv"><%= index + 1 %></td>
		            <td class="ue"><a href="#viewModal" data-user-id="<%= datum.id %>" class="underline view"><%= datum.id %></a></td>
		            <td class="ue"><%= datum.firstName %></td>
		            <td class="ue"><%= datum.lastName %></td>
		            <td class="ue"><%= datum.dateOfBirth %></td>
		            <td class="ue"><%= datum.genderId %></td>
		            <td class="ue"><%= datum.zipCode %></td>
		            <td class="ue"><%= datum.securityCode %></td>
		            <td class="jv"><a class="btn btn-small edit" data-user-id="<%= datum.id %>" ><i class="gicon-edit"></i></a></td>
		        </tr>
		    <% }); %>
		    </tbody>
		</table>
		</script>
		
		<script id="split_tmpl" type="text/template">
			<form id="splitForm" action="api/split.php" method="POST">
			   	<input type="hidden" name="id" value="<%= data.id %>" />
				<input type="hidden" name="groupBuyID" value="<%= data.groupBuyId %>" />
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			        <h3><i class="icon-resize-full"></i>Split <%=data.name %></h3>
			    </div>
			    <div class="modal-body">
					<p><%= data.name %> - <$= data.vendor %></p>
					<div class="control-group row-fluid">
						<label for="numOfSplit" class="row-fluid ">Split #:</label>
						<div class="controls row-fluid input-append">
							<select name="numOfSplit">
							</select>
						</div>
					</div>	
					<div class="control-group row-fluid">
						<label for="quantity" class="row-fluid ">Quantity</label>
						<div class="controls row-fluid input-append">
							<input type="text" name="quantity" />
						</div>
					</div>			
			    </div>
			    <div class="modal-footer">
			        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			        <button type="submit" class="btn btn-primary">Submit</button>
			    </div>
			</form>
		</script>		
		<?php include_once("includes/default-js.php")?>
		<script src="js/viewGroupBuy.js"></script>
	</body>
</html>