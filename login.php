<?php include "config/config.inc.php"; ?>
<!DOCTYPE HTML>
<hmtl>
	<head>
		<title>yourdomain.com - Index</title>
		<link rel="stylesheet" href="css/styles.css" type="text/css" />
	</head>
<body>
	<div id="topbar">
		<center><table cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td>
					<!--<img src="img/logo_phpbb.png" alt="Logo PHPBB" />-->
					<?php
						$sqlSystem = $dbconn->prepare("SELECT * FROM `forum_settings`");
						$sqlSystem->execute();
						if($sqlSystem->rowCount()>0){
							foreach($sqlSystem as $system):
										
							endforeach;
						}
						?>
					<h1 class="titulo_forum"><?php echo $system['site_name']; ?></h1>
				</td>
				<td align="right">
					<!--<a href="#">Register</a>
					<a href="#">Login</a>-->
					<form method="GET" action="search.php">
						<input type="text" name="keywords" placeholder="Search..." size="28" />
					</form>
				</td>
			</tr>
		</table></center>
	</div><div id="login">
		<center><table cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td>
					<a href="index.php">Inicio</a>  &rsaquo;
					<a href="login.php">Login</a> 
				</td>
				<td align="right">
					<?php if(isset($_COOKIE['Memail']))	{ ?>
					<?php
						$sqlNotifs = $dbconn->prepare("SELECT * FROM `forum_notifications` WHERE `status`=0 AND `uid`=:uidname");
						$sqlNotifs->bindParam(':uidname', $resuser12['members_id'], PDO::PARAM_INT);
						$sqlNotifs->execute();
					?>
					<?php
						$sqlMsg = $dbconn->prepare("SELECT * FROM `forum_messages` WHERE `status`=0 AND `uid`=:uidname");
						$sqlMsg->bindParam(':uidname', $resuser12['members_id'], PDO::PARAM_INT);
						$sqlMsg->execute();
					?>
					<a href="user/notifications.php">Notifica&ccedil;&otilde;es [<?php echo $sqlNotifs->rowCount(); ?>]</a>
					<a href="user/inbox.php">Mensagens [<?php echo $sqlMsg->rowCount(); ?>]</a>	
					<a href="user/panel.php"><?php echo base64_decode($_COOKIE['Memail']); ?></a>
					<a href="logout.php">Sair</a>
				<?php }else{ ?>
					<a href="register.php">Register</a>
					<a href="login.php">Login</a>
				<?php } ?>
				</td>
			</tr>
		</table></center>
	</div><div id="topicoscat"><br /><br /><br />
		<?php
			//$passws = "administrator";
			//echo hash("ripemd160", $passws);
			if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
				extract($_POST);
				if($nomeuser == ''){
					echo 'Nome de usuario vazio';
				}elseif($passw == ''){
					echo 'senha vazia';
				}else{
					$crip = hash("ripemd160", $passw);
					$sqlLogin = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `username`=:user AND `pwrd`=:pass");
					$sqlLogin->bindParam(':user', $nomeuser, PDO::PARAM_STR);
					$sqlLogin->bindParam(':pass', $crip, PDO::PARAM_STR);
					$sqlLogin->execute();
					if($sqlLogin->rowCount()==1){
						setcookie("Memail", base64_encode($nomeuser), (time()+3600 * 24 *365));
						header('Location: index.php');	
					}else{
						echo 'Nome de usuario ou senha invalido';
					}
				}
			}
		?>
		<center><table cellpadding="8" cellspacing="8" border="0" width="800">
			<tr>
				<td width="366">
					<form method="POST" action="login.php">
						<input type="text" name="nomeuser" size="28" placeholder="Nome de Usu&aacute;rio" /><br /><br />
						<input type="password" name="passw" size="28" placeholder="Senha" /><br /><br />
						&nbsp;&nbsp;<input type="checkbox" name="lembrar" /> Lembrar-me&nbsp;&nbsp;<br /><br />
						<input type="submit" value=" Entrar " />&nbsp;&nbsp;
						<a class="ak" href="recuperar.php">Recuperar sua senha?</a>
					</form>
				</td><td width="21" align="center">
					<h1> ou </h1>
				</td><td width="333" align="center">
					<h3>crie uma conta gratis!</h3><br /><br />
					<a href="register.php" class="button"> Register now! </a>
				</td>
			</tr>
		</table>
		</center>
	</div>
	<center><a class="ak1" href="faq.php">FAQ</a>&nbsp;&nbsp;
	<a class="ak1" href="termos.php">Termos de Uso</a></center>
	<?php include "includes/footer.php"; ?>
</body>
</html>	