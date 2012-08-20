<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Processando...</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<?php
		$op = $_GET['op'];
		$cod = isset($_GET['cod']) ? $cod = $_GET['cod'] : $cod = NULL;

		if($op == 1)
		{
			/*
			/* Levantar tudo que deve ser levado em conta antes de se deletar 
			/* um usuário.
			*/
			$sql = "DELETE FROM usuarios
					WHERE cod = '$cod';";
			$qry = mysql_query($sql) or die(mysql_error());

			header("Location: usuarios.php");
		}
		else
		{			
			$pag = $_POST['pagina'];
			$cod = $_POST['txt_cod'];

			$tipo_usuario = isset($_POST['slt_tipo_usuario']) ? $tipo_usuario = $_POST['slt_tipo_usuario'] : $tipo_usuario = NULL;
			$grupo = $_POST['slt_grupo'];
			$email = $_POST['txt_email'];
			$senha = $_POST['txt_senha'];
			$nome = $_POST['txt_nome'];
			$cpf = $_POST['txt_cpf'];
			$rg = $_POST['txt_rg'];
			$cnh = isset($_POST['txt_cnh']) ? $cnh = $_POST['txt_cnh'] : $cnh = NULL;

			if($op == 2)
			{
				$sql = "INSERT INTO usuarios
						VALUES (
							NULL,
							'$tipo_usuario',
							'$grupo',
							'$email',
							'$senha',
							'$nome',
							'$cpf',
							'$rg',
							'$cnh');";
				$qry = mysql_query($sql) or die(mysql_error());

				header("Location:" . $pag);
			}
			if($op == 3)
			{
				if($tipo_usuario)
				{
					$sql = "UPDATE usuarios 
							SET 
								cod_ent = '$slt_tipo_usuario', 
								cod_gru = '$grupo', 
								email = '$email', 
								senha = '$senha', 
								nome = '$nome', 
								cpf = '$cpf', 
								rg = '$rg',
								cnh = '$cnh'
							WHERE cod = '$cod';";
					$qry = mysql_query($sql) or die(mysql_error());
				}
				else
				{
					$sql = "UPDATE usuarios 
							SET 
								nome = '$nome', 
								cpf = '$cpf', 
								rg = '$rg', 
								email = '$email',
								cnh = '$cnh'
							WHERE cod = '$cod';";
					$qry = mysql_query($sql) or die(mysql_error());

					$primeiro_nome = explode(" ", $nome);
					$_SESSION['nome_usuario'] = $primeiro_nome[0];
				}
				header("Location:" . $pag);
			}
		}
	?>
</body>
</html>