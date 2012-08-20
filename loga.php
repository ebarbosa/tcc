<?php include "inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Processando...</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<?php
		$email = $_POST['txt_email'];
		$senha = $_POST['txt_senha'];

		$sql = "select * from usuarios where email ='$email' and senha = '$senha';";
		$query = mysql_query($sql) or die(mysql_error());
		$numero_usuarios = mysql_num_rows($query);

		if($numero_usuarios == 1)
		{
			$usuario = mysql_fetch_array($query);

			$_SESSION['logado'] = 1;
			$_SESSION['codigo_usuario'] = $usuario['cod'];
			$primeiro_nome = explode(" ", $usuario['nome']);
			$_SESSION['nome_usuario'] = $primeiro_nome[0];
			$_SESSION['grupo_usuario'] = $usuario['cod_gru'];
			
			header("Location: satc/index.php");
		}
		else if($numero_usuarios == 0)
			echo "Este usuário não existe.";
		else
			echo "Existe mais de um usuário com o mesmo e-mail e mesma senha.";
	?>
</body>
</html>