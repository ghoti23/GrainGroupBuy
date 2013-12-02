<!-- Modal -->
<?php
	//Builds out mutliple modals for splits
	$x=1;
	foreach ($orders as $i => $value) {
		$order = $orders[$i];
		$grain = $order->get_grain();
		$id = "splitModal" . $x;
?>
<form action="splitProduct.php" method="POST">
	<input type="hidden" name="grainID" value="<?php echo $grain->get_ID(); ?>" />
	<input type="hidden" name="groupBuyID" value="<?php echo $groupBuyID; ?>" />
	<?php
	if ($adminUpdate) {
		print  '<input type="hidden" name="user" value="'.$adminUser.'" />';
	}	
	?>	
<div id="<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" ><i class="icon-resize-full"></i> Split</h3>
	</div>
	<div class="modal-body">
		<p><?php print $grain->get_name() . ' - '. $grain->get_vendor() . '<br />Split: <select name="numOfSplit" class="span1">'; 
			for ($i = 2; $i <= 5; $i++) {
		    	print '<option value="' . $i . '">' . $i . '</option>';
			}
			print '</select><br />Quantity: <input type="text" name="quantity" />';
		   ?>
		</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary">Save changes</button>
	</div>
</div>
</form>
<?php
		$x=$x+1;
	}
		foreach ($orderProduct as $i => $value) {
			$order = $orderProduct[$i];
			$product = $order->get_product();
			$price = $product->get_price()*$order->get_amount();
			$id = "splitModal" . $x;
			$pounds = $product->get_pounds();
			if (!empty($pounds)) {
	?>
	<form action="splitProduct.php" method="POST">
	<input type="hidden" name="productID" value="<?php echo $product->get_ID(); ?>" />	
	<input type="hidden" name="groupBuyID" value="<?php echo $groupBuyID; ?>" />	
	<?php
	if ($adminUpdate) {
		print  '<input type="hidden" name="user" value="'.$adminUser.'" />';
	}
	?>
	<div id="<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel" ><i class="icon-resize-full"></i> Split</h3>
		</div>
		<div class="modal-body">
			<p><?php print $product->get_name() . ' - '. $product->get_vendor() . '<br />Split: <select name="numOfSplit" class="span1">'; 
				for ($i = 2; $i <= $pounds; $i++) {
			    	print '<option value="' . $i . '">' . $i . '</option>';
				}
				print '</select><br />Quantity: <input type="text" name="quantity" />';
			   ?>
			</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button type="submit" class="btn btn-primary">Split Item</button>
		</div>
	</div>
	</form>
	<?php
			}
			$x=$x+1;
		}	
?>