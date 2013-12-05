<header>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href="/new/index.php" class="site-logo"><img src="/img/art_of_beer_tiny.png" /></a>
            </div>
            <div class="col-md-10">
                <ul class="site-nav pull-right">
                    <li><a class="link" href="/new/calculators.php">Useful Tools</a></li>
                    <li><a class="link" href="/new/faqs.php">FAQs</a></li>

                    <?php if (!isset($user)) {  ?>
                        <li class="separator"><a class="button grey" href="/new/login.php">Log In</a></li>
                        <li><a class="button" href="/new/signup.php">Sign Up</a></li>
                    <?php } ?>

                    <?php if (isset($user)) {  ?>
                        <li><a class="link" href="/new/logout.php">Logout</a></li>
                        <li class="separator">
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
                                        print "<div class='alert alert-success'>Ordering Starts Tomorrow!</div>";
                                    }
                                }
                            }
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="banner-callout">
    <b>It seems you don’t have a username.</b> Choosing a username will allow you to join
    the discussion and show off your amazing new profile.
    <a href="#" class="btn" >Choose a username</a>
</div>