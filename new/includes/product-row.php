<?php
$index = 1;
foreach ($products as $product) {
    $price = $utils->getMarkupPrice($user, $product, $groupBuy);
    $vendor = $product->getVendor()
    ?>
    <li class="list-group-item light">
        <form class="order-add hidden" method="post">
            <input type="hidden" name="id" value="<?php print $product->getId()?>" />
            <span>How many?</span>
            <select name="value">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <input type="button" class="btn grey cancel" value="Cancel" />
            <input type="submit" value="Save" />
        </form>
        <a class="button add" href="#">Add</a>
        <em><span><?php echo $index++ ?>.</span> <?php print $product->getName()?></em> <?php if (!empty($vendor)) { print ' - ' . $vendor; } ?>
        <div><?php print $product->getUnits() . " @ " . '$' . $price ?> &nbsp;</div>
    </li>
<?php
}
?>