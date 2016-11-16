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
					A inscri��o necessaria para criar topicos e responde-los, o registro � gratuito <br />nem � obrigatorio colocar seu nome real.<br /><br />
					
					<h3>&bull; Usar simlies</h3>
					<br />
					Voc� provavelmente j� viu outros usarem smilies em mensagens de e-mail ou noutros f�runs. <br />Smilies s�o caracteres do teclado usados para transmitir uma emo��o, como um sorriso.<br /><br />
					
					<h3>&bull; Moderadores</h3>
					<br />
					controle individual de moderadores<br /><br />
					f�runs. Eles podem editar, ou apagar quaisquer mensagens nos seus f�runs.<br />
				   �Se voc� tiver uma pergunta sobre um f�rum em particular, voc� deve dirigir<br />
					-lo ao seu moderador do f�rum.<br /><br />
					�Administradores e moderadores do f�rum reservam o direito de fechar ou excluir qualquer mensagem que n�o forne�a<br />
					�um t�pico claro e purposefull. H� muitos membros que ainda usam<br />
					�28.8 e 56k modems que n�o t�m o tempo para percorrer in�til<br />
					�e assuntos sem sentido.<br /><br />
					 Qualquer um que mensagens apenas para aumentar seus f�runs Estat�sticas do usu�rio ou t�picos p�s fora do<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; risco Boardom ter l� t�picos fechados, retirados e / ou filia��o revogada.<br /><br />
					Tente fazer com que o espelho t�pico texto que est� dentro do segmento. Temas como "Confira!" e<br />
					�"~~ \\ Voc� tem que ver isso! // ~~" S� atrair membros para um t�pico que eles<br />
					pode n�o querer ler.<br /><br />
					
					<h3>&bull; Mudando seu perfil</h3>
					<br /><br />
						Voc� pode facilmente mudar qualquer informa��o armazenada em seu perfil de registo,<br />
						 usando o &quot; perfil &quot; link localizado perto do topo<br />
						de cada p�gina. Simplesmente identifique-se digitando seu<br />
						�nome de usu�rio e senha, ou login, e todas as suas informa��es de perfil<br />
						 aparecer� na tela.<br /><br />
					
					<h3>&bull; Editando seus Posts</h3>
					<br />
					Voc� pode editar suas pr�prias mensagens a qualquer momento. Basta ir para o segmento onde<br />
				  �o post a ser editado est� localizada e voc� ver� uma edi��o<br />
				   �cone na linha sob sua mensagem.<br /><br />
				   Clique neste �cone e editar o post. Ningu�m mais pode<br />
					editar o seu post, exceto para o moderador do f�rum ou o<br />
					administrador do quadro de avisos. Al�m disso, para at� 30 minutos depois de<br /> 
					ter voc� postou mensagem na tela de edi��o post vai dar-lhe a op��o<br />
					de deleteing que post. Depois de 30 minutos no entanto, apenas o moderador e / ou administrador pode remover o post.<br /><br />
					
					<h3>&bull; Perdeu Nome de usu�rio e / ou senha</h3>
					<br />
					Na senha mesmo que voc� perde voc� pode clicar no bot�o & quot;? Esqueceu sua senha & quot; link fornecido no<br />
mensagem postando telas ao lado do campo de senha. Este link o levar� a uma p�gina onde voc� pode preencher seu nome de usu�rio e endere�o de email.<br />
O sistema ir�, em seguida, enviar e-mail uma nova, gerada aleatoriamente, <br />a senha para o endere�o de e-mail listado no seu perfil, se se voc� forneceu o endere�o de e-mail correto.<br /><br />
					
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