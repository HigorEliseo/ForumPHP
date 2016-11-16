<?php
	setcookie("Memail", $_COOKIE['Memail'], (time()-3600 * 24 *365));
	unset($_COOKIE['"Memail"']);
	header('Location: index.php');
?>