<?php
if (!empty($products)) {
    print "<ul class='product-list'>";
    $index = 1;
    foreach ($products as $product) {
        $price = $utils->getDisplayPrice($user, $product, $groupBuy);
        $vendor = $product->getVendor();
        $desc = $product->getDescription();
        $discountPercentage = $utils->getDiscountPercent($price, $product->getRetailPrice());
        ?>
        <li>
            <img src="<?php print $product->getImagePath()?>" />
            <em><?php print $product->getName()?></em>
            <?php if (!empty($vendor)) { print '<div class="vendor">' . $vendor . "</div>"; } ?>
            <div class="price"><?php print $product->getDisplayUnits() . " @ " . '$' . $price ?> &nbsp;</div>
            <?php if (!empty($discountPercentage) && false) { ?>
                <div class="discount"><?php print $discountPercentage . "% Off Retail"; ?></div>
            <?php } ?>
            <div class="desc hide"><?php print $product->getDescription()?></div>
            <div><a class="button add" href="#" data-id="<?php print $product->getId()?>" data-type="<?php print $product->getType()?>" data-split="<?php print $product->getSplit()?>" data-pounds="<?php print $product->getPounds()?>">Add</a></div>
        </li>
    <?php
    }
    print "</ul>";
}
?>