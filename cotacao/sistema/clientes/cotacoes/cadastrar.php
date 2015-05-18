<?php
//Verifica permissões de acesso a página
if (!preg_match("/i/i", $permissoes_clientes)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Inclui topo do site
topo();


//Id do cliente
$id = (int)$_GET['id'];


//Dados do cliente
$cliente = $mysql->getRow("SELECT nome FROM clientes WHERE id = $id");


?>
<h1>
    <a href="<?php echo HOST_URL ?>/clientes/listar">Clientes</a> » 
    <a href="<?php echo HOST_URL ?>/clientes/cotacoes/listar?id=<?php echo $id ?>">Cotações</a> » Cadastrar
</h1>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        
        <!-- form start -->
        <form method="post" action="./cadastrar_processar">       

        <input type="hidden" name="cliente_id" value="<?php echo $id ?>" />

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
                    for($i=0;$i<=5;++$i):
                    
                    if($i==0) $required = 'required';
                    else $required = '';
                    ?>
                    <div class="row">
                        <div class="col-xs-2">
                            <input type="text" name="item[]" class="form-control col-xs-3" <?php echo $required ?> />
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="descricao[]" class="form-control col-xs-3" <?php echo $required ?> />
                        </div>
                        <div class="col-xs-1">
                            <input type="text" name="quantidade[]" class="form-control col-xs-3" <?php echo $required ?> />
                        </div>
                        <div class="col-xs-1">
                            <input type="text" name="unidade[]" class="form-control col-xs-3" <?php echo $required ?> />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="preco_unitario[]" class="form-control col-xs-3 mascara_moeda" <?php echo $required ?> />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="preco_total[]" class="form-control col-xs-3 mascara_moeda" <?php echo $required ?> />
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
        <div class="col-md-12">
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