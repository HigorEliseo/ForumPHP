<?php 
$filename = "config/config.inc.php";
if (file_exists($filename)){
	include "config/config.inc.php"; 
}else{
	header('Location: install/setup-config.php');
}
?>
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
					<!--<a href="#">Seguran&ccedil;a Linux</a> &rsaquo; 
					<a href="#">Posti 1</a> -->
				</td>
				<td align="right">
				<?php if(isset($_COOKIE['Memail']))	{ ?>
				
					<?php
						$EMAIL = base64_decode($_COOKIE['Memail']);
						$resuser122 = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `username`=:mid");
						$resuser122->bindParam(':mid', $EMAIL, PDO::PARAM_STR);
						$resuser122->execute();
						$resuser12 = $resuser122->fetch(PDO::FETCH_ASSOC);
					?>
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
		<center><table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
					<h1>Termos de Uso</h1>
				</td>
			</tr>
		</table>
		<table class="box4" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td style="padding:23px;" width="3%">
					<h3>&bull; Dados do Cadastro e Seguran&ccedil;a da Conta</h3>
					<br />
					Em rela&ccedil;&atilde;o ao seu uso do Site, voc&ecirc; concorda em<br /><br /> (A) fornecer informa&ccedil;&otilde;es precisas, atuais e completas sobre voc&ecirc;, 
					como pode ser solicitado por quaisquer formularios de registro no Site("Dados do Cadastro"); 
					<br /><br />(B) manter a seguran&ccedil;a de sua senha e identifica&ccedil;&atilde;o; e 
					<br /><br />(C) ser plenamente responsavel pelo uso de sua conta e por quaisquer a&ccedil;&otilde;es que ocorrem sobre sua conta.<br /><br />
					
					<h3>&bull; Direitos Autorais </h3>
					<br />
					Voc&ecirc; n&atilde;o pode enviar, distribuir ou reporduzir, de qualquer maneira, qualquer material protegido por direitos autorais,
							marcas comerciais ou outras informa&ccedil;&otilde;es falsas.
					
					
				</td>
			</tr>
		</table>

		<br />
		<table cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td align="center">
				
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