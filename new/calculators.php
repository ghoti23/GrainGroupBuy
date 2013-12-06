<?php
require '../dao/groupBuyDao.php';
require '../dao/userDao.php';
require '../dao/orderDao.php';
require '../dao/productDao.php';
require '../entity/user.php';
require '../entity/groupbuy.php';
require '../entity/order.php';
require '../entity/product.php';
require '../entity/split.php';
require '../properties.php';
require '../utils.php';

session_start();

if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php")?>
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="faq container">
    <div class="body-spacer">
        <div class="row">
            <div class="col-md-9">
                <h3>Strike Temperature Calculator</h3>
                <h4>Determine what your strike temperature will need to be to meet the desired mash-in temperature.</h4>
                <div class="well well-lg">
                    <form id="strikeForm" method="POST" class="clearfix">
                        <div class="row-fluid">
                            <div class="col-md-4"><label for="contentKey">Mash Thickness: (qt/lb)</label></div>
                            <div class="col-md-8"><input type="text" name="mT" value="1.25"></div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-md-4"><label for="contentKey">Desired Strike Temperature (F)</label></div>
                            <div class="col-md-8"><input type="text" name="sT" value="150"></div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-md-4"><label for="contentKey">Temperature of Grain: (F)</label></div>
                            <div class="col-md-8"><input type="text" name="gT" value="60"></div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-8"><input type="submit" class="btn btn-lg" value="Submit" /></div>
                        </div>
                    </form>
                </div>

                <h3>Will it fit?</h3>
                <h4>A simple tool that will tell you if your grain bill will fit in your mash tun.  You will need to compensate for the volume under your mash tun.</h4>
                <div class="well well-lg">
                    <form id="fitForm" class="clearfix">
                        <div class="row-fluid">
                            <div class="col-md-4"><label for="contentKey">Grain Weight: (lb)</label></div>
                            <div class="col-md-8"><input type="text" name="weight" value=""></div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-md-4"><label for="contentKey">Mash Thickness: (qt/lb)</label></div>
                            <div class="col-md-8"><input type="text" name="mash" value="1.25"></div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-8"><input type="submit" class="btn btn-lg" value="Submit" /></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <?php include_once("includes/right-nav.php")?>
            </div>
        </div>
    </div>
</div>
<?php include_once("includes/footer.php")?>
</body>
</html>