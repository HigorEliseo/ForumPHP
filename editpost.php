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
			$pid = (int)$_GET['id'];
			$sqlTopic = $dbconn->prepare("SELECT * FROM `forum_post` WHERE `post_id`=:postids");
			$sqlTopic->bindParam(':postids', $pid, PDO::PARAM_INT);
			$sqlTopic->execute();
			if($sqlTopic->rowCount()>0){
				foreach($sqlTopic as $topics):
		?>	
		<center><table class="box1" cellpadding="3" cellspacing="3" border="0" width="1200">
			<tr>
				<td width="623">
					<h1>Editar: <?php echo $topics['post_title']; ?></h1>
				</td>
			</tr>
		</table><?php
				endforeach;
			}
		?>
		<table class="box22" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td valign="top" width="-5">
				<?php
				if(isset($_POST['preview'])){
					echo '<pre>';
					echo "&quot; ".$_POST['pergunta']." &quot;";
					echo '</pre>';
				}
				
				$username = base64_decode($_COOKIE['Memail']);
				$sqlPegaid = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `username`=:username");
				$sqlPegaid->bindParam(':username', $username, PDO::PARAM_STR);
				$sqlPegaid->execute();
				if($sqlPegaid->rowCount()>0){
					foreach($sqlPegaid as $getid):
						$uid = $getid['members_id'];
					endforeach;
				}
				
				if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
					extract($_POST);
					if($titulo_post == ''){
						echo 'Insira uma titulo no campo abaixo';
					}elseif($pergunta == ''){
						echo 'Insira uma pergunta no campo abaixo';
					}else{
						$sqlInsert = $dbconn->prepare("UPDATE `forum_post` SET `post_title`=:title_p, `post_body`=:body_text, `status`='1' WHERE `post_id`=:postuid AND post_author=:post_author");
						$sqlInsert->bindParam(':title_p', $titulo_post, PDO::PARAM_STR);
						$sqlInsert->bindParam(':postuid', $pid, PDO::PARAM_INT);
						$sqlInsert->bindParam(':body_text', $pergunta, PDO::PARAM_STR);
						$sqlInsert->bindParam(':post_author', $uid, PDO::PARAM_INT);
						if($sqlInsert->execute()){
							header('Location: viewtopic.php?pid='.$pid);
						}
					}
				}	
				?>
				<form method="POST" action="">
					<table cellpadding="21" cellpadding="21" border="0" width="800">
						<tr>
							<td height="54" align="left">&nbsp;&nbsp;
							<input type="text" name="titulo_post" size="74" value="<?php echo $topics['post_title']; ?>" /></td>
						</tr><tr>
							<td align="left">
							&nbsp;&nbsp;
							<textarea cols="90" rows="10" id="pergunta" name="pergunta"><?php echo $topics['post_body']; ?></textarea></td>
						</tr><tr>
							<td align="center"></td>
						</tr><tr>
							<td height="24"></td>
						</tr><tr>
							<td align="center">
								<input type="submit" name="preview" value=" Preview " />&nbsp;&nbsp;
								<input type="submit" value=" Enviar " />
							</td>
						</tr>
					</table>
				</form>	
				</td><td></td><td valign="top" width="275">
					<br /><h3>Emojis: </h3><br />
					
					=) <img src="images/sorriso.gif" width="23" height="23" /><br />
					:D <img src="images/happy.gif" width="23" height="23" /><br />
					raiva <img src="images/angry.gif" width="23" height="23" /><br />
					<3 <img src="images/love.gif" width="23" height="23" /><br />
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