<?php
$id = (int)$_GET['id'];

//Apaga os itens para regravá-los
$mysql->query("DELETE FROM cotacoes_itens WHERE cotacao_id = $id");

//Salva os itens
foreach($_POST['item'] as $key => $item)
{
	if($item != '')
	{
		$item           = $mysql->real_escape_string($_POST['item'][$key]);
		$unidade        = $mysql->real_escape_string($_POST['unidade'][$key]);
		$descricao      = $mysql->real_escape_string($_POST['descricao'][$key]);
		$quantidade     = $mysql->real_escape_string($_POST['quantidade'][$key]);
		$preco_total    = $mysql->real_escape_string($_POST['preco_total'][$key]);
		$preco_unitario = $mysql->real_escape_string($_POST['preco_unitario'][$key]);

		$mysql->query("INSERT INTO cotacoes_itens
							(item,
							unidade,
							descricao,
							cotacao_id,
							quantidade,
							preco_total,
							preco_unitario)
						VALUES
							('$item',
							'$unidade',
							'$descricao',
							$id,
							'$quantidade',
							'$preco_total',
							'$preco_unitario')");
	}
}


//Redireciona a página
header("Location: ./listar?id=$_POST[cliente_id]&status=255");
exit;