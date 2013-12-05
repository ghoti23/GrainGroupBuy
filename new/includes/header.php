<header class="hidden-sm hidden-xs">
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
                    <?php } else { ?>
                    <li><a class="link" href="/new/logout.php">Logout</a></li>
                    <li class="separator">
                        <?php include("days-remaining.php")?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<header class="responsive hidden-md hidden-lg">
    <div class="centered">
        <a href="/new/index.php" class="site-logo"><img src="/img/art_of_beer_tiny.png" /></a>
    </div>
    <div class="centered">
        <?php include("days-remaining.php")?>
    </div>
    <div class="centered">
        <ul class="site-nav">
            <li><a class="link" href="/new/calculators.php">Useful Tools</a></li>
            <li><a class="link" href="/new/faqs.php">FAQs</a></li>

            <?php if (isset($user)) {  ?>
                <li><a class="link" href="/new/logout.php">Logout</a></li>
            <?php } ?>
        </ul>
    </div>
</header>
<!--
<div class="banner-callout">
    <b>It seems you don’t have a username.</b> Choosing a username will allow you to join
    the discussion and show off your amazing new profile.
    <a href="#" class="btn" >Choose a username</a>
</div>
-->