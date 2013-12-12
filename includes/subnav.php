<div class="subnav clearfix">
    <ul class="nav nav-pills pull-right">
        <li class="text">Product Types:</li>
        <?php if ($groupBuy->getHopsOnly() != 0) {?><li <?php if ($sub_title == 'Hops') {?>class="active"<?php } ?>><a href="hops.php">Hops</a></li><?php } ?>
        <?php if ($groupBuy->getGrainOnly() != 0) {?><li <?php if ($sub_title == 'Grains') {?>class="active"<?php } ?>><a href="grains.php">Grains</a></li><?php } ?>
        <li <?php if ($sub_title == 'Beer Additives & Supplies') {?>class="active"<?php } ?>><a href="beer-supplies.php">Beer Additives & Supplies</a></li>
    </ul>

    <h1>
        <?php
        if (isset($sub_title)) {
            print $sub_title;
        } else {
            print "Home";
        }
        ?>
    </h1>
</div>