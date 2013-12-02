<?php
session_start();

if (isset($_SESSION['user'])){
    header("location:/new/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php")?>
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="container">
    <section class="home-hero">
        <h1>Offering bulk pricing for grains and hops to the Chicagoland area.</h1>
        <div class="well">
            <h3>
                The next group buy is..
            </h3>
            <div class="form-submit">
                <a href="/new/signup.php" class="button">Get Started</a>
                <a href="/new/dashboard.php" class="button grey">View Dashboard</a>
            </div>
        </div>
    </section>
</div>
<?php include_once("includes/footer.php")?>
</body>
</html>