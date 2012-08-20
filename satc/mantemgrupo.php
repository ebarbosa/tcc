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
				$sql = "select * from usuarios where cod_gru = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());
				$num_usuarios = mysql_num_rows($query);

				if($num_usuarios === 0)
				{
					$sql = "delete from grupos_funcionalidades where cod_gru = '$cod';";
					$query = mysql_query($sql) or die(mysql_error());

					$sql = "delete from grupos where cod = '$cod';";
					$query = mysql_query($sql) or die(mysql_error());

					header("Location: grupos.php");
				}
				else
					echo "Não é possível excluir o grupo, pois existem usuários associados ao mesmo.";
			}
			else
				echo "O código do grupo a ser excluído é inválido.";
		}
		elseif($op == 2)
		{
			$nome = $_POST['txt_nome'];
			$descricao = $_POST['txt_descricao'];

			$sql = "select max(cod) from grupos;";
			$query = mysql_query($sql) or die(mysql_error());
			$cod_gru = mysql_result($query, 0) + 1;

			$sql = "insert into grupos values ('$cod_gru', '$nome', '$descricao');";
			$query = mysql_query($sql) or die(mysql_error());

			$sql = "select cod from funcionalidades;";
			$query = mysql_query($sql) or die(mysql_error());

			while($funcionalidade = mysql_fetch_array($query))
			{
				$post_funcionalidade = "chk_" . $funcionalidade['cod'];
							
				if(isset($_POST[$post_funcionalidade]))
				{
					$cod_fun = $funcionalidade['cod'];
					$sql_gf = "insert into grupos_funcionalidades values ('$cod_gru', '$cod_fun');";
					$query_gf = mysql_query($sql_gf) or die(mysql_error());
				}		
			}
			header("Location: grupos.php");
		}
		elseif($op == 3)
		{
			$cod = $_POST['txt_cod'];
			$nome = $_POST['txt_nome'];
			$descricao = $_POST['txt_descricao'];
				
			$sql = "update grupos set nome = '$nome', descricao = '$descricao' where cod = '$cod';";
			$query = mysql_query($sql) or die(mysql_error());

			$sql = "delete from grupos_funcionalidades where cod_gru = '$cod';";
			$query = mysql_query($sql) or die(mysql_error());

			$sql = "select cod from funcionalidades;";
			$query = mysql_query($sql) or die(mysql_error());

			while($funcionalidade = mysql_fetch_array($query))
			{
				$post_funcionalidade = "chk_" . $funcionalidade['cod'];
							
				if(isset($_POST[$post_funcionalidade]))
				{
					$cod_fun = $funcionalidade['cod'];
					$sql_gf = "insert into grupos_funcionalidades values ('$cod', '$cod_fun');";
					$query_gf = mysql_query($sql_gf) or die(mysql_error());
				}
			}
			header("Location: grupos.php");
		}
		else
			echo "O código da operação é inválido.";
	?>
</body>
</html>