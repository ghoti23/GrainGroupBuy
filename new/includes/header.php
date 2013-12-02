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
                                if ($groupBuy -> isActive()) {
                                    print "<div class='alert alert-success'>" . $groupBuy -> getDaysRemaining() . " Days Remaining!</div>";
                                }
                                else {
                                    print "<div class='alert alert-info'>" . $groupBuy -> getDaysRemaining() . " Days Until Next Group Buy!</div>";
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