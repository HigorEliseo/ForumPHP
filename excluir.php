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
						if(isset($_COOKIE['Memail'])){}else{ header('Location: login.php'); }
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
		<?php
		$pisd = (int)$_GET['id'];
		$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_reply` WHERE `reply_id`=:postid");
		$sqlTopic->bindParam(':postid', $pisd, PDO::PARAM_INT);
		$sqlTopic->execute();
		$result = $sqlTopic->fetch(PDO::FETCH_ASSOC);
		
		$sqlGetForum = $dbconn->prepare("SELECT * FROM `forum_tabl` WHERE `forum_id`=:forumid");
		$sqlGetForum->bindParam(':forumid', $result['forum_id'], PDO::PARAM_INT);
		$sqlGetForum->execute();
		$resultForum = $sqlGetForum->fetch(PDO::FETCH_ASSOC);
		
		?>
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
	</div><div id="topicoscat"><br /><br /><br />	
		<center><table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
					<h1>Exluir resposta <?php echo $result['reply']; ?>?</h1>
				</td>
			</tr>
		</table>
		<?php
			$sqlUsername = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `members_id`=:mid");
			$sqlUsername->bindParam(':mid', $result['username'], PDO::PARAM_INT);
			$sqlUsername->execute();
			$resuser = $sqlUsername->fetch(PDO::FETCH_ASSOC);
		?>
		<table class="box22" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td valign="top" align="center" width="-5">
                <br /><h2>Voc&ecirc; tem certeza que deseja excluir esta postagem?</h2>
				<?php
					$postidurl = (int)$_GET['id'];
					if(isset($_POST['sim'])){
						$sqlExcluirPost = $dbconn->prepare("DELETE FROM `forum_reply` WHERE `username`=:postauthor AND `reply_id`=:idpost");
						$sqlExcluirPost->bindParam(':postauthor', $resuser['members_id'], PDO::PARAM_INT);
						$sqlExcluirPost->bindParam(':idpost', $postidurl, PDO::PARAM_INT);
						if($sqlExcluirPost->execute()){
							header('Location: viewtopic.php?pid='.$result['post_id']);
						}
					}
				?><br /><br />
				<form method="POST" action="">
					<input type="submit" name="sim" value=" Sim " />&nbsp;&nbsp;
					<a href="#"> N&atilde;o </a>
				</form><br />
				</td>
			</tr>
		</table><br />
		</center>
	</div>
	<center><a class="ak1" href="faq.php">FAQ</a>&nbsp;&nbsp;
	<a class="ak1" href="termos.php">Termos de Uso</a></center>
	<?php include "includes/footer.php"; ?>
</body>
</html>	