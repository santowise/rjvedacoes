<?php
//Configurações
require_once "../../config.php";


//Colunas
$aColumns = array('id','nome','contato','email','telefone_1','telefone_2');
//Chave principal
$sIndexColumn = 'id';
//Tabelas
$sTable = 'clientes';
//Consições
$sWhere = 'WHERE 1=1';


//Dados para conexão com o banco
$gaSql['db']       = DB_NAME;
$gaSql['user']     = DB_USER;
$gaSql['server']   = DB_HOST;
$gaSql['password'] = DB_PASS;


//DataTable Server Side
require_once "../datatable.ajax.php";