<?php
	include "../inicializa.php";
	
	$cod_cid = $_POST['cod_cid'];
	
	$sql = "SELECT cod_est, cod FROM ref_cidades WHERE cod = '$cod_cid'";
	$query = mysql_query($sql) or die(mysql_error());
	$dados_cidade = mysql_fetch_array($query);
	$cod_est = $dados_cidade['cod_est'];

	$sql = "SELECT * FROM ref_cidades WHERE cod_est = '$cod_est' ORDER BY valor ASC";
	$query = mysql_query($sql) or die(mysql_error());

	while($cid_est = mysql_fetch_array($query))
	{
		$selecionado = $cid_est['cod'] == $dados_cidade['cod'] ? $selecionado = "selected" : $selecionado = "";
		echo '<option value="' . $cid_est['cod'] . '" ' . $selecionado . '>' . $cid_est['valor'] . '</option>';
	}
?>