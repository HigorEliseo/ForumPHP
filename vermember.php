<?php include "config/config.inc.php"; ?>
<!DOCTYPE HTML>
<hmtl>
	<head>
		<title>yourdomain.com - Perfil</title>
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
					<a href="index.php">Voltar</a>  &rsaquo;
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
	</div><div id="topicoscat"><br /><br />
	<br /><br />
		<?php
		$username = (int)$_GET['mid'];
		$sqlPegaid = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `members_id`=:username");
		$sqlPegaid->bindParam(':username', $username, PDO::PARAM_STR);
		$sqlPegaid->execute();
		if($sqlPegaid->rowCount()>0){
			foreach($sqlPegaid as $getid):
				$uid = $getid['members_id'];
			endforeach;
		}
		?>
		<center><table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
				<?php echo $getid['username']; ?> - MEU PERFIL
				</td>
			</tr>
		</table>
		<table class="box22" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td width="3%" align="center">
					<table cellpadding="8" cellspacing="8" border="0" width="100%">
						<tr>
							<td width="20%" valign="top">
								<table cellpadding="8" cellspacing="8" border="0" width="100%">
									<tr>
										<td align="center"><br />
									<?php	
										if($getid['genero'] == 'Masculino'){
											if(empty($getid['photo'])){
												echo '<img src="images/default_avatar_male.jpg" width="128" height="128" />';
											}else{
												echo '<img src="'.$getid['photo'].'" width="128" height="128" />';
											}
										}elseif($getid['genero'] == 'Feminino'){
											if(empty($getid['photo'])){
												echo '<img src="images/default_avatar_female.jpg" width="128" height="128" />';
											}else{
												echo '<img src="'.$getid['photo'].'" width="128" height="128" />';
											}
										}
									?>	
										</td>
									</tr>
								</table>
							</td>
							<td valign="top">
								<br /><br />
									<table cellpadding="5" cellspacing="5" border="0" width="500">
										<tr>
											<td valign="top"><strong>Interesses: </strong></td>
											<td valign="top"><?php if($getid['interesses']<>''){ echo $getid['interesses']; } ?></td>
										</tr><tr>
											<td height="44"><strong>Google+: </strong></td>
										  <td><?php if($getid['googleplus']<>''){ echo $getid['googleplus']; } ?></td>
										</tr><tr>
											<td height="42"><strong>ICQ: </strong></td>
										  <td><?php if($getid['icq']<>''){ echo $getid['icq']; } ?></td>
										</tr><tr>
											<td height="45"><strong>Facebook: </strong></td>
										  <td><?php if($getid['facebook']<>''){ echo $getid['facebook']; } ?></td>
										</tr><tr>
											<td height="44"><strong>YouTube: </strong></td>
										  <td><?php if($getid['youtube']<>''){ echo $getid['youtube']; } ?></td>
										</tr><tr>
											<td height="46"><strong>Website: </strong></td>
										  <td><?php if($getid['website']<>''){ echo $getid['website']; } ?></td>
										</tr><tr>
											<td height="70"></td>
										  <td></td>
										</tr>
									</table>
	
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />
		
		</center>
	</div>
	<center><a class="ak1" href="faq.php">FAQ</a>&nbsp;&nbsp;
	<a class="ak1" href="termos.php">Termos de Uso</a></center>
	<?php include "includes/footer.php"; ?>
</body>
</html>	