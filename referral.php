<?php
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';

session_start();

$user = $_SESSION['user'];
if ($user == null) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php") ?>
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="container">
    <div class="body-spacer">

        <div class="row">
            <div class="col-md-10 referral">
                <div class="centered">
                    <h1>Invite your friends to join!</h1>
                    <h3>You're welcome to invite up to 3 friends to join the group buy site.  We've place limits on the number of members since we do this outside of our day jobs and can't support a large amount of questions.</h3>
                </div>
                <div class="box">
                    <form method="POST" class="clearfix">
                        <div class="text">
                            <span>
                                <label for="username">Email #1</label>
                                <input type="text" name="username" id="username" placeholder="Email #1" maxlength="100" tabindex="1" autofocus <?php if (isset($email)) {  ?>value="<?php print $email ?>"<?php } ?>>
                            </span>
                        </div>
                        <div class="text">
                            <span>
                                <label for="username">Email #2</label>
                                <input type="text" name="username" id="username" placeholder="Email #2" maxlength="100" tabindex="2"  <?php if (isset($email)) {  ?>value="<?php print $email ?>"<?php } ?>>
                            </span>
                        </div>
                        <div class="text">
                            <span>
                                <label for="username">Email #3</label>
                                <input type="text" name="username" id="username" placeholder="Email #3" maxlength="100" tabindex="3"  <?php if (isset($email)) {  ?>value="<?php print $email ?>"<?php } ?>>
                            </span>
                        </div>
                        <div class="login-btn">
                            <input type="submit" value="Send invites">
                        </div>
                    </form>
                    <div class="footer-msg">
                        <p><a href="dashboard.php">I'll try this later.</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <?php include_once("includes/right-nav.php")?>
            </div>
        </div>
    </div>
</div>
<?php include_once("includes/footer.php")?>
</body>
</html>