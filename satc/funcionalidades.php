<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Funcionalidades</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<p>Funcionalidades&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<p>
		<?php
			$sql = "select * from funcionalidades;";
			$query = mysql_query($sql) or die(mysql_error());
		?>
		<table border="1">
			<tr>
				<th></th>
				<th></th>
				<th>Funcionalidade</th>
				<th>Descrição</th>
				<th>Página</th>
			</tr>
			<?php while($funcionalidade = mysql_fetch_array($query)) { ?>
			<tr>
				<td><a href="mantemfuncionalidade.php?op=1&cod=<?=$funcionalidade['cod'];?>">Excluir</a></td>
				<td><a href="funcionalidades.php?op=3&cod=<?=$funcionalidade['cod'];?>">Editar</a></td>
				<td><?=$funcionalidade['nome'];?></td>
				<td><?=$funcionalidade['descricao'];?></td>
				<td><?=$funcionalidade['pagina'];?></td>
			</tr>
			<?php } ?>
		</table>
	</p>
	<hr />
	<p>
		<?php
			if(isset($_GET['op']) && isset($_GET['cod']))
			{
				$op = $_GET['op'];
				$cod = $_GET['cod'];

				$sql = "select * from funcionalidades where cod = $cod;";
				$query = mysql_query($sql) or die(mysql_error());
				$funcionalidade = mysql_fetch_array($query);
			}					
			else 
				$op = 2;
		?>
		<form name="frm_funcionalidades" method="post" action="mantemfuncionalidade.php?op=<?=$op;?>">
			<input type="submit" value="Inserir" /><p />
			<?php $cod = isset($funcionalidade['cod']) ? $cod = $funcionalidade['cod'] : $cod = ""; ?>
			<input type="hidden" name="txt_cod" value="<?=$cod;?>" />
			Funcionalidade:<br />
			<?php $nome = isset($funcionalidade['nome']) ? $nome = $funcionalidade['nome'] : $nome = ""; ?>
			<input type="text" name="txt_nome" value="<?=$nome;?>" /><br />
			Descrição:<br />
			<?php $descricao = isset($funcionalidade['descricao']) ? $descricao = $funcionalidade['descricao'] : $descricao = ""; ?>
			<input type="text" name="txt_descricao" value="<?=$descricao;?>" size="80" /><br />
			Página:<br />
			<?php $pagina = isset($funcionalidade['pagina']) ? $pagina = $funcionalidade['pagina'] : $pagina = ""; ?>
			<input type="text" name="txt_pagina" value="<?=$pagina;?>" /><br />
		</form>
	</p>
</body>
</html>