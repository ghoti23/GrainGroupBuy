<?php
require '../dao/dao.php';
require '../dao/groupBuyDao.php';
require '../dao/userDao.php';
require '../dao/orderDao.php';
require '../dao/productDao.php';
require '../dao/ResetTokenDao.php';
require '../entity/user.php';
require '../entity/groupbuy.php';
require '../entity/order.php';
require '../entity/product.php';
require '../entity/ProductSplit.php';
require '../entity/ResetToken.php';
require '../properties.php';
require '../Mandrill.php';
require '../utils.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = strip_tags($_REQUEST["email"]);

    if (empty($email)) {
        $message = 'Email is required.';
    }
    else {
        $dao = new dao();
        $dao->connect($host,$pdo);
        $user = $dao->loadUser($email);

        if (!isset($user)) {
            $message = 'The email address was not found.';
        }
        else {

            $resetTokenDao = new ResetTokenDao();
            $resetTokenDao->connect($host,$pdo);
            $id = $resetTokenDao->insert($email);

            $link = "http://artofbeerbrewery.com/groupbuy/reset-password.php?id=" . $id;

            $mandrill = new Mandrill('AFkXcZ94ZLRKkvpEoBEDMA');

            $params = array(
                'subject' => 'Reset Password',
                'from_email' => 'admin@artofbeerbrewery.com',
                'to' => array(array('email' => $user->getEmail())),
                'merge_vars' => array(array(
                    'rcpt' => $user->getEmail(),
                    'vars' =>
                    array(
                        array(
                            'name' => 'link',
                            'content' => $link))
                )));

            $template_name = 'reset-password';

            $template_content = array();

            $response = $mandrill->messages->sendTemplate($template_name, $template_content, $params);
            header("location:/new/reset-complete.php");
        }
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
    <h3 class="centered">Reset your password</h3>
    <div class="box">
        <?php if (!empty($message)) {  ?>
            <div class="alert alert-danger">
                <?php echo $message ?>
            </div>
        <?php } ?>
        <form action="/new/reset.php" method="post">
            <div class="text">
                <span>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Email" maxlength="100" tabindex="1" autofocus <?php if (isset($email)) {  ?>value="<?php print $email ?>"<?php } ?>>
                </span>
            </div>
            <div class="login-btn">
                <input type="submit" value="Send reset password email">
            </div>
        </form>
    </div>
    <div class="footer-msg">
        <p>Know your password? <a href="/new/login.php">Sign in.</a></p>
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