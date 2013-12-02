<?php
session_start();
session_destroy();
header("location:/new/index.php");
?>