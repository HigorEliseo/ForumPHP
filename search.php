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
	</div><div id="topicoscat"><br /><br />
	<?php
		$busca = "";
			$explode = explode(' ',$_GET['keywords']);
			$numP = count($explode);
			for($i=0;$i<$numP;$i++){
			$busca .= "( `post_title` LIKE :busca$i OR `post_body` LIKE :busca$i )";
				if($i<>$numP-1){ $busca .= ' AND ';}
			}
							
			$query_time = microtime();
			$buscar = $dbconn->prepare("SELECT * FROM `forum_post` WHERE $busca");
			for($i=0;$i<$numP;$i++){
				$buscar->bindValue(":busca$i",'%'.$explode[$i].'%',PDO::PARAM_STR);
			}$buscar->execute();
			$query_time = round((microtime()-$query_time), 3);
					
			echo '<center><h2>Pesquisa retornou '.$buscar->rowCount().' resultado(s) para '.$_GET['keywords'].'</h2><br />';
			?>
			<table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
				<tr>
					<td width="623">
						RESULTADO DA PESQUISA
					</td>
				</tr>
			</table>
		<?php	
		if($r = $buscar->rowCount()>0) {
			while($resBusca = $buscar->fetch(PDO::FETCH_ASSOC)){
		?>	
		<?php
			$sqlUsername = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `members_id`=:mid");
			$sqlUsername->bindParam(':mid', $resBusca['post_author'], PDO::PARAM_INT);
			$sqlUsername->execute();
			$resuser = $sqlUsername->fetch(PDO::FETCH_ASSOC);
		?>	
		<table class="box2" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td style="padding:11px;" width="623">
					<a href="viewtopic.php?pid=<?php echo $resBusca['post_id'] ?>"><?php echo $resBusca['post_title'] ?></a><br />
					Por: <a class="alink" href="vermember.php?mid=<?php echo $resuser['members_id']; ?>"><?php echo $resuser['username']; ?></a><br /><br />
					<?php echo $resBusca['post_body'] ?>
				</td>
			</tr>
		</table>
		<?php
			}
		}		
		?>
		<br />
		<table cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td align="center">
				<?php if(isset($_COOKIE['Memail']))	{}else{ ?>
					
					<form method="POST" action="login.php">
						Nome de Usu&aacute;rio: &nbsp;<input type="text" name="nomeuser" size="28" placeholder="User" />
						&nbsp;Senha: &nbsp;<input type="password" name="passw" size="28" placeholder="Pass" />
						&nbsp;&nbsp;<input type="checkbox" name="lembrar" /> Lembrar-me&nbsp;&nbsp;
						<input type="submit" value=" Entrar " />
					</form>
					
				<?php } ?>	
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