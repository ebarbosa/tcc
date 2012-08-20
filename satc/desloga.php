<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Processando...</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<?php
		session_start();

		unset($_SESSION['logado']);
		unset($_SESSION['codigo_usuario']);
		unset($_SESSION['nome_usuario']);
		unset($_SESSION['grupo_usuario']);

		session_destroy();

		header("Location: ../index.php");
	?>
</body>
</html>