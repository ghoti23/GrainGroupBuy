<?php

$groupBuyDao = new groupBuyDao();
$orderDao = new orderDao();
$userDao = new userDao();
$groupBuyDao -> connect($host, $pdo);
$orderDao -> connect($host, $pdo);
$userDao -> connect($host, $pdo);
$utils = new Utils;

if (isset($_SESSION['activeGroupBuy'])){
    $activeGroupBuy = $_SESSION['activeGroupBuy'];
    $groupBuy = $groupBuyDao -> get($activeGroupBuy);
    $currentOrder = $orderDao -> getOrder($activeGroupBuy, $user);
} elseif (isset($_SESSION['nextGroupBuy'])) {
    $nextGroupBuy = $_SESSION['nextGroupBuy'];
    $groupBuy = $groupBuyDao -> get($nextGroupBuy);
}

?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Art of Beer Brewery - Group Buy <?php if (!empty($subhead)) {print " - " . $subhead; } ?></title>
<link rel="stylesheet" href="css/main.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php include_once("analyticstracking.php") ?>