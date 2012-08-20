<?php 
	include "../inicializa.php";

	$cod_tip_mat = $_POST['cod_tip'];

	$sql = "SELECT * FROM ref_materiais WHERE cod_tip_mat = '$cod_tip_mat' ORDER BY valor ASC";
	$query = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($query) == 0)
		echo '<option value="0">Escolha o tipo.</option>';
	else
	{
		while($tip_mat = mysql_fetch_array($query))
			echo '<option value="' . $tip_mat['cod'] . '">' . $tip_mat['valor'] . '</option>';
	}
?>