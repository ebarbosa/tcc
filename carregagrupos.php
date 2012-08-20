<?php
	include "../inicializa.php";

	$cod = $_POST['txt_cod'];
	$sql = "SELECT cod_gru FROM usuarios WHERE cod = '$cod';";
	$query = mysql_query($sql) or die(mysql_error());
	$cod_gru = mysql_result($query, 0);

	$tipo_usuario = $_POST['slt_tipo_usuario'];
	$sql = "SELECT * FROM grupos WHERE cod_ent = '$tipo_usuario' ORDER BY nome ASC";
	$query = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($query) == 0)
		echo '<option value="0">---</option>';
	else
	{
		echo '<option value="0">---</option>';
		while($grupo = mysql_fetch_assoc($query))
		{
			if($cod_gru == $grupo['cod'])
				$selected = "selected";
			else
				$selected = "";

			echo '<option value="' . $grupo['cod'] . '"' . $selected . '>' . $grupo['nome'] . '</option>';
		}
	}
?>