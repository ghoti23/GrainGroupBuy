<?php
require '../dao/userDao.php';
require '../dao/groupBuyDao.php';
require '../entity/groupbuy.php';
require '../entity/user.php';
require '../properties.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $user = new User();
    $dao = new userDao();
    $dao -> connect($host, $pdo);

    $email = strip_tags($_REQUEST["username"]);
    $user -> setEmail($email);
    $pw = strip_tags($_REQUEST["password"]);
    $clean_pw = crypt(md5($pw), md5($email));
    $user -> setPassword($clean_pw);
    $user = $dao -> login($user);

    if ($user != null) {
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['admin'] = $user -> getAdmin();
        if ($user -> getApprove()) {
            $groupBuyDao = new groupBuyDao();
            $groupBuyDao -> connect($host, $pdo);
            $openOrders = $groupBuyDao -> selectCurrentGroupBuy();
            if (!empty($openOrders)) {
                $_SESSION['activeGroupBuy'] = $openOrders[0] -> getId();
            }

            header("location:/new/dashboard.php");
        } else {
            $message = 'You\'re registered but we haven\'t been able to approve your account yet.  It typically takes 24 hours.';
        }
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
    <h3 class="centered">Welcome back!</h3>
    <div class="box">
        <?php if (!empty($message)) {  ?>
            <div class="alert alert-danger">
                <?php echo $message ?>
            </div>
        <?php } ?>
        <form action="/new/login.php" method="post">
            <div class="text">
                <span>
                    <label for="username">Email</label>
                    <input type="text" value="" name="username" id="username" placeholder="Email" maxlength="100" tabindex="1" autofocus>
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="password">Password</label>
                    <input type="password" value="" name="password" id="password" placeholder="Password" tabindex="2">
                </span>
            </div>
            <div class="login-btn">
                <input type="submit" value="Login">
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