<?php if (isset($user)) {  ?>
    <?php
    if (isset($groupBuy)) {
        $days = $groupBuy -> getDaysRemaining();
        if ($groupBuy -> isActive()) {
            if ($days > 1) {
                print "<div class='alert alert-success'>" . $days . " Days Remaining!</div>";
            }
            else {
                print "<div class='alert alert-success'>Last Day To Order!</div>";
            }
        }
        else {
            if ($days > 1) {
                print "<div class='alert alert-info'>" . $days . " Days Until Next Group Buy!</div>";
            }
            else {
                print "<div class='alert alert-info'>Ordering Starts Tomorrow!</div>";
            }
        }
    }
    ?>
<?php } ?>