<?php
	include "../inicializa.php";
	
	$cod_mat = $_POST['cod_mat'];
	
	$sql = "SELECT cod_tip_mat, cod FROM ref_materiais WHERE cod = '$cod_mat'";
	$query = mysql_query($sql) or die(mysql_error());
	$dados_material = mysql_fetch_array($query);
	$cod_tip_mat = $dados_material['cod_tip_mat'];

	$sql = "SELECT * FROM ref_materiais WHERE cod_tip_mat = '$cod_tip_mat' ORDER BY valor ASC";
	$query = mysql_query($sql) or die(mysql_error());

	while($material = mysql_fetch_array($query))
	{
		$selecionado = $material['cod'] == $dados_material['cod'] ? $selecionado = "selected" : $selecionado = "";
		echo '<option value="' . $material['cod'] . '" ' . $selecionado . '>' . $material['valor'] . '</option>';
	}
?>