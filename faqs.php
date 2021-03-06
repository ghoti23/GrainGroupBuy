<?php
require 'dao/groupBuyDao.php';
require 'dao/userDao.php';
require 'dao/orderDao.php';
require 'dao/productDao.php';
require 'entity/user.php';
require 'entity/groupbuy.php';
require 'entity/order.php';
require 'entity/product.php';
require 'entity/split.php';
require 'properties.php';
require 'utils.php';

session_start();

if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("includes/default-head.php") ?>
</head>
<body>
<?php include_once("includes/header.php")?>
<div class="faq container">
    <div class="body-spacer">
        <div class="row">
            <div class="col-md-9">
                <h3>What is a group buy?</h3>
                <p>A group buy is where a bunch of people purchase grains and other items collectively to get competitive pricing because of the large combined order.  It gives the collective buyers purchasing power and provide for great cost savings on items.</p>

                <h3>Who runs these group buys?</h3>
                <p>These buys are organized by Chicago Home Brewers Group.  They are a group of Chicago area homebrewers whose group buys are coordinated by bmason1623 with help from cheesecake, ghoti, Neopol, starman & wagz.</p>

                <h3>Who can participate?</h3>
                <p>Practically anyone can participate.  All we ask is that you reside in the Chicago area or neighboring states like WI, IN, IA and MI.  We do not ship grain.  Period.</p>

                <h3>How does it work?</h3>
                <p>Our group buys use an ordering software developed and written by ghoti.  You need to register an account with your name, HBT username and email address to gain access.  If you were involved in previous group buys and have already registered then just login as usual. chicagohomebrewers.org/grain.</p>

                <h3>What items are available in the group buy?</h3>
                <p>There are many different kinds of brewers malts from a variety of maltsters.  We also offer hops, adjuncts, spices, chemicals, etc.  There will inevitably out of stock conditions which we have no control over.</p>

                <h3>How do I pay?</h3>
                <p>Once the buy closes, people will submit their paypal payment (no other choices available at the moment) based on their order total which is shown in the ordering software.  More information will be given once the buy is underway.</p>

                <h3>What if I decide I don’t want to be involved after the buy closes and payment collection is underway?</h3>
                <p>We strongly discourage this kind of behaviour because it really disrupts the group buy process but ultimately there isn’t much we can do.  However, do not expect to be allowed to participate in our future group buys.  Again, this is really disruptive for the group buy and just makes others wait longer for their order.</p>

                <h3>What is the lead time for delivery and pick up location?</h3>
                <p>Typically, you can expect to receive your order within 2 weeks after the deadline for payment has ended (which is one week after the buy closes).  Pick up is made by appointment at:</p>
                <address>
                    <strong>Chicago Brewing Supplies Inc.</strong><br>
                    4866 W. Cortland St.<br>
                    Chicago, IL 60639<br>
                    <abbr title="Phone">P:</abbr> (773) 442-2455<br /><br/>
                </address>

                <h3>I have never participated in a group buy before and do not know anyone who has.  What if I have reservations about participating?</h3>
                <p>We do not want to make anyone uncomfortable.  Perhaps these buys just aren’t for you.  But if it’s any consolation, bmason1623 has been running buys in the Chicago area for almost three years.  You can ask others about their experiences.  And as always, you can ask bmason1623 himself or the others listed in the second FAQ question.  Just send a PM or email through the various forums like:</p>
                <ul>
                    <li><a href="chicagohomebrewers.org/phpbb">chicagohomebrewers.org/phpbb</a></li>
                    <li><a href="homebrewtalk.com">homebrewtalk.com</a></li>
                    <li><a href="https://www.facebook.com/groups/ChicagoHomeBrewersGroup/">https://www.facebook.com/groups/ChicagoHomeBrewersGroup/</a></li>
                </ul>
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