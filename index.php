<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Bem vindo ao SATC!</title>
</head>
<body>
	<p>
		Faça seu login!<p />
		<form method="post" name="frm_login" action="loga.php">
			E-mail<br />
			<input type="text" name= "txt_email" /><br />
			Senha<br />
			<input type="password" name= "txt_senha" />
			<input type="submit" value="Entrar!" />
		</form>
	</p>
	<hr />
	<p>
		Não possui cadastro?<p />
		<form method="post" name="frm_cadastro" action="cadastro.php">
			Tipo de Usuário<br />
			<select name="slt_tipo_usuario" class="campo">
				<option></option>
				<option value="1">Produtor</option>
				<option value="2">Transportador</option>
			</select><br />
			E-mail<br />
			<input type="text" name= "txt_email" />
			<input type="submit" value="Prosseguir" />
		</form>
	</p>
</body>
</html>