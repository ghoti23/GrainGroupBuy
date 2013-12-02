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

$dao = new userDao();
$dao -> connect($host, $pdo);

$user = $_SESSION['user'];
if ($user == null) {
    header("location:index.php");
}
$adminUpdate = false;
$adminUser="";
if (!empty($_REQUEST["user"])) {
    $adminUser = strip_tags($_REQUEST["user"]);
}

if (($adminUser != "") && $_SESSION['admin']) {
    $user = $dao -> getUser($adminUser);
    $adminUpdate = true;
}

$groupBuyID = strip_tags($_REQUEST["id"]);
$_SESSION["groupBuyId"] = $groupBuyID;


//Verify Active Group Buy
$dao = new groupBuyDao();
$dao -> connect($host, $pdo);
$active = $dao -> activeGroupBuy($groupBuyID);

if (!$active && $_SESSION['admin'] != 1) {
    header("location:dashboard.php");
}


$groupBuy = $dao -> get($groupBuyID);
$date = date('Y-m-d H:i:s');
if (strtotime($groupBuy->getEndDate()) < strtotime($date) && $_SESSION['admin'] != 1) {
    header("location:dashboard.php");
}

$dao = new orderDao();
$dao -> connect($host, $pdo);
$orders = $dao -> get($groupBuyID, $user);
$numOfSplit = $dao -> getNumOfSplit($groupBuyID);
$total=0;
$foodTotal=0;
$otherTotal=0;
$utils = new Utils;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<title>Group Buy - View Group Buy</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo strtotime($date) ?>">
		<meta name="author" content="<?php echo strtotime($groupBuy->getEndDate()) ?>">
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
			require_once ('includes/sidenav.php');
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
										<h4><i class=" icon-bar-chart"></i><span>

                                            <?php print $groupBuy -> getName();
											if ($adminUpdate) {
												print " - Viewing " . $user -> getUsername() . " order";
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
								<p>Owner: <?php print $groupBuy -> getOwner(); ?></p>
								<p>Notes: <?php print $groupBuy -> getNotes(); ?></p>
                                <?php
                                if ($groupBuy -> getQuote() != "") {
                                   echo  "<p>Catalog: <a href='". $groupBuy -> getCatalog() . "' target='_blank'>View Catalog</a></p>";
                                }
								if ($groupBuy -> getQuote() != "") {
									echo "<p>Quote: <a href='" . $groupBuy -> getQuote() . "' target='_blank'>View Quote</a></p>";
								}
								if ($groupBuy -> getShipping() != "") {
									echo "<p>Shipping: " . $groupBuy -> getShipping() . "</p>";
								}
							    ?>
								<p>
									Total Pounds Ordered: <?php $groupBuyTotal= $dao->getTotalPounds($groupBuyID); echo $groupBuyTotal;?></p>
                                    <div id="updateStatus"></div>
									<form action="viewGroupBuy.php" method="POST" id="viewGroupBuy">
										<input type="hidden" name="groupBuyId" value="<?php echo $groupBuyID; ?>">
										<table id="results-section" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
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
												<?php $order = $dao -> get($groupBuyID, $user);
												$totalPounds = 0;
                                                $x=0;
                                                $products = $order->getProduct();
												if (is_array($products)) {
													$productTotal = 0;
													foreach ($products as $product) {
                                                        $price = $utils->getMarkupPrice($user,$product,$groupBuy);
                                                        $totalPrice = $price * $product->getAmount();
														$total = $total + $totalPrice;
                                                        if ($product->getType() == 'grain' || $product->getType() == 'hops') {
                                                            $foodTotal = $foodTotal + ($price*$product->getAmount());
                                                        } else {
                                                            $otherTotal = $otherTotal + ($price*$product->getAmount());
                                                        }
														print '<tr><td><input type="text" name="amountProduct[]" class="input-mini" value="' . $product -> getAmount() . '" ><input type="hidden" name="product[]" value="' . $product -> getId() . '"></td>';
														$name = "";
                                                        if ($product -> getType() == 'hops') {
                                                            $name = $product -> getName() . ' - ' . $product -> getVendor() . '<br />Pounds ' . $product -> getPounds();
                                                        } else {
                                                            $name = $product -> getName() . ' - ' . $product -> getVendor();
                                                        }
                                                        print '<td>' . $name . '</td>';
                                                        print '<td>$' . number_format($price, 2) . '</td>';
                                                        print '<td>$' . number_format($totalPrice, 2) . '</td>';
                                                        print '<td class="ms"><div class="btn-group1">';
                                                        if ($groupBuy -> allowSplit($numOfSplit) && $product->getSplit() > 1) {
                                                            print '<a class="btn btn-small split" rel="tooltip" data-placement="left" data-toggle="modal" data-original-title=" Split " data-groupBuy-id="'.$groupBuy->getId().'" data-view-id="'.$product->getId().'" href="#"><i class="icon-resize-full"></i></a>';
                                                        }
                                                        $removeURL = "removeProduct.php?id=" . $product->getId() . "&groupBuyId=" . $groupBuyID;
                                                        print '<a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove" href="'.$removeURL.'" ><i class="gicon-remove icon-white"></i></a></div></td>';
                                                        $x = $x + 1;
                                                        $totalPounds = $totalPounds+($product->getPounds() * $product -> getAmount());

													}//end foreach
												}//end if

                                                $splits = $order->getSplit();
												if (!empty($splits)) {
													$splitTotal = 0;

													foreach ($splits as $split) {
                                                        $product = $split -> getProduct();
                                                        $pounds = ($product -> getPounds($groupBuyTotal) / $split -> getSplitAmount());
                                                        $price = $utils->getMarkupPrice($user,$product,$groupBuy)/$split->getSplitAmount();
                                                        $totalPrice = ($price*$product->getAmount());
                                                        $total = $total + ($price*$product->getAmount());
                                                        if ($product->getType() == 'grain' || $product->getType() == 'hops') {
                                                            $foodTotal = $foodTotal + ($price*$product->getAmount());
                                                        } else {
                                                            $otherTotal = $otherTotal + ($price*$product->getAmount());
                                                        }
                                                        $removeSplitURL = 'api/split/remove.php?id=' . $split -> getId() . '&groupBuy=' . $groupBuyID;
                                                        $addSplitURL = 'addSplit.php?id=' . $split -> getId() . '&groupBuy=' . $groupBuyID;
                                                        $subtractSplitURL = 'subtractSplit.php?id=' . $split -> getId() . '&groupBuy=' . $groupBuyID;
                                                        $totalPounds = $totalPounds+($pounds * $product -> getAmount());
                                                        if ($adminUpdate) {
                                                            $removeSplitURL = $removeSplitURL . "&user=" . $adminUser;
                                                            $addSplitURL = $addSplitURL . "&user=" . $adminUser;
                                                            $subtractSplitURL = $subtractSplitURL . "&user=" . $adminUser;
                                                        }

                                                        print '<tr><td>' . $product -> getAmount() . '</td>';
                                                        print '<td>' . $product -> getName() . " - " . $product -> getVendor() . "<br />Pounds " . number_format($pounds, 2) . '</td>';
                                                        print '<td>$' . number_format($price, 2) . '</td>';
                                                        print '<td>$' . number_format($totalPrice, 2) . '</td>';
                                                        print '<td class="ms">';

                                                        if ($dao -> getSplitAvailablity($split->getId()) > 0) {
                                                            print '<div class="btn-group1"><a class="btn btn-small viewModal" rel="tooltip" data-placement="left" data-original-title=" add " href="' . $addSplitURL . '"><i class="icon-plus"></i></a>';
                                                        }
                                                        $removeURL = "removeSplit.php?id=" . $split->getId() . "&groupBuyId=" . $groupBuyID;
                                                        print '<a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" subtract " href="' . $subtractSplitURL . '"><i class="icon-minus-sign"></i></a><a class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Remove"  href="'.$removeURL.'"><i class="gicon-remove icon-white"></i></a></div></td>';
													}
												}
												if ($groupBuy -> getShipping() != "") {
													$shipping = $groupBuy -> getShipping();
                                                    $shipping = number_format(($shipping / $groupBuyTotal),3);
													$shippingCosts = $shipping * $totalPounds;
                                                    $total = $total + $shippingCosts;
													print '<tr><td></td><td>Shipping:</td><td></td><td>$' . number_format($shippingCosts, 2) . '</td><td></td></tr>';
												}
                                                if ($groupBuy->getTax()) {
                                                    $tax=($foodTotal*$foodTax);
                                                    $tax=$tax+($otherTotal*$otherTax);
                                                    $total=$total+$tax;
                                                    print '<tr><td></td><td>Tax: (Food = '.($foodTax*100).'%; Nonfood = '. ($otherTax*100).'%)</td><td></td><td>$' . number_format($tax, 2) . '</td><td></td></tr>';
                                                }
												print '<tr><td><a href="#" class="btn btn-info update" ><i class="icon-edit"></i> Update Order</a></td><td>Total:</td><td></td><td>$' . number_format($total, 2) . '</td><td></td></tr>';
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
                                                <th> Price Per Split </th>
												<th> Amount Available </th>
												<th> Action </th>
											</tr>
										</thead>
										<tbody>
											<?php $x = 1;
											$results = $dao -> getAvailableSplits($groupBuyID);
											foreach ($results as $row) {
												$addSplitURL = 'addSplit.php?id=' . $row["id"] . '&groupBuy=' . $groupBuyID;
                                                $amountPerSplit = ($row["pounds"] / $row["splitAmt"]);
                                                $product = new Product();
                                                $product->setPrice($row["price"]);
                                                $product->setType($row["type"]);
                                                $product->setPounds($row["pounds"]);
                                                $pricePerSplit = $utils->getMarkupPrice($user,$product,$groupBuy)/$row["splitAmt"];

												if ($adminUpdate) {
													$addSplitURL = $addSplitURL . "&user=" . $adminUser;
												}
												print '<tr><td>' . $x . '</td><td>' . $row["product_name"] . '</td><td>' . $amountPerSplit . '</td><td>$'.number_format($pricePerSplit,2).'</td><td>' . $row["available"] . '</td><td><a class="btn btn-small" rel="tooltip" data-placement="left" data-original-title=" Add Split " href="' . $addSplitURL . '"><i class="icon-plus"></i></a></td></tr>';
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
			<div id="viewModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			</div>
			<?php include_once("includes/footer.php")?>
		</div>
		<!-- /container -->
		<?php include_once("includes/default-js.php")?>
		<script language="JavaScript">
            var groupBuyId = <?php echo $groupBuy->getId() ?>;
		</script>
        <script src="js/viewGroupBuy.js"></script>
        <script id="split-edit-tmpl" type="text/template">
            <form id="splitForm" method="POST" action="api/split/split.php">
                <input type="hidden" name="id" value="<%= data.id %>" />
                <input type="hidden" name="groupBuyID" value="<%= data.groupBuyId %>" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3><i class="icon-resize-full"></i> Split <%=data.name %></h3>
                </div>
                <div class="modal-body">
                    <p><%= data.name %> - <%= data.vendor %></p>
                    <div class="control-group row-fluid">
                        <label for="numOfSplit" class="row-fluid ">Split #:</label>
                        <div class="controls row-fluid input-append">
                            <select name="numOfSplit">
                                <%for (i=2; i<= data.splitAmt; i++) {%>
                                    <option value='<%= i %>'><%= i %></option>
                                <%}%>
                            </select>
                        </div>
                    </div>
                    <div class="control-group row-fluid">
                        <label for="quantity" class="row-fluid ">Quantity</label>
                        <div class="controls row-fluid input-append">
                            <input type="text" class="required" name="quantity" /><div id="splitError">Please enter a valid quantity</div>
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