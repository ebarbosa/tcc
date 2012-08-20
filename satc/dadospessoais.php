<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Dados Pessoais</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/config.css" />
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/estadocidade.js"></script>
</head>
<body>
	<p>Dados Pessoais&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<?php
		$cod_usu = $_SESSION['codigo_usuario'];
		$sql = "SELECT * FROM usuarios
				WHERE cod = '$cod_usu';";
		$qry = mysql_query($sql) or die(mysql_error());
		$vet_pro = mysql_fetch_array($qry);

		$cod = $vet_pro['cod'];
		$tip_usu = $vet_pro['cod_ent'];
		$nom = $vet_pro['nome'];
		$cpf = $vet_pro['cpf'];
		$rg =  $vet_pro['rg'];
		$ema = $vet_pro['email'];
		$cnh = $tip_usu == 2 ? $cnh = $vet_pro['cnh'] : $cnh = NULL;
	?>
	<form name="frm_dados_pessoais" method="post" action="mantemusuario.php?op=3">
		<label>
			<input type="hidden" name="pagina" value="dadospessoais.php" />
		</label>
		<label>
			<input type="hidden" name="txt_cod" value="<?=$cod;?>" />
		</label>
		<label>
			Código:<br />
			<input type="text" value="<?=$cod;?>" disabled />
		</label>
		<label>
			Nome:<br />
			<input type="text" name="txt_nome" value="<?=$nom;?>" />
		</label>
		<label>
			CPF:<br />
			<input type="text" name="txt_cpf" value="<?=$cpf;?>" />
		</label>
		<label>
			RG:<br />
			<input type="text" name="txt_rg" value="<?=$rg;?>" />
		</label>
		<label>
			E-mail:<br />
			<input type="text" name="txt_email" value="<?=$ema;?>" />
		</label>
		<?php if($tip_usu == 2) { ?>
			<label>
				CNH<br />
				<input type="text" name="txt_cnh" value="<?=$cnh;?>" />
			</label>
		<?php } ?>
		<label>
			<input type="submit" value="Atualizar" />
		</label>
	</form>
	<hr />
	<?php
		$sql = "SELECT * FROM enderecos 
				WHERE cod_usu = '$cod_usu' AND
					  cod_tip_end IN (1, 2);";
		$qry = mysql_query($sql) or die(mysql_error());
	?>
	<table border="1">
		<tr>
			<th></th>
			<th></th>
			<th>Tipo</th>
			<th>Estado</th>
			<th>Cidade</th>
			<th>Logradouro</th>
		</tr>
		<?php 
			while($vet_end = mysql_fetch_array($qry))
			{
				$cod_tip_end = $vet_end['cod_tip_end'];
				$sql = "SELECT valor FROM ref_tipos_endereco
						WHERE cod = '$cod_tip_end'";
				$qry = mysql_query($sql) or die(mysql_error());
				$tip_end = mysql_result($qry, 0);

				$cod_est = $vet_end['cod_est'];
				$sql = "SELECT valor FROM ref_estados
						WHERE cod = '$cod_est'";
				$qry = mysql_query($sql) or die(mysql_error());
				$est = mysql_result($qry, 0);

				$cod_cid = $vet_end['cod_cid'];
				$sql = "SELECT valor FROM ref_cidades
						WHERE cod = '$cod_cid'";
				$qry = mysql_query($sql) or die(mysql_error());
				$cid = mysql_result($qry, 0);
		?>
		<tr>
			<td><a href="mantemendereco.php?op=1&cod=<?=$vet_end['cod'];?>">Excluir</a></td>
			<td><a href="dadospessoais.php?cod_end=<?=$vet_end['cod'];?>&op=3">Editar</a></td>
			<td><?=$tip_end;?></td>
			<td><?=$est;?></td>
			<td><?=$cid;?></td>
			<td><?=$vet_end['logradouro'];?></td>
		</tr>
		<?php } ?>
	</table>
	<hr />
	<?php
		if(isset($_GET['cod_end']))
		{
			if(isset($_GET['op']) && isset($_GET['op']) == 3)
			{
				$cod_end = $_GET['cod_end'];
				$op = $_GET['op'];

				$sql = "SELECT * FROM enderecos
						WHERE cod = '$cod_end';";
				$qry = mysql_query($sql) or die(mysql_error());
				$vet_end = mysql_fetch_array($qry);
			}
		}
		else 
			$op = 2;
	?>
	<form name="frm_endereco" method="post" action="mantemendereco.php?op=<?=$op;?>">
		<p><input type="submit" value="Inserir" /></p>
		<input type="hidden" name="txt_cod" value="<?=$vet_end['cod'];?>" />
		Tipo:<br />
		<?php $tipo = isset($vet_end['cod_tip_end']) ? $tipo = $vet_end['cod_tip_end'] : $tipo = ""; ?>
		<select name="slt_tipo_endereco">
			<?php
				$sql = "select * from ref_tipos_endereco where cod in (1, 2);";
				$query = mysql_query($sql) or die(mysql_error());

				echo "<option value='0'>---</option>";
				while($ref_tipo_endereco = mysql_fetch_array($query))
				{
					$tipo_endereco_usuario = $ref_tipo_endereco['cod'] == $tipo ? $tipo_endereco_usuario = "selected" : $tipo_endereco_usuario = "";
					echo '<option value="' . $ref_tipo_endereco['cod'] . '" ' . $tipo_endereco_usuario . '>' . $ref_tipo_endereco['valor'] . '</option>';
				}
			?>
		</select><br />
		Estado:<br />
		<?php $estado = isset($vet_end['cod_est']) ? $estado = $vet_end['cod_est'] : $estado = ""; ?>
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
		Cidade:<br />
		<?php $cidade = isset($vet_end['cod_cid']) ? $cidade = $vet_end['cod_cid'] : $cidade = ""; ?>
		<input type="hidden" name="hdn_cidade" value="<?=$cidade;?>" />
		<select name="slt_cidade" disabled="disabled">
			<option value="0">Escolha o estado.</option>
		</select><br />
		CEP:<br />
		<?php $cep = isset($vet_end['cep']) ? $cep = $vet_end['cep'] : $cep = ""; ?>
		<input type="text" name="txt_cep" value="<?=$cep;?>" /><br />
		Bairro:<br />
		<?php $bairro = isset($vet_end['bairro']) ? $bairro = $vet_end['bairro'] : $bairro = ""; ?>
		<input type="text" name="txt_bairro" value="<?=$bairro;?>" /><br />
		Logradouro:<br />
		<?php $logradouro = isset($vet_end['logradouro']) ? $logradouro = $vet_end['logradouro'] : $logradouro = ""; ?>
		<input type="text" name="txt_logradouro" value="<?=$logradouro;?>" /><br />
		Número:<br />
		<?php $numero = isset($vet_end['numero']) ? $numero = $vet_end['numero'] : $numero = ""; ?>
		<input type="text" name="txt_numero" value="<?=$numero;?>" /><br />
		Complemento:<br />
		<?php $complemento = isset($vet_end['complemento']) ? $complemento = $vet_end['complemento'] : $complemento = ""; ?>
		<input type="text" name="txt_complemento" value="<?=$complemento;?>" />
	</form>
	<hr />
	<?php
		$sql = "select * from contatos where cod_usu = " . $_SESSION['codigo_usuario'] . ";";
		$query = mysql_query($sql) or die(mysql_error());
	?>
	<table border="1">
		<tr>
			<th></th>
			<th></th>
			<th>Tipo</th>
			<th>Valor</th>
		</tr>
		<?php
			while($vet_con = mysql_fetch_array($query))
			{
				$cod_tip_con = $vet_con['tipo'];
				$sql = "SELECT valor FROM ref_tipos_contato
						WHERE cod = '$cod_tip_con'";
				$qry = mysql_query($sql) or die(mysql_error());
				$tip_con = mysql_result($qry, 0);
		?>
		<tr>
			<td><a href="mantemcontato.php?op=1&cod=<?=$vet_con['cod'];?>">Excluir</a></td>
			<td><a href="dadospessoais.php?cod_con=<?=$vet_con['cod'];?>&op=3">Editar</a></td>
			<td><?=$tip_con;?></td>
			<td><?=$vet_con['valor'];?></td>
		</tr>
		<?php } ?>
	</table>
	<hr />
	<?php
		if(isset($_GET['cod_con']))
		{
			if(isset($_GET['op']) && isset($_GET['op']) == 3)
			{
				$cod_con = $_GET['cod_con'];
				$op = $_GET['op'];

				$sql = "select * from contatos where cod = '$cod_con';";
				$query = mysql_query($sql) or die(mysql_error());
				$vet_con = mysql_fetch_array($query);
			}
		}
		else 
			$op = 2;
	?>
	<form name="frm_contato" method="post" action="mantemcontato.php?op=<?=$op;?>">
		<p><input type="submit" value="Inserir" /></p>
		<input type="hidden" name="txt_cod" value="<?=$vet_con['cod'];?>" />
		<input type="hidden" name="txt_pagina" value="dadospessoais.php" />
		Tipo:<br />
		<select name="slt_tipo">
			<option value="0">---</option>
			<?php
				$sql = "select * from ref_tipos_contato;";
				$qry = mysql_query($sql) or die(mysql_error());

				while($vet_tip_con = mysql_fetch_array($qry))
				{
					$slt = $vet_tip_con['cod'] == $vet_con['tipo'] ? $slt = "selected" : $slt = "";
					echo '<option value="' . $vet_tip_con['cod'] . '" ' . $slt . '>' . $vet_tip_con['valor'] . '</option>';
				}
			?>
		</select><br />
		Valor:<br />
		<?php $valor = isset($vet_con['valor']) ? $valor = $vet_con['valor'] : $valor = ""; ?>
		<input type="text" name="txt_valor" value="<?=$valor;?>" /><br />
	</form>
</body>
</html>