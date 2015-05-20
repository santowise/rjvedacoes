<?php
header('Content-type: text/html; charset=UTF-8');

require_once '../../../config.php';

$mysql = new MySQL;

//Número da cotação
$id = $_GET['id'];

//Dados da cotacao
$cotacao = $mysql->getRow("SELECT
								id,
								numero,
								entrega,
								validade,
								impostos,
								pagamento,
								cliente_id,
								DATE_FORMAT(cadastro, '%d/%m/%Y') AS data_br
							FROM
								cotacoes
							WHERE
								numero = '$id'");

//Itens
$itens = $mysql->getRows("SELECT item, descricao, quantidade, unidade, preco_unitario, preco_total
                        FROM cotacoes_itens WHERE cotacao_id = $cotacao[id]");

//Pega os dados
$cliente = $mysql->getRow("SELECT nome, contato FROM clientes WHERE id = $cotacao[cliente_id]");


//HTML dos itens
$total = 0;
$html_itens = '';

foreach ($itens as $item)
{
	$html_itens .= '<tr>
						<td>'.$item['item'].'</td>
						<td>'.$item['descricao'].'</td>
						<td>'.$item['quantidade'].'</td>
						<td>'.$item['unidade'].'</td>
						<td>R$'.$item['preco_unitario'].'</td>
						<td>R$'.number_format($item['preco_total'],2,',','.').'</td>
					</tr>';
	$total += $item['preco_total'];
}


//Cria o html
$html = '
<style>
* { font-family: "Arial", "sans-serif" }
p { line-height: 8px; }
.hr { color: #c2c2c2; background-color: #c2c2c2; height: 1px; width: 100%; }
.itens th, .itens td { border: 1px solid #c2c2c2; padding: 5px 2px; text-align: center; }
</style>

<div style="width:100%;">
	<table style="width:100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" width="70%">
				<img src="'.HOST_PATH.'/img/logo-pdf.png" style="align:left" />
			</td>
			<td valign="top" width="30%">
				<div>
					<p>Cotação de Material: '.$cotacao['numero'].'</p>	
					<p>Data: '.$cotacao['data_br'].'</p>
				</div>
			</td>
		</tr>		
	</table>	
	
	<div class="hr" style="margin-top:12px"></div>
	<div style="padding: 8px 0;">Rua do Bonfim, 350 - São Cristóvão - Rio de Janeiro - RJ - CEP 20930-450</div>

	<table style="width:100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" width="50%">
				<div>
					<p>Tel.: (21) 3860-7805</p>	
					<p>E-mail: rj.vedacoes@outlook.com</p>
				</div>
			</td>
			<td valign="top" width="50%">
				<div>
					<p>CNPJ: 21.297.748/0001-78</p>	
					<p>Insc. Est.: 86.869.853</p>				
				</div>
			</td>
		</tr>		
	</table>

	<div class="hr" style="margin-bottom:5px"></div>

	<table style="width:100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" width="50%">
				<div>
					<p>Cliente: '.$cliente['nome'].'</p>
					<p>Contato: '.$cliente['contato'].'</p>	
				</div>
			</td>
			<td valign="top" width="50%">
				<div>
					<p>Validade da Proposta: '.$cotacao['validade'].'</p>
					<p>Condições de Pagamento: '.$cotacao['pagamento'].'</p>
					<p>Impostos: '.$cotacao['impostos'].'</p>		
					<p>Prazo de Entrega: '.$cotacao['entrega'].'</p>					
				</div>
			</td>
		</tr>		
	</table>

	<div class="hr"></div>
	<br />
</div>

<div class="itens">
<table style="width:100%; border-collapse: collapse" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th width="18%">Item</th>
			<th width="30%">Descrição</th>
			<th width="10%">Qde.</th>
			<th width="10%">Unid.</th>
			<th width="16%">Preço Unitário</th>
			<th width="16%">Preço Total</th>
		</tr>
	</thead>
	<tbody>
		'.$html_itens.'
		<tr>
			<th colspan="4"></th>
			<th colspan="2">Total: R$'.number_format($total,2,',','.').'</th>
		</tr>
	</tbody>
</table>
</div>';


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
    'rj-vedacoes-cotacao-num-'.$cotacao['numero'].'.pdf', /* Nome do arquivo de saída */
    array(
        "Attachment" => true /* Para download, altere para true */
    )
);

exit(0);