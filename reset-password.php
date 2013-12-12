<?php
require 'dao/dao.php';
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'dao/ResetTokenDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/ProductSplit.php';
require 'entity/ResetToken.php';
require 'properties.php';
require 'Mandrill.php';
require 'utils.php';

if (!isset($_REQUEST["id"])) {
    header("location:index.php");
    return;
}

$id = strip_tags($_REQUEST["id"]);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $password = strip_tags($_REQUEST["password"]);
    $confirmPassword = strip_tags($_REQUEST["confirmPassword"]);

    if ($password != $confirmPassword) {
        $message = 'Sorry, but your email or password was not correct.';
    } else {

        $resetTokenDao = new ResetTokenDao();
        $resetTokenDao->connect($host,$pdo);
        $token = $resetTokenDao->get($id);

        if (isset($token)) {
            $dao = new dao();
            $dao->connect($host,$pdo);
            $user = $dao->loadUser($token->getEmail());
        }

        if (!isset($user)) {
            $message = 'Sorry, but your password could not be reset.';
        } else {

            $clean_pw = crypt(md5($password), md5($user->getEmail()));

            $userDao = new userDao();
            $userDao->connect($host,$pdo);
            $userDao->updateAccountPassword($user->getEmail(), $clean_pw);

            header("location:login.php?r=1");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php") ?>
</head>
<body class="login">

<div class="content">
    <div class="logo">
        <a href="index.php"><img src="img/groupbuy_white_tiny.png" /></a>
    </div>
    <h3 class="centered">Reset password</h3>
    <div class="box">
        <?php if (!empty($message)) {  ?>
            <div class="alert alert-danger">
                <?php echo $message ?>
            </div>
        <?php } ?>
        <form action="/reset-password.php" method="post">
            <input type="hidden" name="id" value="<?php print $id ?>" />
            <div class="text">
                <span>
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" placeholder="New Password" maxlength="100" tabindex="1" autofocus >
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm New Password" maxlength="100"  tabindex="2">
                </span>
            </div>
            <div class="login-btn">
                <input type="submit" value="Reset password">
            </div>
        </form>
    </div>
    <div class="footer-msg">
        <p>Don't have an account? <a href="/signup.php">Sign up.</a></p>
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