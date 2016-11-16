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
					<?php if(isset($_COOKIE['Admmail']))	{ ?>
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
					
				<?php }else{ ?>
					
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
				$codigo = $_GET['codigo'];
				$email_codigo = base64_decode($codigo);
				if($newpass == ''){
					echo 'Campo nova senha esta vazio!';	
				}elseif($confirmpass == ''){
					echo 'Campo confirmar senha esta vazio!';
				}else{
					$nova = hash("ripemd160", $newpass);
					$select = $dbconn->prepare("SELECT * FROM `forum_codes` WHERE `codigo`='$codigo' AND `data` > NOW()");
					$select->execute();
					if($select->rowCount()==1){
						$atualiza = $dbconn->prepare("UPDATE `members_tbl` SET `pwrd`='$nova' WHERE `email`= '$email_codigo'");	
						if($atualiza->execute()){
							header('Location: index.php');
						}
					}else{
						echo 'A data desta pagina expirou!';
					}	
				}
			}
		?>
		<center><table cellpadding="8" cellspacing="8" border="0" width="800">
			<tr>
				<td width="366">
					Digite a nova senha.<br /><br />
					<form method="POST" action="">
						<input type="text" name="newpass" size="28" placeholder="New Pass" /><br /><br />
						<input type="text" name="confirmpass" size="28" placeholder="Confirm Pass" /><br /><br />
						<input type="submit" value=" Enviar " />
					</form>
				</td><td align="right">
					
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