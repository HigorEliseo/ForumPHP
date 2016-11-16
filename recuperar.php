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
					<a href="login.php">Login</a> 
				</td>
				<td align="right">
					<?php if(isset($_COOKIE['Admmail']))	{ ?>
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
					
				<?php }else{ ?>
					
				<?php } ?>
				</td>
			</tr>
		</table></center>
	</div><div id="topicoscat"><br /><br /><br />
		<?php
			//$passws = "administrator";
			//echo hash("ripemd160", $passws);
			if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
				extract($_POST);
				if($email == ''){
					echo 'E-mail vazio';
				}else{
					$sqlLogin = $dbconn->prepare("SELECT * FROM `members_tbl` WHERE `email`=:user ");
					$sqlLogin->bindParam(':user', $email, PDO::PARAM_STR);
					$sqlLogin->execute();
					if($sqlLogin->rowCount()==1){
						$resuser = $sqlLogin->fetch(PDO::FETCH_ASSOC);
						$codigo = base64_encode($email);
						$data_expirar = date('Y-m-d H:i:s', strtotime('+1 day'));

						$mensagem = '<p>Recebemos uma tentativa de recuperação de senha para este e-mail, caso não tenha sido você,
							desconsidere este e-mail, caso contrário clique no link abaixo<br /> 
							<a href="recuperasenha.php?codigo='.$codigo.'">Recuperar Senha</a></p>';
						$email_remetente = 'contato@phpbb.com';

						$headers = "MIME-Version: 1.1\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\n";
						$headers .= "From: $email_remetente\n";
						$headers .= "Return-Path: $email_remetente\n"; 
						$headers .= "Reply-To: $email\n";
								
						
						$inserir = $dbconn->prepare("INSERT INTO `forum_codes` SET codigo = '$codigo', data = '$data_expirar'");
						if($inserir->execute()){
							if(mail("$email", "Assunto", "$mensagem", $headers, "-f$email_remetente")){
								echo 'Enviamos um e-mail com um link para recuperação de senha, para o endereço de e-mail informado!';
							}
						}
						
					}else{
						echo 'email n&atilde;o esta associado a nenhuma conta!';
					}
				}
			}
		?>
		<center><table cellpadding="8" cellspacing="8" border="0" width="800">
			<tr>
				<td width="366">
					Digite o seu e-mail para recupera&ccedil;&atilde;o de senha.<br /><br />
					<form method="POST" action="">
						<input type="text" name="email" size="28" placeholder="E-mail" /><br /><br />
						<input type="submit" value=" Enviar " />
					</form>
				</td><td align="right">
					
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