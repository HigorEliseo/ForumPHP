<?php include "config/config.inc.php"; ?>
<!DOCTYPE HTML>
<hmtl>
	<head>
		<title>yourdomain.com -
		<?php 
		$pisd = (int)$_GET['fid'];
		$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_tabl` WHERE `forum_id`=:forumid");
		$sqlTopic->bindParam(':forumid', $pisd, PDO::PARAM_INT);
		$sqlTopic->execute();
		$result = $sqlTopic->fetch(PDO::FETCH_ASSOC);
		echo $result['forum_name'];
		?></title>
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
					<a href="viewforum.php?fid=<?php echo $result['forum_id']; ?>"><?php echo $result['forum_name']; ?></a> &rsaquo; 
					<!--<a href="#">Posti 1</a> -->
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
		<center><table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
					TOPICOS
				</td><td width="137" align="center">
					RESPOSTAS
				</td><td width="128" align="center">
					VISUALIZACOES
				</td><td width="273" align="center">
					ULTIMA POSTAGEM
				</td>
			</tr>
		</table>
		<?php
			$fids = (int)$_GET['fid'];
			$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_post` WHERE `forum_id`=:forumids");
			$sqlTopic->bindParam(':forumids', $fids, PDO::PARAM_INT);
			$sqlTopic->execute();
			if($sqlTopic->rowCount()>0){
				foreach($sqlTopic as $topics):
		?>	
		<?php
		$sqlReply = $dbconn->prepare("SELECT * FROM `forum_reply` WHERE `post_id`=:idpost");
		$sqlReply->bindParam(':idpost', $topics['post_id'], PDO::PARAM_INT);
		$sqlReply->execute();
		?>
		<?php
			$sqlUsername = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `members_id`=:mid");
			$sqlUsername->bindParam(':mid', $topics['post_author'], PDO::PARAM_INT);
			$sqlUsername->execute();
			$resuser = $sqlUsername->fetch(PDO::FETCH_ASSOC);
		?>
		<table class="box2" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td width="5%" align="center">
					<img src="images/topic.png" width="32" height="32" />
				</td><td width="50%">				
					<a href="viewtopic.php?pid=<?php echo $topics['post_id']; ?>"><?php echo $topics['post_title']; ?></a>
					<p>pelo <a class="alink" href="vermember.php?mid=<?php echo $resuser['members_id']; ?>"><?php echo $resuser['username']; ?></a> &rsaquo;  
					<?php echo $topics['data']; ?></p>
				</td><td width="137" align="center">
					<?php echo $sqlReply->rowCount(); ?>
				</td><td width="128" align="center">
					0
				</td><td width="273">
					<p>pelo <a class="alink" href="vermember.php?mid=<?php echo $resuser['members_id']; ?>"><?php echo $resuser['username']; ?></a><br />
					<?php echo $topics['data']; ?></p>
				</td>
			</tr>
		</table>
		<?php
				endforeach;
			}
		?>
		<br />
		<table  cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td>
					<a href="novotopico.php?fid=<?php echo $result['forum_id']; ?>" class="button">&nbsp; Novo Topico &nbsp;</a>
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