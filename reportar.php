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
					<h1>Denunciar esta mensagem</h1>
				</td>
			</tr>
		</table>
		<table class="box22" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td valign="top" width="-5">
				<?php
				if(isset($_POST['preview'])){
					echo '<pre>';
					echo "&quot; ".$_POST['reposta']." &quot;";
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
					if($resposta == ''){
						echo 'Insira uma resposta no campo abaixo';
					}else{
						$sqlInsert = $dbconn->prepare("INSERT INTO `forum_reply` SET `post_id`=:postuid, `username`=:username, `reply`=:reply");
						$sqlInsert->bindParam(':postuid', $pid, PDO::PARAM_INT);
						$sqlInsert->bindParam(':username', $uid, PDO::PARAM_INT);
						$sqlInsert->bindParam(':reply', $resposta, PDO::PARAM_STR);
						if($sqlInsert->execute()){
							header('Location: viewtopic.php?pid='.$pid);
						}
					}
				}	
				?>
				<form method="POST" action="">
					<table cellpadding="21" cellpadding="21" border="0" width="800">
						<tr>
							<td height="44" align="center">Utilize este formulario para denunciar a mensagem seleciona para os moderadores e administradores do conselho.</td>
						</tr><tr>
							<td height="44" align="center"><select name="">
								<option value="A mensagem cont&eacute; links para software ilegal ou pirata.">A mensagem cont&eacute; links para software ilegal ou pirata.</option>
								<option value="A mensagem reportada tem o unico proposito de fazer propaganda de um site ou outro produto.">A mensagem reportada tem o unico proposito de fazer propaganda de um site ou outro produto.</option>
								<option value="A mensagem relatado &eacute; off topic.">A mensagem relatado &eacute; off topic.</option>
								<option value="A mensagem reportada nao se encaixa em nenhuma categoria, por favor use o campo adicional de informa&ccedil;&otilde;es">A mensagem reportada n&atilde;o se encaixa em nenhuma categoria, por favor use o campo adicional de informa&ccedil;&otilde;es</option>
								
							</select><br /><br /></td>
						</tr><tr>
							<td align="center"><textarea cols="90" rows="10" id="resposta" name="resposta"></textarea></td>
						</tr><tr>
							<td height="24"></td>
						</tr><tr>
							<td align="center">
								<input type="submit" value=" Enviar " />
							</td>
						</tr>
					</table><br />
				</form>	
				</td><td></td><td valign="top" width="275">
					<br /><br />
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