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
		<a class="faq" href="faq.php"><img src="img/menu_icons/question.png"> FAQs</a>
	</li>
    <li>
        <a class="calculator" href="mash-calculator.php"><i class="ui-icon-calculator"></i> Mash Calculators</a>
    </li>
</ul>
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Left Nav - Small Rectangle -->
<ins class="adsbygoogle"
     style="display:inline-block;width:180px;height:150px"
     data-ad-client="ca-pub-5071928133115505"
     data-ad-slot="3662734270"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>