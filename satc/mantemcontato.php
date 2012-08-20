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
				$sql = "delete from contatos where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: dadospessoais.php");
			}
			else
				echo "O código do endereco a ser excluído é inválido.";
		}
		else
		{
			$pagina = $_POST['txt_pagina'];

			$cod_usuario = $_SESSION['codigo_usuario'];
			$tipo = $_POST['slt_tipo'];
			$valor = $_POST['txt_valor'];
			
			if($op == 2)
			{
				$sql = "insert into contatos values (NULL, '$cod_usuario', '$tipo', '$valor');";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location:" . $pagina);
			}
			elseif($op == 3)
			{
				$cod = $_POST['txt_cod'];
				
				$sql = "update contatos set cod_usu = '$cod_usuario', tipo = '$tipo', valor = '$valor' where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location:" . $pagina);
			}
			else
				echo "O código da operação é inválido.";
		}
	?>
</body>
</html>