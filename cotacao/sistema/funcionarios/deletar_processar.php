<?php
//Recebe ID do funcionário
$id = (int)$_GET['id'];


//Marca funcionário como deletado
$sql = $mysql->query("UPDATE funcionarios SET deletado = 's' WHERE id = $id");
                    
                    
//Redireciona para página de listagem
header('Location: '.HOST_URL.'/funcionarios/listar?status=255');
exit(0);
