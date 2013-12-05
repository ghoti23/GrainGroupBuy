<?php
$index = 1;
foreach ($products as $product) {
    $price = $utils->getDisplayPrice($user, $product, $groupBuy);
    $vendor = $product->getVendor();
    $desc = $product->getDescription();
    $discountPercentage = $utils->getDiscountPercent($price, $product->getRetailPrice());
    ?>
    <li class="list-group-item light">
        <form class="order-add hidden" method="post">
            <input type="hidden" name="id" value="<?php print $product->getId()?>" />
            <span>How much?</span>
            <select name="value">
                <?php
                    if ($product->getType() == "grain") {
                        if ($product->getSplit() > 0) {
                            $count = 1;
                            $orderUnit = $product->getPounds() / $product->getSplit();
                            for ($i = .5; $i <= 10; $i += .5) {
                                print "<option value='" . $i . "'>" . $count++ * $orderUnit . " lbs</option>";
                            }
                        }
                        else {
                            for ($i = 1; $i <= 10; $i++) {
                                print "<option value='" . $i . "'>" . $i * $product->getPounds() . " lbs</option>";
                            }
                        }
                    }
                    elseif ($product->getType() == "hops") {
                        for ($i = 1; $i <= 11; $i++) {
                            print "<option value='" . ($i / 11) . "'>" . $i . " lbs</option>";
                        }
                    }
                    else {
                        for ($i = 1; $i <= 10; $i++) {
                            print "<option value='" . $i . "'>" . $i . "</option>";
                        }
                    }
                ?>
            </select>

            <input type="button" class="btn grey cancel" value="Cancel" />
            <input type="submit" value="Save" />
        </form>

        <?php if (isset($activeGroupBuy)) {  ?>
            <a class="button add" href="#">Add</a>
        <?php } ?>

        <em><span><?php echo $index++ ?>.</span> <?php print $product->getName()?></em> <?php if (!empty($vendor)) { print ' - ' . $vendor; } ?>
        <?php if (!empty($desc)) { ?>
            <div class="desc"><?php print $desc; ?></div>
        <?php } ?>
        <div><?php print $product->getDisplayUnits() . " @ " . '$' . $price ?> &nbsp;</div>
        <?php if (!empty($discountPercentage) && false) { ?>
            <div class="discount"><?php print $discountPercentage . "% Off Retail"; ?></div>
        <?php } ?>
    </li>
<?php
}
?>