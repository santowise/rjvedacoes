<?php
//Configurações
require_once "../../../config.php";

//ID do cliente
$id = (int)$_GET['id'];

//Colunas
$aColumns = array('c.numero','l.nome',"DATE_FORMAT(c.cadastro, '%d-%m-%Y')");
//Chave principal
$sIndexColumn = 'c.id';
//Tabelas
$sTable = 'cotacoes c, clientes l';
//Consições
$sWhere = "WHERE c.cliente_id = $id AND l.id = $id";


//Dados para conexão com o banco
$gaSql['db']       = DB_NAME;
$gaSql['user']     = DB_USER;
$gaSql['server']   = DB_HOST;
$gaSql['password'] = DB_PASS;


//DataTable Server Side
require_once "../../datatable.ajax.php";