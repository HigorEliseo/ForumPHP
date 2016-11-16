<?php include "config/config.inc.php"; ?>
<!DOCTYPE HTML>
<hmtl>
	<head>
		<title>yourdomain.com - Membros</title>
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
		$username = base64_decode($_COOKIE['Memail']);
		$sqlPegaid = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `username`=:username");
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
				<td width="3%">
					
				</td><td width="622" height="16">
					MEMBROS
				</td><td width="557">
				   POSTS
				</td>
			</tr>
		</table>
		<?php
		$sqlMembers = $dbconn->prepare("SELECT * FROM `members_tbl`");
		$sqlMembers->execute();
		if($sqlMembers->rowCount()>0){
			foreach($sqlMembers as $members):
		?>
		<table class="box2" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td width="3%">
					
				</td><td height="43" width="50%">
				<a href="vermember.php?mid=<?php echo $members['members_id']; ?>"><?php echo $members['username']; ?></a>
				</td><td width="32">
					<?php
						
						$sqlPosts = $dbconn->prepare("SELECT * FROM `forum_post` WHERE `post_author`=:postauthor");
						$sqlPosts->bindParam(':postauthor', $members['members_id'], PDO::PARAM_INT);
						$sqlPosts->execute();
						echo $sqlPosts->rowCount();
					?>
				</td>
			</tr>
		</table>
		<?php 	
			endforeach;
		}
		?>
		<br />
		
		</center>
	</div>
	<center><a class="ak1" href="faq.php">FAQ</a>&nbsp;&nbsp;
	<a class="ak1" href="termos.php">Termos de Uso</a></center>
	<?php include "includes/footer.php"; ?>
</body>
</html>	