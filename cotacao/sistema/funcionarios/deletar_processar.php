<?php
//Recebe ID do funcion�rio
$id = (int)$_GET['id'];


//Marca funcion�rio como deletado
$sql = $mysql->query("UPDATE funcionarios SET deletado = 's' WHERE id = $id");
                    
                    
//Redireciona para p�gina de listagem
header('Location: '.HOST_URL.'/funcionarios/listar?status=255');
exit(0);
