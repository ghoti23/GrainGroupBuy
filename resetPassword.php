<?php
require 'dao/dao.php';
require 'dao/userDao.php';
require 'properties.php';
require 'entity/user.php';

$id = strip_tags($_REQUEST["id"]);
$email = strip_tags($_REQUEST["email"]);
$password = strip_tags($_REQUEST["password"]);
$verifyPassword = strip_tags($_REQUEST["verifypassword"]);


if ($password != "" && $verifyPassword != "") {
    $resetUser = new User();
    $resetUser->setEmail($email);
    $resetUser->setPassword($id);


    $dao = new userDao();
    $dao->connect($host,$pdo);
    $user = $dao->login($resetUser);

    if ($user == null) {
        header("location:index.php");
    }

    $clean_pw = crypt(md5($password),md5($email));
    $user->setPassword($clean_pw);
    $user->setEmail($email);
    $check = $dao->updatePassword($user);

    if (!$check) {
        header("location:index.php");
    }
    $user = $dao->login($user);
    if ($user != null) {
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['admin'] = $user->getAdmin();
        header("location:dashboard.php");
    } else {
        header("location:index.php");
    }
} else if ($id == "" || $email == "") {
    header("location:index.php");
} else {
    $dao = new userDao();
    $dao->connect($host,$pdo);
    $user=$dao->loadUserForgotPassword($id,$email);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/admin/img/webwatch.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/admin/img/webwatch.ico" type="image/x-icon">

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/base.css" rel="stylesheet" type="text/css"/>
    <link href="css/chosen.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/manage.css" rel="stylesheet" type="text/css"/>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]--></head>
<body>
<div class="outer">
    <div id="loading"><img src="img/ajax-loader.gif"></div>
    <div class="form-signin">
        <div class="box gradient sign-in">
            <div class="content">
                <form id="adminLoginForm"  method="post">
                    <input type="hidden" name="email" value="<?php echo $email?>" />
                    <input type="hidden" name="id" value="<?php echo $id?>" />

                    <input type="password" name="password" id="password" class="input-block-level" placeholder="Password" />
                    <input type="password" name="verifypassword" id="password" class="input-block-level" placeholder="Password" />
                    <button class="btn btn-large btn-primary btn-block" type="submit" data-loading-text="Loading...">Reset It</button>
                </form>
            </div>
        </div>
    </div>
    <div id="footer">
        &nbsp;
    </div></div>
<?php include_once("includes/default-js.php")?>
</body>
</html>