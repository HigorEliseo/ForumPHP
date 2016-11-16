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
					<h1>Perguntas mais frequentes (FAQ)</h1>
				</td>
			</tr>
		</table>
		<table class="box4" cellpadding="8" cellspacing="8" border="0" width="1200">
			<tr>
				<td style="padding:23px;" width="3%">
					<h3>&bull; Como se registrar?</h3>
					<br />
					A inscrição necessaria para criar topicos e responde-los, o registro é gratuito <br />nem é obrigatorio colocar seu nome real.<br /><br />
					
					<h3>&bull; Usar simlies</h3>
					<br />
					Você provavelmente já viu outros usarem smilies em mensagens de e-mail ou noutros fóruns. <br />Smilies são caracteres do teclado usados para transmitir uma emoção, como um sorriso.<br /><br />
					
					<h3>&bull; Moderadores</h3>
					<br />
					controle individual de moderadores<br /><br />
					fóruns. Eles podem editar, ou apagar quaisquer mensagens nos seus fóruns.<br />
				    Se você tiver uma pergunta sobre um fórum em particular, você deve dirigir<br />
					-lo ao seu moderador do fórum.<br /><br />
					 Administradores e moderadores do fórum reservam o direito de fechar ou excluir qualquer mensagem que não forneça<br />
					 um tópico claro e purposefull. Há muitos membros que ainda usam<br />
					 28.8 e 56k modems que não têm o tempo para percorrer inútil<br />
					 e assuntos sem sentido.<br /><br />
					 Qualquer um que mensagens apenas para aumentar seus fóruns Estatísticas do usuário ou tópicos pós fora do<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; risco Boardom ter lá tópicos fechados, retirados e / ou filiação revogada.<br /><br />
					Tente fazer com que o espelho tópico texto que está dentro do segmento. Temas como "Confira!" e<br />
					 "~~ \\ Você tem que ver isso! // ~~" Só atrair membros para um tópico que eles<br />
					pode não querer ler.<br /><br />
					
					<h3>&bull; Mudando seu perfil</h3>
					<br /><br />
						Você pode facilmente mudar qualquer informação armazenada em seu perfil de registo,<br />
						 usando o &quot; perfil &quot; link localizado perto do topo<br />
						de cada página. Simplesmente identifique-se digitando seu<br />
						 nome de usuário e senha, ou login, e todas as suas informações de perfil<br />
						 aparecerá na tela.<br /><br />
					
					<h3>&bull; Editando seus Posts</h3>
					<br />
					Você pode editar suas próprias mensagens a qualquer momento. Basta ir para o segmento onde<br />
				   o post a ser editado está localizada e você verá uma edição<br />
				   Ícone na linha sob sua mensagem.<br /><br />
				   Clique neste ícone e editar o post. Ninguém mais pode<br />
					editar o seu post, exceto para o moderador do fórum ou o<br />
					administrador do quadro de avisos. Além disso, para até 30 minutos depois de<br /> 
					ter você postou mensagem na tela de edição post vai dar-lhe a opção<br />
					de deleteing que post. Depois de 30 minutos no entanto, apenas o moderador e / ou administrador pode remover o post.<br /><br />
					
					<h3>&bull; Perdeu Nome de usuário e / ou senha</h3>
					<br />
					Na senha mesmo que você perde você pode clicar no botão & quot;? Esqueceu sua senha & quot; link fornecido no<br />
mensagem postando telas ao lado do campo de senha. Este link o levará a uma página onde você pode preencher seu nome de usuário e endereço de email.<br />
O sistema irá, em seguida, enviar e-mail uma nova, gerada aleatoriamente, <br />a senha para o endereço de e-mail listado no seu perfil, se se você forneceu o endereço de e-mail correto.<br /><br />
					
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