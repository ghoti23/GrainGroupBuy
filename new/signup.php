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
    $username = strip_tags($_REQUEST["username"]);
    $clean_pw = crypt(md5($pw),md5($email));
    $user->setUsername($username);
    $user->setPassword($clean_pw);
    $user->setCity(strip_tags($_REQUEST["city"]));
    //$user->setState(strip_tags($_REQUEST["state"]));
    $dao = new dao();
    $dao->connect($host,$pdo);
    $dao->addUser($user);
    header("location:/new/dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art of Beer Brewery - Group Buy - Sign up</title>
    <link rel="stylesheet" href="/css/main.css" />
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
                    <label for="username">Home Brew Forums Username</label>
                    <input type="text" value="" name="username" id="username" placeholder="Homebrew forums username">
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
                    <label for="city">City</label>
                    <input type="text" value="" name="city" id="city" placeholder="City">
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