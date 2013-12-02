<header>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href="/new/index.php" class="site-logo"><img src="/img/art_of_beer_tiny.png" /></a>
            </div>
            <div class="col-md-4">
                <?php
                    if (isset($groupBuy)) {
                        if ($groupBuy -> isActive()) {
                            print "<div class='alert alert-success'>Days Remaining: " . $groupBuy -> getDaysRemaining() . "</div>";
                        }
                        else {
                            print "<div class='alert alert-info'>Days Remaining: " . $groupBuy -> getDaysRemaining() . "</div>";
                        }
                    }
                ?>
            </div>
            <div class="col-md-6">
                <ul class="site-nav pull-right">
                    <li><a class="link" href="/new/calculators.php">Useful Tools</a></li>
                    <li><a class="link" href="/new/faqs.php">FAQs</a></li>

                    <?php if (!isset($user)) {  ?>
                        <li class="separator"><a class="button grey" href="/new/login.php">Log In</a></li>
                        <li><a class="button" href="/new/signup.php">Sign Up</a></li>
                    <?php } ?>

                    <?php if (isset($user)) {  ?>
                        <li class="separator"><a class="button grey" href="/new/logout.php">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>