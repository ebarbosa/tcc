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
				$sql = "delete from locais_producao_materiais 
						where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: materiaisdeproducao.php");
			}
			else
				echo "O código do local de produção a ser excluído é inválido.";
		}
		else
		{
			$local_de_producao = $_POST['slt_local_producao'];
			$tipo = $_POST['slt_tipo'];
			$valor = $_POST['slt_material'];
			
			if($op == 2)
			{
				$sql = "insert into locais_producao_materiais 
						values (
							NULL, 
							'$local_de_producao',
							'$tipo', 
							'$valor');";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: materiaisdeproducao.php");
			}
			elseif($op == 3)
			{
				$cod = $_POST['txt_cod'];
				
				$sql = "update locais_producao_materiais set
							cod_loc_pro = '$local_de_producao', 
							cod_tip_mat = '$tipo', 
							cod_mat = '$valor'
						where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());

				header("Location: materiaisdeproducao.php");
			}
			else
				echo "O código da operação é inválido.";
		}
	?>
</body>
</html>