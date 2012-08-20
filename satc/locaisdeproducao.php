<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Locais de Produção</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/estadocidade.js"></script>
</head>
<body>
	<p>Locais de Produção&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<?php
		$cod_pro = $_SESSION['codigo_usuario'];

		$sql = "select * from produtores_locais_producao where cod_pro = '$cod_pro';";
		$query = mysql_query($sql) or die(mysql_error());
	?>
	<table border="1">
		<tr>
			<th></th>
			<th></th>
			<th>Endereço</th>
			<th>Status</th>
		</tr>
		<?php 
			while($local_de_producao = mysql_fetch_array($query)) 
			{
				$cod_endereco = $local_de_producao['cod_end'];
				$sql_endereco = "select logradouro, cod_est, cod_cid from enderecos where cod = '$cod_endereco';";
				$query_endereco = mysql_query($sql_endereco) or die(mysql_error());
				$dados_endereco = mysql_fetch_array($query_endereco);
		?>
		<tr>
			<td><a href="mantemlocaldeproducao.php?op=1&cod=<?=$local_de_producao['cod'];?>">Excluir</a></td>
			<td><a href="locaisdeproducao.php?op=3&cod=<?=$local_de_producao['cod'];?>">Editar</a></td>
			<!--
				Informar o nome do estado e também o nome da cidade, e não seus
				códigos.
			-->
			<td><?=$dados_endereco[0] . ", " . $dados_endereco[1] . "/" . $dados_endereco[2];?></td>
			<!--
				Informar o nomes do status, e não seus códigos.
			-->
			<td>
				<?
					switch($local_de_producao['status'])
					{
						case 1:
							echo "Incompleto";
							break;
						
						case 2:
							echo "Ativo";
							break;

						case 3:
							echo "Cancelado";
							break;

						default:
							echo "-";
							break;
					} 
				?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<hr />
	<?php
		if(isset($_GET['cod']))
		{
			if(isset($_GET['op']) && isset($_GET['op']) == 3)
			{
				$op = $_GET['op'];
				$cod = $_GET['cod'];

				$sql = "select * from produtores_locais_producao where cod = '$cod';";
				$query = mysql_query($sql) or die(mysql_error());
				$local_de_producao = mysql_fetch_array($query);

				$sql = "select cod_est, cod_cid, cep, bairro, logradouro, numero, complemento from enderecos where cod = '" . $local_de_producao['cod_end'] . "';";
				$query = mysql_query($sql) or die(mysql_error());
				$end_loc_pro = mysql_fetch_array($query);
			}
		}					
		else 
			$op = 2;
	?>
	<form name="frm_local_producao" method="post" action="mantemlocaldeproducao.php?op=<?=$op;?>">
		<p><input type="submit" value="Inserir" /></p>
		<input type="hidden" name="txt_cod" value="<?=$local_de_producao['cod'];?>" />
		<input type="hidden" name="txt_cod_end" value="<?=$local_de_producao['cod_end'];?>" />
		Status<br />
		<?php $status = isset($local_de_producao['status']) ? $status = $local_de_producao['status'] : $status = ""; ?>
		<select name="slt_status">
			<option value="0">---</option>
			<option value="1" <?php if($status == 1) echo "selected";?>>Incompleto</option>
			<option value="2" <?php if($status == 2) echo "selected";?>>Ativo</option>
		</select><br />
		Estado<br />
		<?php $estado = isset($end_loc_pro['cod_est']) ? $estado = $end_loc_pro['cod_est'] : $estado = ""; ?>
		<select name="slt_estado">
			<?php
				$sql = "select * from ref_estados;";
				$query = mysql_query($sql) or die(mysql_error());

				echo "<option value='0'>---</option>";
				while($ref_estado = mysql_fetch_array($query))
				{
					$selecionado = $ref_estado['cod'] == $estado ? $selecionado = "selected" : $selecionado = "";
					echo '<option value="' . $ref_estado['cod'] . '" ' . $selecionado . '>' . $ref_estado['valor'] . '</option>';
				}
			?>
		</select><br />
		Cidade<br />
		<?php $cidade = isset($end_loc_pro['cod_cid']) ? $cidade = $end_loc_pro['cod_cid'] : $cidade = ""; ?>
		<input type="hidden" name="hdn_cidade" value="<?=$cidade;?>" />
		<select name="slt_cidade" disabled="disabled">
			<option value="0">Escolha o estado.</option>
		</select><br />
		CEP<br />
		<?php $cep = isset($end_loc_pro['cep']) ? $cep = $end_loc_pro['cep'] : $cep = ""; ?>
		<input type="text" name="txt_cep" value="<?=$cep;?>" /><br />
		Bairro<br />
		<?php $bairro = isset($end_loc_pro['bairro']) ? $bairro = $end_loc_pro['bairro'] : $bairro = ""; ?>
		<input type="text" name="txt_bairro" value="<?=$bairro;?>" /><br />
		Logradouro<br />
		<?php $logradouro = isset($end_loc_pro['logradouro']) ? $logradouro = $end_loc_pro['logradouro'] : $logradouro = ""; ?>
		<input type="text" name="txt_logradouro" value="<?=$logradouro;?>" /><br />
		Número<br />
		<?php $numero = isset($end_loc_pro['numero']) ? $numero = $end_loc_pro['numero'] : $numero = ""; ?>
		<input type="text" name="txt_numero" value="<?=$numero;?>" /><br />
		Complemento<br />
		<?php $complemento = isset($end_loc_pro['complemento']) ? $complemento = $end_loc_pro['complemento'] : $complemento = ""; ?>
		<input type="text" name="txt_complemento" value="<?=$complemento;?>" />
	</form>
</body>
</html>