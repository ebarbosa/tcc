<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Cadastro</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="satc/css/config.css" />
</head>
<body>
	<?php
		$tip_usu = $_POST['slt_tipo_usuario'];
		$ema = $_POST['txt_email'];

		$usu = $tip_usu == 1 ? $usu = "Produtor" : $usu = "Transportador";
	?>
	<p>Cadastro de <?=$usu;?>&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<form name="frm_cadastro" method="post" action="cadastrausuario.php">
		<label>
			Tipo de usuário: <?=$usu;?><br />
			<input type="hidden" name="hdn_tipo_usuario" value="<?=$tip_usu;?>" />					
		</label>
		<label>
			E-mail<br />
			<input type="text" name="txt_email" value="<?=$ema;?>" />
		</label>
		<label>
			Nome completo<br />
			<input type="text" name="txt_nome" />
		</label>
		<label>
			CPF<br />
			<input type="text" name="txt_cpf" />
		</label>
		<label>
			RG<br />
			<input type="text" name="txt_rg" />
		</label>
		<?php if($tip_usu == 2) { ?>
			<label>
				CNH<br />
				<input type="text" name="txt_cnh" />
			</label>
		<?php } ?>
		<label>
			Senha<br />
			<input type="text" name="txt_senha" />
		</label>
		<label>
			Confirmação da Senha<br />
			<input type="text" name="txt_confirmacao_senha" />
		</label>
		<label>
			<input type="submit" value="Cadastrar" />
		</label>
	</form>
</body>
</html>