<?php
require 'dao/dao.php';
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/ProductSplit.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $clean_pw="";
    $user = new User();
    $email = strip_tags($_REQUEST["email"]);
    $username = strip_tags($_REQUEST["username"]);
    $firstName = strip_tags($_REQUEST["firstName"]);
    $lastName = strip_tags($_REQUEST["lastName"]);
    $zipCode = strip_tags($_REQUEST["zipCode"]);
    $pw = strip_tags($_REQUEST["password"]);

    $user->setEmail($email);
    $clean_pw = crypt(md5($pw), md5($email));
    $user->setPassword($clean_pw);
    $user->setUsername($username);
    $user->setFirstName($firstName);
    $user->setLastName($lastName);
    $user->setZipCode($zipCode);
    if (empty($email) || empty($pw) || empty($username) || empty($firstName) || empty($lastName) || empty($zipCode)) {
        $message = 'All of the fields are required.';
    }
    else {
        $dao = new dao();
        $dao->connect($host,$pdo);
        $userAdded = $dao->addUser($user);
        if ($userAdded == true) {
            header("location:signup-complete.php");
        } else {
            $message = 'Sorry, but the email or username is already in use.  Did you already signup?';
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
    <h3 class="centered">Create your Group Buy account.</h3>
    <?php if (!empty($message)) {  ?>
        <div class="alert alert-danger">
            <?php echo $message ?>
        </div>
    <?php } ?>
    <div class="box">
        <form action="signup.php" method="post">
            <div class="text">
                <span>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" tabindex="1" autofocus <?php if (isset($email)) {  ?>value="<?php print $email ?>"<?php } ?>>
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" tabindex="2" >
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" tabindex="3" <?php if (isset($username)) {  ?>value="<?php print $username ?>"<?php } ?>>
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" placeholder="First Name" tabindex="4" <?php if (isset($firstName)) {  ?>value="<?php print $firstName ?>"<?php } ?>>
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName" placeholder="Last Name" tabindex="5" <?php if (isset($lastName)) {  ?>value="<?php print $lastName ?>"<?php } ?>>
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="zipCode">Zip Code</label>
                    <input type="text" name="zipCode" id="zipCode" placeholder="Zip Code" tabindex="6" <?php if (isset($zipCode)) {  ?>value="<?php print $zipCode ?>"<?php } ?>>
                </span>
            </div>
            <div class="login-btn">
                <input type="submit" value="Sign Up">
            </div>
        </form>
    </div>
    <div class="footer-msg">
        <p>Already have an account? <a href="login.php">Sign in.</a></p>
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