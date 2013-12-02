<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Group Buy - Mash Calculator</title>
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
            <a class="dashboard" href="index.html"><img src="img/menu_icons/dashboard.png">Dashboard</a>
        </li>
    </ul>
    <!-- End sidebar_box -->
</div>
<div id="main">
    <div class="container">
        <div class="container_top">
            <div class="row-fluid ">

                <div class="top_right">

                    <ul class="nav nav_menu">

                    </ul>
                </div> <!-- End top-right -->

                <div class="span4">

                </div>
            </div>
        </div>
        <!-- End container_top -->
        <div id="container2">
            <div class="row-fluid">
                <div class="span6">
                    <div class="box gradient">
                        <div class="title">
                            <div class="row-fluid">
                                <div class="span8">
                                    <h4><i class=" icon-bar-chart"></i><span>How bitter is my beer?</span></h4>
                                </div>
                            </div>
                            <!-- End .row-fluid -->
                        </div>
                        <!-- End .title -->
                        <div class="content">
                            Determine your bitterness
                            <div class="row-fluid">
                                <div class="span8">
                                    <form id="strikeForm" method="POST">
                                        <table>
                                            <thead>
                                                <th>Alpha Acid</th>
                                                <th>Ounces</th>
                                                <th>Time in boil</th>
                                            </thead>
                                        </table>
                                        <input type="submit" class="btn btn-info" value="Submit" />
                                    </form>
                                </div>
                                <div class="span4">
                                    <br />
                                    <div id="strikeTemp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="box gradient">
                        <div class="title">
                            <div class="row-fluid">
                                <div class="span8">
                                    <h4><i class=" icon-bar-chart"></i><span>Will it fit?</span></h4>
                                </div>
                            </div>
                            <!-- End .row-fluid -->
                        </div>
                        <!-- End .title -->
                        <div class="content">
                            A simple tool that will tell you if your grain bill will fit in your mash tun.  You will need to compensate for the volume under your mash tun.
                            <div class="row-fluid">
                                <div class="span8">
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
                                <div class="span4">
                                    <br />
                                    <div id="mashValue"></div>
                                </div>
                            </div>
                        </div>
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
<?php include_once("includes/default-js.php")?>
<script src="js/mash-calculator.js"></script>
<script src="js/calculator.js"></script>
</body>
</html>