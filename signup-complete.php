<?php
require 'dao/dao.php';
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/ProductSplit.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php") ?>
</head>
<body class="login">
<div class="content">
    <div class="logo">
        <a href="/index.php"><img src="/img/groupbuy_white_tiny.png" /></a>
    </div>
    <h3 class="centered">Your Group Buy account has been created.</h3>
    <div class="footer-msg">
        <p>Already have an account? <a href="/login.php">Sign in.</a></p>
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