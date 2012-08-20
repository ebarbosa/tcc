<?php include "../inicializa.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SATC - Usuários</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<p>Usuários&nbsp;<a href="index.php">Voltar</a></p>
	<hr />
	<p>
		<?php
			$sql = "select * from usuarios;";
			$query = mysql_query($sql) or die(mysql_error());
		?>
		<table border="1">
			<tr>
				<th></th>
				<th></th>
				<th>Tipo de Usuário</th>
				<th>CPF</th>
				<th>Nome</th>
				<th>Grupo</th>
			</tr>
			<?php while($usuario = mysql_fetch_array($query)) { ?>
			<tr>
				<td><a href="mantemusuario.php?op=1&cod=<?=$usuario['cod'];?>">Excluir</a></td>
				<td><a href="usuarios.php?op=3&cod=<?=$usuario['cod'];?>">Editar</a></td>
				<?php
					switch($usuario['cod_ent'])
					{
						case 1:
							$tipo_usuario = "Produtor";
							break;
						case 2:
							$tipo_usuario = "Transportador";
							break;
						case 3:
							$tipo_usuario = "Administrador";
							break;
					}
				?>
				<td><?=$tipo_usuario;?></td>
				<td><?=$usuario['cpf'];?></td>
				<td><?=$usuario['nome'];?></td>
				<?php
					$sql_usuario_grupo = "select nome from grupos where cod = " . $usuario['cod_gru'] . ";";
					$query_usuario_grupo = mysql_query($sql_usuario_grupo) or die(mysql_error());
					$usuario_grupo = mysql_result($query_usuario_grupo, 0);
				?>
				<td><?=$usuario_grupo;?></td>
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

				$sql = "select * from usuarios where cod = $cod;";
				$query = mysql_query($sql) or die(mysql_error());
				$usuario = mysql_fetch_array($query);
			}					
			else 
				$op = 2;
		?>
		<form name="frm_usuarios" method="post" action="mantemusuario.php?op=<?=$op;?>">
			<input type="hidden" name="pagina" value="usuarios.php" />
			<input type="submit" value="Inserir" /><p />
			<?php $cod = isset($usuario['cod']) ? $cod = $usuario['cod'] : $cod = ""; ?>
			<input type="hidden" name="txt_cod" value="<?=$cod;?>" />
			Tipo de Usuário:<br />
			<?php $tipo_usuario = isset($usuario['cod_ent']) ? $tipo_usuario = $usuario['cod_ent'] : $tipo_usuario = ""; ?>
			<select name="slt_tipo_usuario">
				<option value="0">---</option>
				<option value="1" <?php if($tipo_usuario == 1) echo "selected";?>>Produtor</option>
				<option value="2" <?php if($tipo_usuario == 2) echo "selected";?>>Transportador</option>
				<option value="3" <?php if($tipo_usuario == 3) echo "selected";?>>Administrador</option>
			</select><br />
			Grupo:<br />
			<select name="slt_grupo">					
				<option value="0">---</option>
				<?php
					$sql = "select * from grupos;";
					$query = mysql_query($sql) or die(mysql_error());

					while($grupo = mysql_fetch_array($query))
					{	
						if($usuario['cod_gru'] == $grupo['cod'])
							$selecionado = "selected";
						else
							$selecionado = "";

						//$selecionado = isset($usuario['cod_gru']) ? $selecionado = "selected" : $selecionado = "";
						echo "<option value=" . $grupo['cod'] . " " . $selecionado . ">" . $grupo['nome'] . "</option>";
					}
				?>
			</select><br />
			Nome:<br />
			<?php $nome = isset($usuario['nome']) ? $nome = $usuario['nome'] : $nome = ""; ?>
			<input type="text" name="txt_nome" value="<?=$nome;?>" /><br />
			CPF:<br />
			<?php $cpf = isset($usuario['cpf']) ? $cpf = $usuario['cpf'] : $cpf = ""; ?>
			<input type="text" name="txt_cpf" value="<?=$cpf;?>" /><br />
			RG:<br />
			<?php $rg = isset($usuario['rg']) ? $rg = $usuario['rg'] : $rg = ""; ?>
			<input type="text" name="txt_rg" value="<?=$rg;?>" /><br />
			E-mail:<br />
			<?php $email = isset($usuario['email']) ? $email = $usuario['email'] : $email = ""; ?>
			<input type="text" name="txt_email" value="<?=$email;?>" /><br />
			Senha:<br />
			<?php $senha = isset($usuario['senha']) ? $senha = $usuario['senha'] : $senha = ""; ?>
			<input type="text" name="txt_senha" value="<?=$senha;?>" />
		</form>
	</p>
</body>
</html>