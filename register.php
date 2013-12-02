<?php require 'entity/user.php'; ?>
<?php require 'dao/dao.php'; ?>
<?php require 'properties.php'; ?>
<?php
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
    $user->setState(strip_tags($_REQUEST["state"]));
	$dao = new dao();
	$dao->connect($host,$pdo);
	$dao->addUser($user);
    header('Content-type: application/json');
    $arr = array('message' => 'success');
    echo json_encode($arr);
?>
