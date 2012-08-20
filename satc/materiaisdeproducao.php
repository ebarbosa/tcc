<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Materiais de Produção</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/tipomaterial.js"></script>
</head>
<body>
	<p>Materiais de Produção&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<?php
		$cod_pro = $_SESSION['codigo_usuario'];

		$sql = "SELECT cod, cod_end FROM produtores_locais_producao
				WHERE cod_pro = '$cod_pro' AND 
					  status in (1, 2);";
		$qry = mysql_query($sql) or die(mysql_error());
	?>
	<table border="1">
		<tr>
			<th></th>
			<th></th>
			<th>Local de Produção</th>
			<th>Tipo</th>
			<th>Material</th>
		</tr>
		<?php 
			while($vet_loc_pro = mysql_fetch_array($qry)) 
			{
				$cod_loc_pro = $vet_loc_pro['cod'];
				$sql_mat = "SELECT * FROM locais_producao_materiais
								WHERE cod_loc_pro = '$cod_loc_pro';";
				$qry_mat = mysql_query($sql_mat) or die(mysql_error());

				while($vet_mat = mysql_fetch_array($qry_mat))
				{
					$cod_end = $vet_loc_pro['cod_end'];
					$sql_end_loc_pro = "SELECT logradouro, cod_est, cod_cid FROM enderecos
										WHERE cod = '$cod_end';";
					$qry_end_loc_pro = mysql_query($sql_end_loc_pro) or die(mysql_error());
					$vet_end_loc_pro = mysql_fetch_array($qry_end_loc_pro);
					$nom_log = $vet_end_loc_pro[0];

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

					$end_con = $nom_log . ", " . $nom_cid . "/" . $nom_est;

					$tip_mat = $vet_mat['cod_tip_mat'];
					$sql_tip_mat = "SELECT valor FROM ref_tipos_material
							WHERE cod = '$tip_mat';";
					$qry_tip_mat = mysql_query($sql_tip_mat);
					$nom_tip_mat = mysql_result($qry_tip_mat, 0);

					$cod_mat = $vet_mat['cod_mat'];
					$sql_cod_mat = "SELECT valor FROM ref_materiais
							WHERE cod = '$cod_mat';";
					$qry_cod_mat = mysql_query($sql_cod_mat);
					$nom_mat = mysql_result($qry_cod_mat, 0);
		?>
		<tr>
			<td><a href="mantemmaterialdeproducao.php?op=1&cod=<?=$vet_mat['cod'];?>">Excluir</a></td>
			<td><a href="materiaisdeproducao.php?op=3&cod=<?=$vet_mat['cod'];?>">Editar</a></td>
			<td><?=$end_con;?></td>
			<td><?=$nom_tip_mat;?></td>
			<td><?=$nom_mat;?></td>
		</tr>
		<?php }} ?>
	</table>
	<hr />
	<?php
		if(isset($_GET['cod']))
		{
			if(isset($_GET['op']) && isset($_GET['op']) == 3)
			{
				$op = $_GET['op'];
				$cod = $_GET['cod'];

				$sql = "SELECT * FROM locais_producao_materiais
						WHERE cod = '$cod';";
				$qry = mysql_query($sql) or die(mysql_error());
				$mat = mysql_fetch_array($qry);
			}
		}					
		else 
			$op = 2;
	?>
	<form name="frm_material_producao" method="post" action="mantemmaterialdeproducao.php?op=<?=$op;?>">
		<p><input type="submit" value="Inserir" /></p>
		<input type="hidden" name="txt_cod" value="<?=$mat['cod'];?>" />
		Local de Produção<br />
		<select name="slt_local_producao">
			<?php
				$sql = "select cod, cod_end from produtores_locais_producao where cod_pro = '$cod_pro' and status in (1, 2);";
				$query = mysql_query($sql) or die(mysql_error());

				echo "<option value='0'>---</option>";
				while($pro_loc_pro = mysql_fetch_array($query)) 
				{
					$cod_endereco = $pro_loc_pro['cod_end'];
					$sql_end_loc_pro = "select logradouro, cod_est, cod_cid from enderecos where cod = '$cod_endereco';";
					$query_end_loc_pro = mysql_query($sql_end_loc_pro) or die(mysql_error());
					$array_endereco = mysql_fetch_array($query_end_loc_pro);
					$selecionado = $pro_loc_pro[0] == $mat['cod_loc_pro'] ? $selecionado = "selected" : $selecionado = "";
					echo '<option value="' . $pro_loc_pro[0] . '" ' . $selecionado . '>' . $array_endereco[0] . ", " . $array_endereco[1] . "/" . $array_endereco[2] . '</option>';
				}
			?>
		</select><br />
		Tipo<br />
		<select name="slt_tipo">
			<?php
				$sql = "select * from ref_tipos_material;";
				$query = mysql_query($sql) or die(mysql_error());

				echo "<option value='0'>---</option>";
				while($ref_tip_mat = mysql_fetch_array($query))
				{
					$selecionado = $ref_tip_mat['cod'] == $mat['cod_tip_mat'] ? $selecionado = "selected" : $selecionado = "";
					echo '<option value="' . $ref_tip_mat['cod'] . '" ' . $selecionado . '>' . $ref_tip_mat['valor'] . '</option>';
				}
			?>
		</select><br />
		Material<br />
		<?php $mat_pro = isset($mat['cod_mat']) ? $mat_pro = $mat['cod_mat'] : $mat_pro = ""; ?>
		<input type="hidden" name="hdn_material" value="<?=$mat_pro;?>" />
		<select name="slt_material" disabled="disabled">
			<option value="0">Escolha o tipo.</option>
		</select><br />
	</form>
</body>
</html>