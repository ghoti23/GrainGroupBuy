<?php
session_start();

if (isset($_SESSION['user'])){
    header("location:/new/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art of Beer Brewery - Group Buy</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="container">
    <section class="home-hero">
        <h1>Offering bulk pricing for grains and hops to the Chicagoland area.</h1>
        <div class="splash-signup">
            <h4>
                The next group buy is..
            </h4>
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