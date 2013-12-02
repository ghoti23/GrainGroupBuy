<?php

if (isset($_SESSION['activeGroupBuy'])){
    $activeGroupBuy = $_SESSION['activeGroupBuy'];
    $groupBuyDao = new groupBuyDao();
    $orderDao = new orderDao();
    $userDao = new userDao();
    $groupBuyDao -> connect($host, $pdo);
    $orderDao -> connect($host, $pdo);
    $userDao -> connect($host, $pdo);

    $groupBuy = $groupBuyDao -> get($activeGroupBuy);
    $currentOrder = $orderDao -> getOrder($activeGroupBuy, $user);

    $utils = new Utils;
}

?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Art of Beer Brewery - Group Buy <?php if (!empty($subhead)) {print " - " . $subhead; } ?></title>
<link rel="stylesheet" href="/css/main.css" />

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php include_once("../analyticstracking.php") ?>