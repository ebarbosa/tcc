<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Grupos</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<p>Grupos&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<?php
		$sql = "select * from grupos;";
		$query = mysql_query($sql) or die(mysql_error());
	?>
	<p>
		<table border="1">
			<tr>
				<th></th>
				<th></th>
				<th>Grupo</th>
				<th>Descrição</th>
			</tr>
			<?php while($grupo = mysql_fetch_array($query)) { ?>
			<tr>
				<td><a href="mantemgrupo.php?op=1&cod=<?=$grupo['cod'];?>">Excluir</a></td>
				<td><a href="grupos.php?op=3&cod=<?=$grupo['cod'];?>">Editar</a></td>
				<td><?=$grupo['nome'];?></td>
				<td><?=$grupo['descricao'];?></td>
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

				$sql = "select * from grupos where cod = $cod;";
				$query = mysql_query($sql) or die(mysql_error());
				$grupo = mysql_fetch_array($query);
			}					
			else 
				$op = 2;
		?>
		<form name="frm_grupos" method="post" action="mantemgrupo.php?op=<?=$op;?>">
			<input type="submit" value="Inserir" /><br /><br />
			<?php $cod = isset($grupo['cod']) ? $cod = $grupo['cod'] : $cod = ""; ?>
			<input type="hidden" name="txt_cod" value="<?=$cod;?>" />
			Grupo:<br />
			<?php $nome = isset($grupo['nome']) ? $nome = $grupo['nome'] : $nome = ""; ?>
			<input type="text" name="txt_nome" value="<?=$nome;?>" /><br />
			Descrição:<br />
			<?php $descricao = isset($grupo['descricao']) ? $descricao = $grupo['descricao'] : $descricao = ""; ?>
			<input type="text" name="txt_descricao" value="<?=$descricao;?>" size="80" /><br /><br />
			<?php
				$sql = "select * from funcionalidades;";
				$query = mysql_query($sql) or die(mysql_error());

				while($funcionalidade = mysql_fetch_array($query))
				{
					$cod_fun = $funcionalidade['cod'];
					$sql_gp = "select * from grupos_funcionalidades where cod_gru = '$cod' and cod_fun = '$cod_fun'";
					$query_gp = mysql_query($sql_gp) or die(mysql_error());
					$fun_ativa = mysql_num_rows($query_gp) == 1 ? $fun_ativa = 1 : $fun_ativa = 0;
			?>
			<input type="checkbox" name="chk_<?=$cod_fun;?>" <?php if($fun_ativa == 1) echo "checked";?>/><?=$funcionalidade['nome']?><br />
			<?php } ?>
		</form>
	</p>
</body>
</html>