<?php
//Recebe o id
$id = (int)$_GET['id'];


//Apaga o registro
$sql = $mysql->query("DELETE FROM clientes WHERE id = $id");
                    
                    
//Redireciona para página de listagem
header('Location: '.HOST_URL.'/clientes/listar?status=255');
exit(0);
