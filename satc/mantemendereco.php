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
				$sql = "delete from enderecos where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: dadospessoais.php");
			}
			else
				echo "O código do endereço a ser excluído é inválido.";
		}
		else
		{
			$cod_usuario = $_SESSION['codigo_usuario'];
			$tipo = $_POST['slt_tipo_endereco'];
			$estado = $_POST['slt_estado'];
			$cidade = $_POST['slt_cidade'];
			$cep = $_POST['txt_cep'];
			$bairro = $_POST['txt_bairro'];
			$logradouro = $_POST['txt_logradouro'];
			$numero = $_POST['txt_numero'];
			$complemento = $_POST['txt_complemento'];
			
			if($op == 2)
			{
				$sql = "insert into enderecos 
						values (
							NULL, 
							'$cod_usuario', 
							'$tipo', 
							'$estado', 
							'$cidade', 
							'$cep', 
							'$bairro', 
							'$logradouro', 
							'$numero', 
							'$complemento');";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: dadospessoais.php");
			}
			elseif($op == 3)
			{
				$cod = $_POST['txt_cod'];
				
				$sql = "update enderecos set 
							cod_tip_end = '$tipo', 
							cod_est = '$estado', 
							cod_cid = '$cidade', 
							cep = '$cep', 
							bairro = '$bairro', 
							logradouro = '$logradouro', 
							numero = '$numero', 
							complemento = '$complemento'
							where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: dadospessoais.php");
			}
			else
				echo "O código da operação é inválido.";
		}
	?>
</body>
</html>