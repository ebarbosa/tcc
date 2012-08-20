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
				$sql = "DELETE FROM produtores_locais_producao
						WHERE cod = '$cod';";
				$qry = mysql_query($sql);
				/*
				/*	Ao deletar um local de produção, deve-se verificar se o 
				/*	mesmo possui cargas negociadas. Caso tenha, deve-se apenas
				/*	alterar o status do mesmo para 'Cancelado'.
				/*	Caso tenha apenas cargas associadas, deve-se alterar o 
				/*	status do mesmo para 'Cancelado', e o da carga para 
				/*	'Pendente', gerando uma mensagem sobre o ocorrido.
				/*	Caso não exista nenhum relação, deve-se excluir o endereco,
				/*	os materiais de produção e só então realizar a exlusão do 
				/*	local de produção. 
				*/
				header("Location: locaisdeproducao.php");
			}
			else
				echo "O código do local de produção a ser excluído é inválido.";
		}
		else
		{
			$cod_usuario = $_SESSION['codigo_usuario'];
			$status = $_POST['slt_status'];
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
							3, 
							'$estado', 
							'$cidade', 
							'$cep', 
							'$bairro', 
							'$logradouro', 
							'$numero', 
							'$complemento');";
				$query = mysql_query($sql) or die(mysql_error());

				$sql = "select max(cod) from enderecos where cod_usu = '$cod_usuario' and cod_tip_end = 3;";
				$query = mysql_query($sql);
				$cod_end = mysql_result($query, 0);

				$sql = "insert into produtores_locais_producao 
						values (
							NULL,
							'$cod_end',
							'$cod_usuario', 
							'$status');";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: locaisdeproducao.php");
			}
			elseif($op == 3)
			{
				$cod = $_POST['txt_cod'];
				$cod_end = $_POST['txt_cod_end'];
				
				$sql = "update enderecos set
							cod_est = '$estado', 
							cod_cid = '$cidade', 
							cep = '$cep', 
							bairro = '$bairro', 
							logradouro = '$logradouro', 
							numero = '$numero', 
							complemento = '$complemento'
						where cod = '$cod_end';";
				$query = mysql_query($sql) or die(mysql_error());

				$sql = "update produtores_locais_producao set
							status = '$status'
						where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: locaisdeproducao.php");
			}
			else
				echo "O código da operação é inválido.";
		}
	?>
</body>
</html>