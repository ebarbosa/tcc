<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Cargas</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/config.css" />
	<style type="text/css">
	<!--
		label .local_producao {
			font-weight: bold;
			margin: 0
		}
		form div {
			margin: 15px 0 0 0
		}
		.mudar, .local_producao {
			width: 100%;
			overflow: auto;
		}
		.mudar {
			background: #D6E2E5
		}
		.local_producao {
			background: #ADD6EF;
			padding: 10px 0
		}

	-->
	</style>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/estadocidade.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#frm_carga input:radio').click(function()
			{
				$('#frm_carga input:checkbox').removeAttr('checked').removeAttr('disabled');
				$(this).parents('.mudar').siblings('.mudar').find(':checkbox').attr('disabled', 'disabled');
			});

			if($("input[name=chk_loc_pro]").is(':checked'))
			{
				$('#frm_carga input:checkbox').attr('disabled', false);
				$('#frm_carga input:radio:checked').parents('.mudar').siblings('.mudar').find(':checkbox').attr('disabled', 'disabled');
			}
			else
				$('#frm_carga input:checkbox').attr('disabled', 'disabled');
		});
	</script>
</head>
<body>
	<p>Cargas&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<?php
		$cod_pro = $_SESSION['codigo_usuario'];

		$sql = "SELECT * 
				FROM cargas 
				WHERE 
					cod_loc_pro IN (
						SELECT cod 
							FROM produtores_locais_producao 
								WHERE 
									cod_pro = '$cod_pro')";
		$qry = mysql_query($sql) or die(mysql_error());
	?>
	<table border="1">
		<tr>
			<th></th>
			<th></th>
			<th>Local de Produção</th>
			<th>Destino</th>
			<th>Interessados</th>
			<th>Status</th>
		</tr>
		<?php
			while($vet_car = mysql_fetch_array($qry)) 
			{
				$cod_loc_pro = $vet_car['cod_loc_pro'];
				$sql_cod_end_loc_pro = "SELECT cod_end FROM produtores_locais_producao
									WHERE cod = '$cod_loc_pro';";
				$qry_cod_end_loc_pro = mysql_query($sql_cod_end_loc_pro) or die(mysql_error());
				$cod_end_loc_pro = mysql_result($qry_cod_end_loc_pro, 0);

				$sql_end_loc_pro = "SELECT logradouro, cod_est, cod_cid FROM enderecos 
									WHERE cod = '$cod_end_loc_pro';";
				$qry_end_loc_pro = mysql_query($sql_end_loc_pro) or die(mysql_error());
				$vet_end_loc_pro = mysql_fetch_array($qry_end_loc_pro);

				$cod_end = $vet_car['cod_end'];
				$sql_end = "SELECT logradouro, cod_est, cod_cid FROM enderecos
							WHERE cod = '$cod_end';";
				$qry_end = mysql_query($sql_end) or die(mysql_error());
				$vet_end_car = mysql_fetch_array($qry_end);

				$cod_car = $vet_car['cod'];
				$sql_int_car = "SELECT COUNT(cod_car) FROM cargas_interessados 
								WHERE cod_car = '$cod_car';";
				$qry_int_car = mysql_query($sql_int_car) or die(mysql_error());
				$qtd_int_car = mysql_result($qry_int_car, 0);

				$cod_sta = $vet_car['status'];
				$sql_sta = "SELECT valor FROM ref_status_cargas
							WHERE cod = '$cod_sta';";
				$qry_sta = mysql_query($sql_sta) or die(mysql_error());
				$vlr_sta = mysql_result($qry_sta, 0);
		?>
		<tr>
			<td><a href="mantemcarga.php?op=1&cod=<?=$cod_car;?>">Excluir</a></td>
			<td><a href="cargas.php?op=3&cod=<?=$cod_car;?>">Editar</a></td>
			<td><?=$vet_end_loc_pro[0] . ", " . $vet_end_loc_pro[1] . "/" . $vet_end_loc_pro[2];?></td>
			<td><?=$vet_end_car[0] . ", " . $vet_end_car[1] . "/" . $vet_end_car[2];?></td>
			<td><?=$qtd_int_car;?></td>
			<td><?=$vlr_sta;?></td>
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

				$sql = "SELECT * FROM cargas 
						WHERE cod = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());
				$vet_car = mysql_fetch_array($qry);

				$cod_end = $vet_car['cod_end'];
				$sql = "SELECT * FROM enderecos
						WHERE cod = '$cod_end';";
				$qry = mysql_query($sql) or die(mysql_error());
				$vet_end = mysql_fetch_array($qry);
			}
		}					
		else 
			$op = 2;
	?>
	<form name="frm_carga" id="frm_carga" method="post" action="mantemcarga.php?op=<?=$op;?>">
		<label>
			<input type="submit" value="Inserir" />
		</label><br />
		<?php $cod_car = isset($cod) ? $cod_car = $cod : $cod_car = ""; ?>
		<input type="hidden" name="hdn_cod" value="<?=$cod_car;?>" /><br />
		<label>
			Status<br />
			<select name="slt_status">
				<option value="0">---</option>
				<?php
					$sql = "SELECT * FROM ref_status_cargas;";
					$qry = mysql_query($sql) or die(mysql_error());

					while($vet_sta_car = mysql_fetch_array($qry)) 
					{
						$slt = $vet_car['status'] == $vet_sta_car['cod'] ? $slt = "selected" : $slt = "";
						echo '<option value="' . $vet_sta_car['cod'] . '" ' . $slt . '>' . $vet_sta_car['valor'] . '</option>';
					}				
				?>
			</select>
		</label>
		<label style="width: 100%">Local de Produção</label>
		<?php
			$sql = "SELECT cod, cod_end FROM produtores_locais_producao 
					WHERE cod_pro = '$cod_pro' AND 
						  status IN (1, 2);";
			$qry = mysql_query($sql) or die(mysql_error());

			while($vet_loc_pro = mysql_fetch_array($qry)) 
			{
				echo '<div class="mudar"><label class="local_producao">';
				$cod_endereco = $vet_loc_pro['cod_end'];
				$cod_loc_pro = $vet_loc_pro['cod'];

				$sql_end_loc_pro = "SELECT logradouro, cod_est, cod_cid FROM enderecos
									WHERE cod = '$cod_endereco';";
				$qry_end_loc_pro = mysql_query($sql_end_loc_pro) or die(mysql_error());
				$vet_end_loc_pro = mysql_fetch_array($qry_end_loc_pro);
				$val_log = $vet_end_loc_pro[0];

				$cod_cid = $vet_end_loc_pro[2];
				$sql_nom_cid = "SELECT valor FROM ref_cidades
						WHERE cod = '$cod_cid';";
				$qry_nom_cid = mysql_query($sql_nom_cid);
				$nom_cid = mysql_result($qry_nom_cid, 0);

				$cod_est = $vet_end_loc_pro[1];
				$sql_nom_est = "SELECT valor FROM ref_estados
						WHERE cod = '$cod_est';";
				$qry_nom_est = mysql_query($sql_nom_est);
				$nom_est = mysql_result($qry_nom_est, 0);

				$end_con = $val_log . ", " . $nom_cid . "/" . $nom_est;
				
				$chk = $vet_car['cod_loc_pro'] == $vet_loc_pro['cod'] ? $chk = "checked" : $chk = "";
				echo '<input type="radio" name="chk_loc_pro" value="' . $vet_loc_pro['cod'] . '" ' . $chk . ' />' . $end_con . '</label>';
			
				$sql_mat_loc_pro = "SELECT * FROM locais_producao_materiais
									WHERE cod_loc_pro = '$cod_loc_pro';";
				$qry_mat_loc_pro = mysql_query($sql_mat_loc_pro) or die(mysql_error());

				while($vet_mat_loc_pro = mysql_fetch_array($qry_mat_loc_pro))
				{
					$cod_mat = $vet_mat_loc_pro['cod_mat'];
					$sql_mat = "SELECT * FROM ref_materiais
								WHERE cod = '$cod_mat';";
					$qry_mat = mysql_query($sql_mat);
					$vet_mat = mysql_fetch_array($qry_mat);

					$cod_mat_car = NULL;
					if(isset($cod))
					{
						$sql_mat_car = "SELECT cod_mat FROM cargas_materiais
										WHERE cod_car = '$cod' AND
											  cod_mat = '$cod_mat';";
						$qry_mat_car = mysql_query($sql_mat_car);

						$cod_mat_car = NULL;
						if(mysql_num_rows($qry_mat_car) > 0)
							$cod_mat_car = mysql_result($qry_mat_car, 0);
					}

					$chk = $vet_mat_loc_pro['cod_mat'] == $cod_mat_car  ? $chk = "checked" : $chk = "";
					echo '<label><input type="checkbox" name="chk_mat_loc_pro[]" value="' . $vet_mat['cod'] . '" ' . $chk . ' />' . $vet_mat['valor'] . '</label>';
				}
				echo '</div>';
			}
		?>
		<label>
			Data de Carregamento<br />
			<?php $dat_car = isset($vet_car['dt_carregamento']) ? $dat_car = implode("/", array_reverse(explode("-", $vet_car['dt_carregamento']))) : $dat_car = ""; ?>
			<input type="text" name="txt_data_carregamento" value="<?=$dat_car;?>" />
		</label>
		<label>
			Data de Entrega<br />
			<?php $dat_ent = isset($vet_car['dt_entrega']) ? $dat_ent = implode("/", array_reverse(explode("-", $vet_car['dt_entrega']))) : $dat_ent = ""; ?>
			<input type="text" name="txt_data_entrega" value="<?=$dat_ent;?>" />
		</label>
		<label>
			Peso Aproximado<br />
			<?php $pes_apr = isset($vet_car['peso_aproximado']) ? $pes_apr = $vet_car['peso_aproximado'] : $pes_apr = ""; ?>
			<input type="text" name="txt_peso_aproximado" value="<?=$pes_apr;?>" />
		</label>
		Valor Aproximado<br />
		<?php $val_apr = isset($vet_car['valor_aproximado']) ? $val_apr = $vet_car['valor_aproximado'] : $val_apr = ""; ?>
		<input type="text" name="txt_valor_aproximado" value="<?=$val_apr;?>" /><p />
		<hr />
		<p><b>Endereço de Entrega</b></p>
		<input type="hidden" name="hdn_cod_end" value="<?=$vet_end['cod'];?>" />		
		<label>
			Estado<br />
			<select name="slt_estado">
				<option value="0">---</option>
				<?php
					$sql = "SELECT * FROM ref_estados;";
					$qry = mysql_query($sql) or die(mysql_error());

					while($ref_est = mysql_fetch_array($qry))
					{
						$slt = $ref_est['cod'] == $vet_end['cod_est'] ? $slt = "selected" : $slt = "";
						echo '<option value="' . $ref_est['cod'] . '" ' . $slt . '>' . $ref_est['valor'] . '</option>';
					}
				?>
			</select>
		</label>
		<label>
			Cidade<br />
			<?php $cid = isset($vet_end['cod_cid']) ? $cid = $vet_end['cod_cid'] : $cid = ""; ?>
			<input type="hidden" name="hdn_cidade" value="<?=$cid;?>" />
			<select name="slt_cidade" disabled="disabled">
				<option value="0">Escolha o estado.</option>
			</select>
		</label>
		<label>
			CEP<br />
			<?php $cep = isset($vet_end['cep']) ? $cep = $vet_end['cep'] : $cep = ""; ?>
			<input type="text" name="txt_cep" value="<?=$cep;?>" />
		</label>
		<label>
			Bairro<br />
			<?php $bai = isset($vet_end['bairro']) ? $bai = $vet_end['bairro'] : $bai = ""; ?>
			<input type="text" name="txt_bairro" value="<?=$bai;?>" />
		</label>
		<label>
			Logradouro<br />
			<?php $log = isset($vet_end['logradouro']) ? $log = $vet_end['logradouro'] : $log = ""; ?>
			<input type="text" name="txt_logradouro" value="<?=$log;?>" />
		</label>
		<label>
			Número<br />
			<?php $num = isset($vet_end['numero']) ? $num = $vet_end['numero'] : $num = ""; ?>
			<input type="text" name="txt_numero" value="<?=$num;?>" />
		</label>
		<label>
			Complemento<br />
			<?php $com = isset($vet_end['complemento']) ? $com = $vet_end['complemento'] : $com = ""; ?>
			<input type="text" name="txt_complemento" value="<?=$com;?>" />
		</label>
	</form>
</body>
</html>