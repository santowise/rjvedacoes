<?php
//Prepara alguns dados
unset($_POST['_wysihtml5_mode']);
$_POST['cadastro'] = utilidades::now();

/**
 * Salva os dados
 **/

//Salva os dados
$mysql->save($_POST,'clientes');


//Redireciona a página
header("Location: ./listar?status=255");
exit;