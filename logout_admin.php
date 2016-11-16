<?php
	setcookie("Admmail", $_COOKIE['Admmail'], (time()-3600 * 24 *365),'/');
	unset($_COOKIE['"Admmail"']);
	header('Location: admin/login.php');
?>