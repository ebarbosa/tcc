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
		$op = isset($_GET['op']) ? $op = $_GET['op'] : $op = "";

		if($op == 1)
		{
			$cod = isset($_GET['cod']) ? $cod = $_GET['cod'] : $cod = "";

			if($cod != "")
			{
				$sql = "delete from grupos_funcionalidades where cod_fun = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				$sql = "delete from funcionalidades where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: funcionalidades.php");
			}
			else
				echo "O código da funcionalidade a ser excluída é inválido.";
		}
		elseif($op == 2)
		{
			$nome = $_POST['txt_nome'];
			$descricao = $_POST['txt_descricao'];
			$pagina = $_POST['txt_pagina'];

			$sql = "insert into funcionalidades values (NULL, '$nome', '$descricao', '$pagina');";
			$query = mysql_query($sql) or die(mysql_error());

			header("Location: funcionalidades.php");
		}
		elseif($op == 3)
		{
			$cod = $_POST['txt_cod'];
			$nome = $_POST['txt_nome'];
			$descricao = $_POST['txt_descricao'];
			$pagina = $_POST['txt_pagina'];
			
			$sql = "update funcionalidades set nome = '$nome', descricao = '$descricao', pagina = '$pagina' where cod = '$cod';";
			$query = mysql_query($sql) or die(mysql_error());

			header("Location: funcionalidades.php");
		}
		else
			echo "O código da operação é inválido.";
	?>
</body>
</html>