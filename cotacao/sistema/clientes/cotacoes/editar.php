<?php
//Verifica permissões de acesso a página
if (!preg_match("/e/i", $permissoes_clientes)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Recebe o id
$id = $_GET['id'];


//Dados da cotacao
$cotacao = $mysql->getRow("SELECT id, cliente_id, validade, entrega, pagamento, impostos FROM cotacoes WHERE numero = '$id'");

//Itens
$itens = $mysql->getRows("SELECT item, descricao, quantidade, unidade, preco_unitario, preco_total
                        FROM cotacoes_itens WHERE cotacao_id = $cotacao[id]");

//Pega os dados
$cliente = $mysql->getRow("SELECT nome FROM clientes WHERE id = $cotacao[cliente_id]");


//Inclui topo do site
topo();


?>
<h1>
    <a href="<?php echo HOST_URL ?>/clientes/listar">Clientes</a> » 
    <a href="<?php echo HOST_URL ?>/clientes/cotacoes/listar?id=<?php echo $cotacao['id'] ?>">Cotações</a> » Editar
</h1>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        
        <!-- form start -->
        <form method="post" action="./editar_processar?id=<?php echo $id ?>">


        <input type="hidden" name="cliente_id" value="<?php echo $cotacao['cliente_id'] ?>" /> 

        <!-- left column -->
        <div class="col-md-12">
                
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Cliente:
                    <a href="<?php echo HOST_URL ?>/clientes/editar?id=<?php echo $id ?>"
                    target="_blank" style="color: #3c8dbc;"><?php echo $cliente['nome'] ?></a></h3>
                </div>
                <div class="box-body">                
                    
                    <div class="row">
                        <div class="col-xs-3">
                            <label for="validade">* Validade</label>
                            <input type="text" name="validade" class="form-control" required
                            value="<?php echo $cotacao['validade'] ?>" />
                        </div>
                        <div class="col-xs-3">
                            <label for="pagamento">* Condições de Pagamento</label>
                            <input type="text" name="pagamento" class="form-control" required
                            value="<?php echo $cotacao['pagamento'] ?>" />
                        </div>
                        <div class="col-xs-3">
                            <label for="impostos">* Impostos</label>
                            <input type="text" name="impostos" class="form-control" required
                            value="<?php echo $cotacao['impostos'] ?>" />
                        </div>
                        <div class="col-xs-3">
                            <label for="entrega">* Prazo de Entrega</label>
                            <input type="text" name="entrega" class="form-control" required
                            value="<?php echo $cotacao['entrega'] ?>" />
                        </div>
                    </div>
                    
                </div><!-- /.box-body -->                    
            </div><!-- /.box -->

            
        </div><!--/.col (right) -->  
        

        <!-- left column -->
        <div class="col-md-12">
                
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Cliente:
                    <a href="<?php echo HOST_URL ?>/clientes/editar?id=<?php echo $id ?>"
                    target="_blank" style="color: #3c8dbc;"><?php echo $cliente['nome'] ?></a></h3>
                </div>
                <div class="box-body">                
                    
                    <div class="row">
                        <div class="col-xs-2">
                            <label for="item">* Item</label>
                        </div>
                        <div class="col-xs-4">
                            <label for="descricao">* Descrição</label>
                        </div>
                        <div class="col-xs-1">
                            <label for="quantidade">* Qde.</label>
                        </div>
                        <div class="col-xs-1">
                            <label for="unidade">* Unid.</label>
                        </div>
                        <div class="col-xs-2">
                            <label for="preco_unitario">* Preço Unitário</label>
                        </div>
                        <div class="col-xs-2">
                            <label for="preco_total">* Preço Total</label>
                        </div>
                    </div>

                    <?php
                    foreach($itens as $key => $item):
                    
                    if($key==0) $required = 'required';
                    else $required = '';
                    ?>
                    <div class="row">
                        <div class="col-xs-2">
                            <input type="text" name="item[]" class="form-control col-xs-3" <?php echo $required ?>
                            value="<?php echo $item['item'] ?>" />
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="descricao[]" class="form-control col-xs-3" <?php echo $required ?>
                            value="<?php echo $item['descricao'] ?>" />
                        </div>
                        <div class="col-xs-1">
                            <input type="text" name="quantidade[]" class="form-control col-xs-3" <?php echo $required ?>
                            value="<?php echo $item['quantidade'] ?>" />
                        </div>
                        <div class="col-xs-1">
                            <input type="text" name="unidade[]" class="form-control col-xs-3" <?php echo $required ?>
                            value="<?php echo $item['unidade'] ?>" />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="preco_unitario[]" class="form-control col-xs-3 mascara_moeda" <?php echo $required ?>
                            value="<?php echo $item['preco_unitario'] ?>" />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="preco_total[]" class="form-control col-xs-3 mascara_moeda" <?php echo $required ?>
                            value="<?php echo $item['preco_total'] ?>" />
                        </div>
                    </div>
                    <br />
                    <?php endforeach; ?>


                    <?php for($i=0;$i<=5;++$i): ?>
                    <div class="row">
                        <div class="col-xs-2">
                            <input type="text" name="item[]" class="form-control col-xs-3" />
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="descricao[]" class="form-control col-xs-3" />
                        </div>
                        <div class="col-xs-1">
                            <input type="text" name="quantidade[]" class="form-control col-xs-3" />
                        </div>
                        <div class="col-xs-1">
                            <input type="text" name="unidade[]" class="form-control col-xs-3" />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="preco_unitario[]" class="form-control col-xs-3 mascara_moeda" />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="preco_total[]" class="form-control col-xs-3 mascara_moeda" />
                        </div>
                    </div>
                    <br />
                    <?php endfor; ?>

                    <span id="box_row"></span>

                    <br />

                    <a id="add_row" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar linha</a>
                    
                </div><!-- /.box-body -->                    
            </div><!-- /.box -->

            
        </div><!--/.col (right) -->       
        
        
    </div><!-- /.row -->
        
        
        
        
        
    <div class="row">   
        <!-- left column -->
        <div class="col-md-6">
        	<button type="submit" class="btn btn-primary">Salvar</button>
        </div><!--/.col (right) -->
    </div>
    
    
    
    
    
                        
	</form>


<?php
//Inclui rodapé do site
rodape();
?>


<script type="text/javascript">
$('#add_row').bind('click', function()
{

    var row = '<div class="row"><div class="col-xs-2">';
    row += '<input type="text" name="item[]" class="form-control col-xs-3" />';
    row += '</div>';

    row += '<div class="col-xs-4">';
    row += '<input type="text" name="descricao[]" class="form-control col-xs-3" />';
    row += '</div>';

    row += '<div class="col-xs-1">';
    row += '<input type="text" name="quantidade[]" class="form-control col-xs-3" />';
    row += '</div>';

    row += '<div class="col-xs-1">';
    row += '<input type="text" name="unidade[]" class="form-control col-xs-3" />';
    row += '</div>';

    row += '<div class="col-xs-2">';
    row += '<input type="text" name="preco_unitario[]" class="form-control col-xs-3 mascara_moeda" />';
    row += '</div>';

    row += '<div class="col-xs-2">';
    row += '<input type="text" name="preco_total[]" class="form-control col-xs-3 mascara_moeda" />';
    row += '</div></div><br />';

    $('#box_row').append(row);
    
    $(".mascara_moeda").maskMoney({showSymbol:false, symbol:"R$", decimal:".", thousands:""});
});
</script>