<?php
header('Content-type: text/html; charset=UTF-8');

require_once '../../../config.php';

$mysql = new MySQL;

//Número da cotação
$id = $_GET['id'];

//Dados da cotacao
$cotacao = $mysql->getRow("SELECT id, numero, cliente_id, DATE_FORMAT(cadastro, '%d/%m/%Y') AS data_br FROM cotacoes WHERE numero = '$id'");

//Itens
$itens = $mysql->getRows("SELECT item, descricao, quantidade, unidade, preco_unitario, preco_total
                        FROM cotacoes_itens WHERE cotacao_id = $cotacao[id]");

//Pega os dados
$cliente = $mysql->getRow("SELECT nome FROM clientes WHERE id = $cotacao[cliente_id]");


//Cria o html
$html = '
<style>
* { font-family: "Arial", "sans-serif" }
th, td { border: 1px solid #c2c2c2; padding: 8px; }
</style>

<div style="width:100%;">
	<img src="'.HOST_PATH.'/img/logo-pdf.png" style="align:left" />

	<hr />

	<div style="text-align:left; width:200px; float:left;">
		<p>Cotação de Material: '.$cotacao['numero'].'</p>
		<p>Data: '.$cotacao['data_br'].'</p>
		<p>Validade da Proposta: 15 dias</p>
		<p>Condições de Pagamento: 30DD</p>
		<p>Impostos Inclusos</p>
	</div>

	<div style="text-align:left; width:100px; float:right;">
		<p>CNPJ: 21.297.748/0001-78</p>
		<p>Insc. Est.: 86.869.853</p>
		<p>Tel.: (21) 3860-7805</p>
		<p>E-mail: rj.vedacoes@outlook.com</p>
		<p>Endereço: Rua do Bonfim, 350 - São Cristóvão - Rio de Janeiro - RJ - CEP 20930-450</p>
	</div>

	<br style="clear:both" />
	<hr />
	<br />
</div>

<table style="width:100%; border-collapse: collapse" cellpadding="0" cellspacing="0">
	<thead>
		<tr style="text-align:left">
			<th width="16%">Item</th>
			<th width="20%">Descrição</th>
			<th width="16%">Qde.</th>
			<th width="16%">Unid.</th>
			<th width="16%">Preço Unitário</th>
			<th width="16%">Preço Total</th>
		</tr>
	</thead>
	<tbody>
		<tr style="text-align:left">
			<td>Item</td>
			<td>Descrição</td>
			<td>Qde.</td>
			<td>Unid.</td>
			<td>Preço Unitário</td>
			<td>Preço Total</td>
		</tr>
	</tbody>
</table>';

/*echo $html;

exit;*/
/* Carrega a classe DOMPdf */
require_once(HOST_PATH.'/lib/dompdf/dompdf_config.inc.php');

/* Cria a instância */
$dompdf = new DOMPDF();

/* Carrega seu HTML */
$dompdf->load_html($html);

/* Renderiza */
$dompdf->render();

/* Exibe */
$dompdf->stream(
    "saida.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);