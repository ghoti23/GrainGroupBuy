<?php
session_start();
if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art of Beer Brewery - Group Buy - Calculators</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="faq container">
    <div class="row">
        <div class="col-md-10">
            <h3>Strike Temperature Calculator</h3>
            <h4>Determine what your strike temperature will need to be to meet the desired mash-in temperature.</h4>
            <div class="well">
                <form id="strikeForm" method="POST">
                    <div class="control-group row-fluid">
                        <label class="row-fluid " for="contentKey">Mash Thickness: (qt/lb)</label>
                        <input type="text" name="mT" value="1.25">
                    </div>
                    <div class="control-group row-fluid">
                        <label class="row-fluid " for="contentKey">Desired Strike Temperature (F)</label>
                        <input type="text" name="sT" value="150">
                    </div>
                    <div class="control-group row-fluid">
                        <label class="row-fluid " for="contentKey">Temperature of Grain: (F)</label>
                        <input type="text" name="gT" value="60">
                    </div>
                    <input type="submit" class="btn btn-info" value="Submit" />
                </form>
            </div>

            <h3>Will it fit?</h3>
            <h4>A simple tool that will tell you if your grain bill will fit in your mash tun.  You will need to compensate for the volume under your mash tun.</h4>
            <div class="well">
                <form id="fitForm">
                    <div class="control-group row-fluid">
                        <label class="row-fluid " for="contentKey">Grain Weight: (lb)</label>
                        <input type="text" name="weight" value="">
                    </div>
                    <div class="control-group row-fluid">
                        <label class="row-fluid " for="contentKey">Mash Thickness: (qt/lb)</label>
                        <input type="text" name="mash" value="1.25">
                    </div>
                    <input type="submit" class="btn btn-info" value="Submit" />
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <?php include_once("includes/right-nav.php")?>
        </div>
    </div>
</div>
<?php include_once("includes/footer.php")?>
</body>
</html>