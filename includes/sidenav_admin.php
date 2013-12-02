<div class="logo">
    <a href="index.php"></a>
</div>
<ul id="sidebar_menu" class="navbar nav nav-list sidebar_box">
    <li class="accordion-group">
        <a class="dashboard" href="dashboard.php"><img src="img/menu_icons/dashboard.png">Dashboard</a>
    </li>
    <?php
    if (!empty($_SESSION["groupBuyId"])) {?>
        <li >
            <a class="groupBuy" href="viewGroupBuy.php?id=<?php echo $_SESSION["groupBuyId"]  ?>"> <img src="img/menu_icons/calendar.png">Group Buy</a>
        </li>
    <?php }?>
    <li >
        <a class="widgets" href="faq.php"><img src="img/menu_icons/question.png"> FAQs</a>
    </li>
    <li>
        <a class="calculator" href="mash-calculator.php"><i class="ui-icon-calculator"></i> Mash Calculators</a>
    </li>

    <li class="accordion-group">
        <a class="accordion-toggle widgets collapsed" href="#collapse2" data-parent="#sidebar_menu" data-toggle="collapse"><img src="img/menu_icons/settings.png">  Administration</a>
        <ul id="collapse2" class="accordion-body collapse">
            <li><a href="admin.php">Admin Dashboard</a></li>
            <li><a href="startGroupBuy.php"><img src="img/menu_icons/calendar.png"> Start Group Buy</a></li>
            <li><a href="admin_product.php"><i class=" icon-beaker"></i> Edit Products</a></li>
            <li><a href="admin_product.php"><i class=" icon-resize-full"></i> View Active Splits</a></li>
        </ul>

    </li>
</ul>
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