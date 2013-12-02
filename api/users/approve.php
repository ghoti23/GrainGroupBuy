<?php
require '../../dao/dao.php';
require '../../dao/userDao.php';
require '../../entity/user.php';
require '../../properties.php';
session_start();
$user = $_SESSION['user'];
if (!$_SESSION['admin'])  {
    echo "";
}

$userDao = new userDao();
$userDao->connect($host,$pdo);

$users = $userDao->approveList();
header('Content-type: application/json');
echo json_encode((array)$users, JSON_PRETTY_PRINT);
?>