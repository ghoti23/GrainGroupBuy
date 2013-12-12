<?php
print "<h1 class='section'>Active Splits</h1>";
print "<p class='section'>In order to achieve significant cost savings, we need to buy our products in bulk - typically 11 lbs of hops or 50 lbs of grain.  This is often too much for the average brewer, so we allow product 'splits' which enables our members to order 1 lb of hops or 25 lbs of grain in certain cases.  However, these splits cannot be added to the final order until enough members reach the product bulk size requirement.  Once the product reaches that size, it will move off the active split list and can be placed on the final order.</p>";
print "<ul class='product-list'>";
$index = 1;
foreach ($products as $productSplit) {
    $product = $productSplit -> getProduct();
    $price = $utils->getDisplayPrice($user, $product, $groupBuy);
    $vendor = $product->getVendor();
    $percentComplete = $productSplit -> getPercentComplete();
    ?>
    <li class="split">
        <img src="<?php print $product->getImagePath()?>" />
        <em><?php print $product->getName()?></em>
        <?php if (!empty($vendor)) { print '<div class="vendor">' . $vendor . "</div>"; } ?>
        <div class="price"><?php print $product->getDisplayUnits() . " @ " . '$' . $price ?> &nbsp;</div>
        <div class="progress">
            <div class="progress-bar progress-bar-split" role="progressbar" aria-valuenow="<?php print $percentComplete?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php print $percentComplete?>%">
                <span class="sr-only"><?php print $productSplit->getDisplayAmount() . " of " . $product->getPoundsWithUnit() ?></span>
            </div>
        </div>
        <div class="progress-detail"><?php print $productSplit->getDisplayAmount() . " of " . $product->getPoundsWithUnit() ?></div>
        <div class="desc hide"><?php print $product->getDescription()?></div>
        <div><a class="button add" href="#" data-id="<?php print $product->getId()?>" data-type="<?php print $product->getType()?>" data-split="<?php print $product->getSplit()?>" data-pounds="<?php print $product->getPounds()?>">Add</a></div>
    </li>
<?php
}
print "</ul>";
?>