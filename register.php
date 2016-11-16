<?php include "config/config.inc.php"; ?>
<!DOCTYPE HTML>
<hmtl>
	<head>
		<title>yourdomain.com - Register</title>
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
				
				//$crip = hash("ripemd160", $passw);
				
				if($nomeuser == ''){
					echo 'Nome de usuario vazio';
				}elseif($passw == ''){
					echo 'senha vazia';
				}elseif($passw <> $passw2){
					echo 'as senhas nao coicidem';
				}elseif($email == ''){
					echo 'email vazio';
				}elseif(!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i",$email)){
					echo 'email invalido';
				}else{
					$crip = hash("ripemd160", $passw);
					$Registrar = $dbconn->prepare("INSERT INTO `members_tbl` SET `username`=:username, `pwrd`=:pass, `email`=:email, `genero`='Masculino'");
					$Registrar->bindParam(':username', $nomeuser, PDO::PARAM_STR);
					$Registrar->bindParam(':username', $crip, PDO::PARAM_STR);
					$Registrar->bindParam(':username', $email, PDO::PARAM_STR);
					if($Registrar->execute()){
						echo 'Cadastrado com sucesso';
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
						<input type="password" name="passw2" size="28" placeholder="Repita a Senha" /><br /><br />
						<input type="text" name="email" size="28" placeholder="E-mail" /><br /><br />
						&nbsp;&nbsp;<input type="checkbox" name="lembrar" /> Li e Aceito os Termos de uso.&nbsp;&nbsp;<br /><br />
						<input type="submit" value=" Regsitrar-se " />&nbsp;&nbsp;
					</form>
				</td><td width="21" align="center">
					
				</td><td width="333" align="center">
					
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