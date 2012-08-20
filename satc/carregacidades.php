<?php 
	include "../inicializa.php";

	$cod_est = $_POST['cod_est'];

	$sql = "SELECT * FROM ref_cidades WHERE cod_est = '$cod_est' ORDER BY valor ASC";
	$query = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($query) == 0)
		echo '<option value="0">Escolha o estado.</option>';
	else
	{
		while($cid_est = mysql_fetch_array($query))
			echo '<option value="' . $cid_est['cod'] . '">' . $cid_est['valor'] . '</option>';
	}
?>