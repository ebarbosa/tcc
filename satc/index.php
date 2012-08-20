<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Início</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<p>Bem vindo, <?=$_SESSION['nome_usuario'];?>!&nbsp;<a href="desloga.php">Sair</a></p>
	<hr />
	<p>
		<?php
			$grupo = $_SESSION['grupo_usuario'];
			$sql = "select * from grupos_funcionalidades where cod_gru = '$grupo'";
			$query = mysql_query($sql) or die(mysql_error());
			
			while($grupo_func = mysql_fetch_array($query))
			{
				$cod_fun = $grupo_func['cod_fun'];

				$sql_fun = "select * from funcionalidades where cod = '$cod_fun'";
				$query_fun = mysql_query($sql_fun) or die(mysql_error());
					
				$funcionalidade = mysql_fetch_array($query_fun);
				$pagina = "location.href='" . $funcionalidade['pagina'] . "';";

				echo '<input type="button" value="' . $funcionalidade['nome'] .'" onClick="' . $pagina . '" /><br><br>';
			}
		?>
	</p>
</body>
</html>