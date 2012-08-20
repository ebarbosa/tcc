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
				$sql = "DELETE FROM cargas_materiais
						WHERE cod_car = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());

				$sql = "DELETE FROM cargas
						WHERE cod = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());

				$sql = "SELECT cod_end FROM cargas
						WHERE cod = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());
				$cod_end = mysql_result($qry, 0);

				$sql = "DELETE FROM enderecos
						WHERE cod = '$cod_end';";
				$qry = mysql_query($sql) or die(mysql_error());				

				$sql = "DELETE FROM cargas_interessados
						WHERE cod_car = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());

				header("Location: cargas.php");
			}
			else
				echo "O código da carga a ser excluída é inválido.";
		}
		else
		{
			$status = $_POST['slt_status'];
			$local_producao = $_POST['chk_loc_pro'];
			$data_carregamento = $_POST['txt_data_carregamento'];
			$data_carregamento = implode("-", array_reverse(explode("/", $data_carregamento)));
			$data_entrega = $_POST['txt_data_entrega'];
			$data_entrega = implode("-", array_reverse(explode("/", $data_entrega)));
			$peso_aproximado = $_POST['txt_peso_aproximado'];
			$valor_aproximado = $_POST['txt_valor_aproximado'];
			$estado = $_POST['slt_estado'];
			$cidade = $_POST['slt_cidade'];
			$cep = $_POST['txt_cep'];
			$bairro = $_POST['txt_bairro'];
			$logradouro = $_POST['txt_logradouro'];
			$numero = $_POST['txt_numero'];
			$complemento = $_POST['txt_complemento'];
			
			if($op == 2)
			{
				$cod_usuario = $_SESSION['codigo_usuario'];
				$sql = "INSERT INTO enderecos 
						VALUES (
							NULL, 
							'$cod_usuario', 
							4, 
							'$estado', 
							'$cidade', 
							'$cep', 
							'$bairro', 
							'$logradouro', 
							'$numero', 
							'$complemento');";
				$qry = mysql_query($sql) or die(mysql_error());

				$sql = "SELECT MAX(cod) FROM enderecos 
						WHERE cod_usu = '$cod_usuario' AND 
							  cod_tip_end = 4;";
				$qry = mysql_query($sql);
				$cod_end = mysql_result($qry, 0);

				$sql = "INSERT INTO cargas 
						VALUES (
							NULL,
							'$local_producao',
							'$cod_end',
							'$data_carregamento', 
							'$data_entrega',
							'$peso_aproximado',
							'$valor_aproximado',
							'$status');";
				$qry = mysql_query($sql) or die(mysql_error());

				$sql = "SELECT cod FROM cargas 
						WHERE cod_end = '$cod_end';";
				$qry = mysql_query($sql);
				$cod_car = mysql_result($qry, 0);

				if(isset($_POST['chk_mat_loc_pro']))
				{
					for($i = 0; $i < count($_POST['chk_mat_loc_pro']); $i++)
					{						
						$cod_mat = $_POST['chk_mat_loc_pro'][$i];
						$sql_tip_mat = "SELECT cod_tip_mat FROM ref_materiais
										WHERE cod = '$cod_mat';";
						$qry_tip_mat = mysql_query($sql_tip_mat) or die(mysql_error());
						$cod_tip_mat = mysql_result($qry_tip_mat, 0);

						$sql = "INSERT INTO cargas_materiais
								VALUES (
									'$cod_car',
									'$cod_tip_mat', 
									'$cod_mat');";
						$qry = mysql_query($sql) or die(mysql_error());
					}
				}
				header("Location: cargas.php");
			}
			elseif($op == 3)
			{
				$cod_end = $_POST['hdn_cod_end'];
				$cod = $_POST['hdn_cod'];

				$sql = "UPDATE enderecos SET
							cod_est = '$estado', 
							cod_cid = '$cidade', 
							cep = '$cep', 
							bairro = '$bairro', 
							logradouro = '$logradouro', 
							numero = '$numero', 
							complemento = '$complemento'
						WHERE cod = '$cod_end';";
				$qry = mysql_query($sql) or die(mysql_error());

				$sql = "UPDATE cargas SET
							cod_loc_pro = '$local_producao',
							dt_carregamento = '$data_carregamento', 
							dt_entrega = '$data_entrega',
							peso_aproximado = '$peso_aproximado',
							valor_aproximado = '$valor_aproximado',
							status = '$status'
						WHERE cod = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());

				$sql = "DELETE FROM cargas_materiais
						WHERE cod_car = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());

				if(isset($_POST['chk_mat_loc_pro']))
				{
					for($i = 0; $i < count($_POST['chk_mat_loc_pro']); $i++)
					{						
						$cod_mat = $_POST['chk_mat_loc_pro'][$i];
						$sql_tip_mat = "SELECT cod_tip_mat FROM ref_materiais
										WHERE cod = '$cod_mat';";
						$qry_tip_mat = mysql_query($sql_tip_mat) or die(mysql_error());
						$cod_tip_mat = mysql_result($qry_tip_mat, 0);

						$sql = "INSERT INTO cargas_materiais
								VALUES (
									'$cod',
									'$cod_tip_mat', 
									'$cod_mat');";
		
						$qry = mysql_query($sql) or die(mysql_error());

					}
				}
				header("Location: cargas.php");
			}
			else
				echo "O código da operação é inválido.";
		}
	?>
</body>
</html>