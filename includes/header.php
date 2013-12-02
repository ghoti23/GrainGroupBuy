 <div class="top_right">
   
  <ul class="nav nav_menu">
  
    <li class="dropdown">
    <a class="dropdown-toggle administrator" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
    <span class="icon"><img src="img/menu_top/profile-avatar.png"></span><span class="title"><?php echo $user->getUsername(); ?></span></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
      <li><a href="profile.php"><i class=" icon-user"></i> My Profile</a></li>
<?php if ($user->getAdmin() == 1)  {?>
      <li><a href="admin.php"><i class=" icon-user"></i> Admin</a></li>
<?php } ?>
      <li><a href="logout.php"><i class=" icon-unlock"></i>Log Out</a></li>
      <li><a href="help.php"><i class=" icon-flag"></i>Help</a></li>
    </ul>
    </li>
	</ul>
</div> <!-- End top-right -->