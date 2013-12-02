<?php require '../entity/user.php'; ?>
<?php require '../dao/dao.php'; ?>
<?php require '../properties.php'; ?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $clean_pw="";
    $user = new User();
    $email = strip_tags($_REQUEST["email"]);
    $user->setEmail($email);

    $pw = strip_tags($_REQUEST["password"]);
    $clean_pw = crypt(md5($pw), md5($email));
    $user->setPassword($clean_pw);
    $user->setFirstName(strip_tags($_REQUEST["firstName"]));
    $user->setLastName(strip_tags($_REQUEST["lastName"]));
    $user->setZipCode(strip_tags($_REQUEST["zipCode"]));
    $dao = new dao();
    $dao->connect($host,$pdo);
    $dao->addUser($user);
    header("location:/new/dashboard.php");
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
    <h3 class="centered">Create your Group Buy account.</h3>
    <div class="box">
        <form action="/new/signup.php" method="post">
            <div class="text">
                <span>
                    <label for="email">Email</label>
                    <input type="email" value="" name="email" id="email" placeholder="Email">
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="password">Password</label>
                    <input type="password" value="" name="password" id="password" placeholder="Password">
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="firstName">First Name</label>
                    <input type="text" value="" name="firstName" id="firstName" placeholder="First Name">
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="lastName">Last Name</label>
                    <input type="text" value="" name="lastName" id="lastName" placeholder="Last Name">
                </span>
            </div>
            <div class="text">
                <span>
                    <label for="zipCode">Zip Code</label>
                    <input type="text" value="" name="zipCode" id="zipCode" placeholder="Zip Code">
                </span>
            </div>
            <div class="login-btn">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    <div class="footer-msg">
        <p>Already have an account? <a href="/new/login.php">Sign in.</a></p>
    </div>
</div>
</body>
</html>