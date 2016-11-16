<?php include "config/config.inc.php"; ?>
<!DOCTYPE HTML>
<hmtl>
	<head>
		<title>yourdomain.com - <?php 
		$pisd = (int)$_GET['pid'];
		$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_post` WHERE `post_id`=:postid");
		$sqlTopic->bindParam(':postid', $pisd, PDO::PARAM_INT);
		$sqlTopic->execute();
		$result = $sqlTopic->fetch(PDO::FETCH_ASSOC);
		
		$sqlGetForum = $dbconn->prepare("SELECT * FROM `forum_tabl` WHERE `forum_id`=:forumid");
		$sqlGetForum->bindParam(':forumid', $result['forum_id'], PDO::PARAM_INT);
		$sqlGetForum->execute();
		$resultForum = $sqlGetForum->fetch(PDO::FETCH_ASSOC);
		echo $result['post_title']; ?></title>
		<link rel="stylesheet" href="css/styles.css" type="text/css" />
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
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
		<?php
		$pisd = (int)$_GET['pid'];
		$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_post` WHERE `post_id`=:postid");
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
					<a href="index.php">Inicio</a>  &rsaquo;
					<a href="viewforum.php?fid=<?php echo $resultForum['forum_id']; ?>"><?php echo $resultForum['forum_name']; ?></a> &rsaquo; 
					<a href="viewtopic.php?pid=<?php echo $result['post_id']; ?>"><?php echo $result['post_title']; ?></a>
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
			$pid = (int)$_GET['pid'];
			$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_post` WHERE `post_id`=:postids");
			$sqlTopic->bindParam(':postids', $pid, PDO::PARAM_INT);
			$sqlTopic->execute();
			if($sqlTopic->rowCount()>0){
				foreach($sqlTopic as $topics):
		?>	
		<center><table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
					<h1><?php echo $topics['post_title']; ?></h1>
				</td><td align="right">
					<?php if($topics['status'] == 1){ echo 'Editado'; } ?>&nbsp;&nbsp;
				</td>
			</tr>
		</table>
		<?php
			$sqlUsername = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `members_id`=:mid");
			$sqlUsername->bindParam(':mid', $topics['post_author'], PDO::PARAM_INT);
			$sqlUsername->execute();
			$resuser = $sqlUsername->fetch(PDO::FETCH_ASSOC);
		?>
		<table class="box22" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td valign="top" width="823">
					<span><?php echo $topics['post_title']; ?></span>
					<p><br /><br />
					<?php 
					
					$comment = $topics['post_body']; 
					
					$emojis = $dbconn->prepare("SELECT * FROM `emojis`");
					$emojis->execute();
					foreach($emojis as $emoji):
						$chars = $emoji['chars'];
						$imageTag = "<img class='emoji' src='images/".$emoji['image']."' width='23' height='23' />";
						$comment = str_replace($chars,$imageTag,$comment);
					endforeach;
					?><?php echo $comment; ?><br />
					</p>
				</td><td width="47"></td><td valign="top" align="center" width="248">
					<br /><?php	
							if($resuser['genero'] == 'Masculino'){
								if(empty($resuser['photo'])){
									echo '<img src="images/default_avatar_male.jpg" width="84" height="84" />';
								}else{
									echo '<img src="'.$resuser['photo'].'" width="84" height="84" />';
								}
							}elseif($resuser['genero'] == 'Feminino'){
								if(empty($resuser['photo'])){
									echo '<img src="images/default_avatar_female.jpg" width="84" height="84" />';
								}else{
									echo '<img src="'.$resuser['photo'].'" width="84" height="84" />';
								}
							}
							?>
					<br /><br />
					<p>por <a class="alink" href="vermember.php?mid=<?php echo $resuser['members_id']; ?>"><?php echo $resuser['username']; ?></a> <?php //echo '<span class="online">&nbsp; Online &nbsp;</span>'; ?> <br />
					<?php echo $topics['data']; ?></p>
				</td>
			</tr>
		</table><br />
		<?php
				endforeach;
			}
		?>
		<?php
		$idpost = (int)$_GET['pid'];
		$sqlReply = $dbconn->prepare("SELECT * FROM `forum_reply` WHERE `post_id`=:idpost");
		$sqlReply->bindParam(':idpost', $idpost, PDO::PARAM_INT);
		$sqlReply->execute();
		if($sqlReply->rowCount()>0){
			foreach($sqlReply as $reply):
		?>
		<?php
			$sqlUsername = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `members_id`=:mid");
			$sqlUsername->bindParam(':mid', $reply['username'], PDO::PARAM_INT);
			$sqlUsername->execute();
			$resuser = $sqlUsername->fetch(PDO::FETCH_ASSOC);
		?>
		<table class="boxtitle" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
					<h4><?php echo $resuser['username']; ?></h4>
				</td><td align="right">
					<a href="reportar.php?id=<?php echo $reply['reply_id']; ?>" class="btnreport">Reportar</a>
					<?php 
					if(isset($_COOKIE['Memail'])){
					if($resuser['username'] == base64_decode($_COOKIE['Memail'])){
					?>
					<a href="excluir.php?id=<?php echo $reply['reply_id']; ?>" class="btnreport">Excluir</a>
					<a href="editar.php?id=<?php echo $reply['reply_id']; ?>" class="btnreport">Editar</a>
					<?php
					}
					}
					?>
				</td>
			</tr>
		</table>
		<table class="box22" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td valign="top" width="-5">
					<span><strong>Re: <?php echo $topics['post_title']; ?></strong></span><br /><br />
					<p>
					<?php 
					$myreply = $reply['reply']; 
					$emojis = $dbconn->prepare("SELECT * FROM `emojis`");
					$emojis->execute();
					foreach($emojis as $emoji):
						$chars = $emoji['chars'];
						$imageTag = "<img class='emoji' src='images/".$emoji['image']."' width='23' height='23' />";
						$myreply = str_replace($chars,$imageTag,$myreply);
					endforeach;
					
					echo $myreply;
					?>
					</p>
				</td><td></td><td valign="top" align="center" width="248">
					<br /><?php	
							if($resuser['genero'] == 'Masculino'){
								if(empty($resuser['photo'])){
									echo '<img src="images/default_avatar_male.jpg" width="84" height="84" />';
								}else{
									echo '<img src="'.$resuser['photo'].'" width="84" height="84" />';
								}
							}elseif($resuser['genero'] == 'Feminino'){
								if(empty($resuser['photo'])){
									echo '<img src="images/default_avatar_female.jpg" width="84" height="84" />';
								}else{
									echo '<img src="'.$resuser['photo'].'" width="84" height="84" />';
								}
							}
							?>
					<br /><br />
					<p>pelo <a class="alink" href="vermember.php?mid=<?php echo $resuser['members_id']; ?>"><?php echo $resuser['username']; ?></a> <?php //echo '<span class="online">&nbsp; Online &nbsp;</span>'; ?> <br />
					<?php echo $reply['data']; ?></p>
				</td>
			</tr>
		</table><br />
		<?php	
			endforeach;
		}
		?>
		<table  cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td>
					<?php if($resuser['username'] == base64_decode($_COOKIE['Memail'])){  ?>
					<a href="editpost.php?id=<?php echo $result['post_id']; ?>" class="button">&nbsp; Editar &nbsp;</a>&nbsp;&nbsp;
					<a href="excluirpost.php?id=<?php echo $result['post_id']; ?>" class="button">&nbsp; Excluir &nbsp;</a>&nbsp;&nbsp;
					<?php } ?>
					<a href="reportar.php?id=<?php echo $result['post_id']; ?>" class="button">&nbsp; Reportar &nbsp;</a>&nbsp;&nbsp;
					<a href="responder.php?id=<?php echo $result['post_id']; ?>" class="button">&nbsp; Responder &nbsp;</a>
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