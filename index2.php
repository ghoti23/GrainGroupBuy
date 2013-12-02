<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Group Buy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site designed and developed for the purchase of bulk grain for homebrewing">
    <link rel="shortcut icon" href="css/images/favicon.png">
    <link href="css/base.css" rel="stylesheet">
    <link href="css/manage.css" rel="stylesheet">
    <link href="css/grainbuy.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php include_once("analyticstracking.php")
    ?>
</head>

<body>
<!-- Navbar
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="">
                        <a href="faq.php">Frequently Asked Questions</a>
                    </li>
                    <li class="">
                        <a href="mash-calculator.php">Calculators</a>
                    </li>
                </ul>
            </div>
    </div>
</div>
<div class="outer">
    <div id="loading"><img src="img/ajax-loader.gif">
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <div class="logo">
                <a href="index.html"></a>
            </div>
        </div>
    </div>
    <div class="row-fluid">
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span6">
            <div class="box gradient sign-in">
                <div class="content">
                    <div id="error-message-signup" class="alert alert-error hide">

                    </div>
                    <h1>Welcome!</h1>
                    <p>
                        You have arrived at the group buy website for the Chicagoland area.  This site is designed to manage the bulk ordering process
                        for homebrew supplies including grain and hops.  We are loosely affiliated with HomeBrewTalk as that is the site where we currently
                        announce our group buys, and were we validate your username.<br />
                    </p>
                    <p>
                        Since we are located in Chicago we will not allow members outside of the Chicagoland area as we will not be shipping any supplies.
                    </p>
                    <form method="POST" action="" id="signupForm" class="form-horizontal row-fluid">
                        <div class="control-group row-fluid">
                            <label for="inputEmail" class="row-fluid ">Enter your Email</label>
                            <div class="controls row-fluid input-append">
                                <input type="text" name="email" class="row-fluid" placeholder="email.." id="inputEmail">
                                <span class="add-on"><i class="icon-globe"></i></span>
                            </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label for="inputEmail" class="row-fluid ">HomeBrew Forums Username:</label>
                            <div class="controls row-fluid input-append">
                                <input type="text" name="username" autocomplete="off" class="row-fluid" placeholder="username.." id="inputEmail">
                                <span class="add-on"><i class="icon-user"></i></span>
                            </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label for="inputPassword" class="row-fluid ">And a password </label>
                            <div class="controls row-fluid input-append">
                                <input type="password" name="password" autocomplete="off" class="row-fluid" placeholder="password.." id="inputPassword">
                                <span class="add-on"><i class="icon-lock"></i></span>
                            </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label for="inputPassword" class="row-fluid ">Verify Password </label>
                            <div class="controls row-fluid input-append">
                                <input type="password" name="verifyPassword" autocomplete="off" class="row-fluid" placeholder="verify password.." id="verifyPassword">
                                <span class="add-on"><i class="icon-lock"></i></span>
                            </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label for="inputEmail" class="row-fluid ">City:</label>
                            <div class="controls row-fluid input-append">
                                <input type="text" name="city" autocomplete="off" class="row-fluid" placeholder="city.." id="inputCity">
                            </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label for="inputEmail" class="row-fluid ">State:</label>
                            <div class="controls row-fluid input-append">
                                <select name="state">
                                    <option value="">select a state</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="WI">Wisconsin</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" data-loading-text="Loading...">
                            Sign Up
                        </button>
                    </form>

                </div>
            </div>
        </div>
        <div class="span4">
            <div class="form-signin">
                <div class="box gradient sign-in">
                    <div class="title">
                        <div class="row-fluid">
                            <div class="span11">
                                <h4><i class="icon-user"></i><span>Please sign in</span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div id="error-message" class="alert alert-error">
                            <strong>Sorry!</strong> The username or password is incorrect.
                        </div>
                        <form id="adminLoginForm"  method="post">
                            <input type="text" name="username" id="username" class="input-block-level" placeholder="Email" autofocus />
                            <input type="password" name="password" id="password" class="input-block-level" placeholder="Password" />
                            <button class="btn btn-large btn-primary btn-block" type="submit" data-loading-text="Loading...">
                                Sign in
                            </button>
                        </form>
                        <a rel="tooltip" data-placement="left" data-toggle="modal" data-original-title="forgot password" href="" id="forgot">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="viewModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="POST" id="forgotPassword">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3>Reset Password</h3>
            </div>
            <div class="modal-body">
                <p>Enter your email address and we will send you an email allowing you to reset your password.</p>
                <div class="control-group row-fluid">
                    <label for="quantity" class="row-fluid ">Email</label>
                    <div class="controls row-fluid input-append">
                        <input type="text" name="email" id="email" class="input-block-level" placeholder="Email" autofocus />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <?php include_once("includes/footer.php")
    ?>
</div>
<?php include_once("includes/default-js.php")
?>
<script src="js/login.js"></script>
</body>
</html>
