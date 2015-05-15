<?php
//Recebe o id do registro
$id = (int)$_GET['id'];


//Prepara alguns dados
unset($_POST['_wysihtml5_mode']);


/**
 * Atualiza os dados
 **/
$mysql->update($_POST,'clientes',"id = $id");

 
//Grava as editoras
if(isset($_POST['editoras']))
{
	foreach($_POST['editoras'] as $editora)
	{
		if(!empty($editora))
		{
			$mysql->query("INSERT INTO produtos_editoras
								(produto_id,
								 editora_id)
							VALUES
								($id,
								 '$editora')");
		}
	}
}


//Redireciona a página
header("Location: ./listar?status=255");
exit;