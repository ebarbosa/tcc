<?php
	include 'inicializa.php';
	
	$tip_usuario = $_POST['hdn_tipo_usuario'];
	$grupo = $tip_usuario == 1 ? $grupo = 2 : $grupo = 3;
	$email = $_POST['txt_email'];
	$nome = $_POST['txt_nome'];
	$cpf = $_POST['txt_cpf'];
	$rg = $_POST['txt_rg'];
	$cnh = isset($_POST['txt_cnh']) ? $cnh = $_POST['txt_cnh'] : $cnh = NULL;
	$senha = $_POST['txt_senha'];

	$sql = "SELECT email from usuarios
			WHERE email = '$email';";
	$qry = mysql_query($sql);
	$num_reg = mysql_num_rows($qry);

	if($num_reg != 0)
		echo "O e-mail informado já está cadastrado.";
	else
	{
		$sql = "SELECT cpf FROM usuarios
				WHERE cpf = '$cpf';";
		$qry = mysql_query($sql);
		$num_reg = mysql_num_rows($qry);

		if($num_reg != 0)
			echo "O CPF informado já está cadastrado.";
		else
		{
			$num_reg = 0;

			if($cnh)
			{
				$sql = "SELECT cnh from usuarios
						WHERE cnh = '$cnh';";
				$qry = mysql_query($sql);
				$num_reg = mysql_num_rows($qry);
			}
			if($num_reg != 0)
				echo "A CNH informada já existe na base.";
			else
			{
				$sql = "INSERT INTO usuarios
						VALUES (
							NULL,
							'$tip_usuario',
							'$grupo',
							'$email',
							'$senha',
							'$nome',
							'$cpf',
							'$rg',
							'$cnh');";
				$qry = mysql_query($sql) or die(mysql_error());

				header("Location: index.php");
			}
		}
	}
?>