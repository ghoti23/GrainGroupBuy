<?php session_start();
if(!isset($_SESSION['user'])) {
    header( 'Location: index.php' ) ;
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Group Buy - FAQs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="css/images/favicon.png">

    <link href="css/base.css" rel="stylesheet">
    <link href="css/manage.css" rel="stylesheet">
    <link href="css/grainbuy.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php include_once("analyticstracking.php") ?>
</head>
<body>
<div id="loading">
    <img src="img/ajax-loader.gif">
</div>
<div id="responsive_part">
    <div class="logo">
        <a href="index.html"></a>
    </div>
    <ul class="nav responsive">
        <li>
            <btn class="btn btn-la1rge btn-i1nfo responsive_menu icon_item" data-toggle="collapse" data-target="#sidebar">
                <i class="icon-reorder"></i>
            </btn>
        </li>
    </ul>
</div>
<!-- Responsive part -->
<div id="sidebar" class="collapse">
    <div class="logo">
        <a href="index.php"></a>
    </div>
    <ul id="sidebar_menu" class="navbar nav nav-list sidebar_box">
        <li class="accordion-group active">
            <a class="dashboard" href="dashboard.php"><img src="img/menu_icons/dashboard.png">Dashboard</a>
        </li>
        <li >
            <a class="faq" href="faq.php"><img src="img/menu_icons/question.png"> FAQs</a>
        </li>
        <li>
            <a class="calculator" href="mash-calculator.php"><i class="ui-icon-calculator"></i> Calculators</a>
        </li>
    </ul>
    <!-- End sidebar_box -->
    <!-- End sidebar_box -->
    <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Left Nav - Small Rectangle -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:180px;height:150px"
         data-ad-client="ca-pub-5071928133115505"
         data-ad-slot="3662734270"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<div id="main">
    <div class="container">
        <div class="container_top">
            <div class="row-fluid ">

                <div class="top_right">

                </div> <!-- End top-right -->

                <div class="span4">

                </div>
            </div>
        </div>
        <!-- End container_top -->
        <div id="container2">
            <div class="row-fluid">
                <div class="box gradient">
                    <div class="title">
                        <div class="row-fluid">
                            <div class="span6">
                                <h4><i class=" icon-question-sign"></i><span>Frequently Asked Questions</span></h4>
                            </div>
                            <!-- End .span6 -->

                            <!-- End .span6 -->
                        </div>
                        <!-- End .row-fluid -->
                    </div>
                    <!-- End .title -->
                    <div class="content"><p>
                        <strong>What is a group buy?</strong><br/>
                        A group buy is where a bunch of people purchase grains and other items collectively to get competitive pricing because of the large combined order.  It gives the collective buyers purchasing power and provide for great cost savings on items.<br/><br/>

                        <strong>Who runs these group buys?</strong><br/>
                        These buys are organized by Chicago Home Brewers Group.  They are a group of Chicago area homebrewers whose group buys are coordinated by bmason1623 with help from cheesecake, ghoti, Neopol, starman & wagz.<br/><br/>

                        <strong>Who can participate?</strong><br />
                        Practically anyone can participate.  All we ask is that you reside in the Chicago area or neighboring states like WI, IN, IA and MI.  We do not ship grain.  Period.<br /><br/>

                        <strong>How does it work?</strong><br />
                        Our group buys use an ordering software developed and written by ghoti.  You need to register an account with your name, HBT username and email address to gain access.  If you were involved in previous group buys and have already registered then just login as usual. chicagohomebrewers.org/grain<br /><br/>

                        <strong>What items are available in the group buy?</strong><br />
                        There are many different kinds of brewers malts from a variety of maltsters.  We also offer hops, adjuncts, spices, chemicals, etc.  There will inevitably out of stock conditions which we have no control over.<br /><br/>

                       <strong>How do I add items to my order?</strong><br/>
                       First you will need to go into the active group buy.  From there you will see a screen that looks similar to the following.  Click the Add Item button in the top right<br/>
                       <img src="img/add_item.png"><br />
                       Then you will get a screen that has a search box on it.  You can type in anything you want to search on (2-row) or just hit search to see all the products<br/>
                       <img src="img/search.png"><br />
                       You can then type in a quantity of items you want in a box and press the + button.  This will be added to your cart, you can either conduct another search or choose group buy from the left menu to head back.<br />
                       <img src="img/results.png"><br />

                        <strong>How do I pay?</strong><br />
                        Once the buy closes, people will submit their paypal payment (no other choices available at the moment) based on their order total which is shown in the ordering software.  More information will be given once the buy is underway.<br/><br/>

                        <strong>What if I decide I don’t want to be involved after the buy closes and payment collection is underway?</strong><br />
                        We strongly discourage this kind of behaviour because it really disrupts the group buy process but ultimately there isn’t much we can do.  However, do not expect to be allowed to participate in our future group buys.  Again, this is really disruptive for the group buy and just makes others wait longer for their order.<br /><br/>

                        <strong>What is the lead time for delivery and pick up location?</strong><br />
                        Typically, you can expect to receive your order within 2 weeks after the deadline for payment has ended (which is one week after the buy closes).  Pick up is made by appointment at:<br />
                        Chicago Brewing Supplies Inc.<br />
                        4866 W. Cortland St.<br />
                        Chicago, IL 60639<br />
                        773-442-2455<br /><br/>

                        <strong>I have never participated in a group buy before and do not know anyone who has.  What if I have reservations about participating?</strong><br />
                        We do not want to make anyone uncomfortable.  Perhaps these buys just aren’t for you.  But if it’s any consolation, bmason1623 has been running buys in the Chicago area for almost three years.  You can ask others about their experiences.  And as always, you can ask bmason1623 himself or the others listed in the second FAQ question.  Just send a PM or email through the various forums like:<br />

                        <a href="chicagohomebrewers.org/phpbb">chicagohomebrewers.org/phpbb</a><br/>
                        <a href="homebrewtalk.com">homebrewtalk.com</a><br/>
                        <a href="https://www.facebook.com/groups/ChicagoHomeBrewersGroup/">https://www.facebook.com/groups/ChicagoHomeBrewersGroup/</a><br/>
                        </p>
                    </div>
                </div>
                <!-- End .box -->
            </div>
            <!-- End .row-fluid -->
        </div>
        <!-- End #container -->
    </div>
    <?php include_once("includes/footer.php")
    ?>
</div>
</div>
<!-- /container -->
<?php include_once("includes/default-js.php")
?>
</body>
</html>