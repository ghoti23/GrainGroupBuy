<div class="subnav clearfix">
    <ul class="nav nav-pills pull-right">
        <li class="text">Product Types:</li>
        <?php if ($groupBuy->getHopsOnly() != 0) {?><li <?php if ($sub_title == 'Hops') {?>class="active"<?php } ?>><a href="/new/hops.php">Hops</a></li><?php } ?>
        <?php if ($groupBuy->getGrainOnly() != 0) {?><li <?php if ($sub_title == 'Grains') {?>class="active"<?php } ?>><a href="/new/grains.php">Grains</a></li><?php } ?>
        <li <?php if ($sub_title == 'Beer Adjuncts') {?>class="active"<?php } ?>><a href="/new/beer-adjuncts.php">Beer Adjuncts</a></li>
        <li <?php if ($sub_title == 'Beer Additives') {?>class="active"<?php } ?>><a href="/new/beer-additives.php">Beer Additives</a></li>
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