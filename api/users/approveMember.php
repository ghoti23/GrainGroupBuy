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

$approveMembers = $_REQUEST["email"];
$count = count($approveMembers);
for ($i=0;$i<$count;$i++) {
    $userDao->approveMember($approveMembers[$i]);
}
?>