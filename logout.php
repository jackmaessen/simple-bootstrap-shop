<?php 
	session_start();
	unset($_SESSION['shop_login']);
	header("Location: admin.php?logout=true");
?>
