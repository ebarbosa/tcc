<?php
	session_start();

	$conexao = mysql_connect('localhost', 'root', 'root@123');
	mysql_set_charset("UTF8", $conexao);

	if(!$conexao)
		echo "Erro ao conectar ao banco de dados: " . mysql_error() . ".";
		
	$banco = mysql_select_db('satc');
	if(!$banco)
		echo "Erro selecionar o banco de dados: " . mysql_error() . ".";
?>