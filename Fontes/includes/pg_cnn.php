<?php
	require_once("db/adodb5/adodb.inc.php");
	$c = ADONewConnection("postgres");
	$c->PConnect("host=127.0.0.1 port=5432 dbname=tcc user=postgres password=senha123") or die ("Erro na conexão!!");	
?>