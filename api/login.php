<?php
require '../dao/userDao.php';
require '../entity/user.php';
require '../properties.php';

$user = new User();
$dao = new userDao();
$dao -> connect($host, $pdo);

$email = strip_tags($_REQUEST["username"]);
$user -> setEmail($email);
$pw = strip_tags($_REQUEST["password"]);
$clean_pw = crypt(md5($pw), md5($email));
$user -> setPassword($clean_pw);
$user = $dao -> login($user);

header('Content-type: application/json');
if ($user != null) {
	session_start();
	$_SESSION['user'] = $user;
	$_SESSION['admin'] = $user -> getAdmin();
	if ($user -> getApprove()) {
		$arr = array('success' => 'true');
		echo json_encode($arr);
	} else {
		$arr = array('message' => 'not confirmed');
		echo json_encode($arr);
	}
} else {
	$arr = array('message' => 'no user');
	echo json_encode($arr);
}
?>