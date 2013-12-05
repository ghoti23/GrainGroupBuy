<?php
require '../dao/groupBuyDao.php';
require '../dao/userDao.php';
require '../dao/orderDao.php';
require '../dao/productDao.php';
require '../entity/user.php';
require '../entity/groupbuy.php';
require '../entity/order.php';
require '../entity/product.php';
require '../entity/ProductSplit.php';
require '../entity/split.php';
require '../properties.php';
require '../utils.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $password = strip_tags($_REQUEST["password"]);
    $confirmPassword = strip_tags($_REQUEST["confirmPassword"]);

    if ($password != $confirmPassword) {
        $message = 'Sorry, but your email or password was not correct.';
    } else {
        $message = 'Sorry, but your email or password was not correct.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php")?>
</head>
<body class="login">

<div class="content">
    <div class="logo">
        <a href="/new/index.php"><img src="/img/art_of_beer_sm.png" /></a>
    </div>
    <h3 class="centered">Reset password</h3>
    <div class="box">
        <?php if (!empty($message)) {  ?>
            <div class="alert alert-danger">
                <?php echo $message ?>
            </div>
        <?php } ?>
        <form action="/new/login.php" method="post">
            <div class="text">
                <span>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" maxlength="100" tabindex="1" autofocus >
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" maxlength="100"  tabindex="2">
                </span>
            </div>
            <div class="login-btn">
                <input type="submit" value="Reset password">
            </div>
        </form>
    </div>
    <div class="footer-msg">
        <p>Don't have an account? <a href="/new/signup.php">Sign up.</a></p>
    </div>

    <div class="ad-row">
        <div class="sponsored">SPONSORED</div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Footer Ad -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-5071928133115505"
             data-ad-slot="1128070273"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

</div>
</body>
</html>