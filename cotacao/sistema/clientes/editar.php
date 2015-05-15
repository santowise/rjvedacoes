<?php
//Verifica permissões de acesso a página
if (!preg_match("/e/i", $permissoes_clientes)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Recebe o id
$id = (int)$_GET['id'];


//Pega os dados
$cliente = $mysql->getRow("SELECT * FROM clientes WHERE id = $id");


//Inclui topo do site
topo();


?>
<h1>
    <a href="<?php echo HOST_URL ?>/clientes/listar">Clientes</a> » Editar
</h1>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        
        <!-- form start -->
        <form method="post" action="./editar_processar?id=<?php echo $id ?>">
        
        
        
        
        
                
        <!-- left column -->
        <div class="col-md-6">
                
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-body">
                
                    <div class="form-group">
                        <label for="nome">* Nome (empresa)</label>
                        <input type="text" name="nome" class="form-control" required
                        value="<?php echo $cliente['nome'] ?>" />
                    </div>
                
                    <div class="form-group">
                        <label for="contato">Contato (nome da pessoa)</label>
                        <input type="text" name="contato" class="form-control"
                        value="<?php echo $cliente['contato'] ?>" />
                    </div>
                
                    <div class="form-group">
                        <label for="email">* E-mail</label>
                        <input type="text" name="email" class="form-control" required
                        value="<?php echo $cliente['email'] ?>" />
                    </div>
                
                    <div class="form-group">
                        <label for="telefone_1">Telefone (1)</label>
                        <input type="text" name="telefone_1" class="form-control"
                        value="<?php echo $cliente['telefone_1'] ?>" />
                    </div>
                
                    <div class="form-group">
                        <label for="telefone_2">Telefone (2)</label>
                        <input type="text" name="telefone_2" class="form-control"
                        value="<?php echo $cliente['telefone_2'] ?>" />
                    </div>
                    
                </div><!-- /.box-body -->                    
            </div><!-- /.box -->
            
        </div><!--/.col (right) -->
        
        
        <!-- left column -->
        <div class="col-md-6">
        
            <!-- general form elements disabled -->
            <div class="box box-primary">
                
                <div class="box-body">

                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea name="observacoes" class="wysihtml5"
                        style="width: 100%; height: 240px; font-size: 14px;
                        line-height: 18px; border: 1px solid #ddd; padding: 10px;"
                        ><?php echo $cliente['observacoes'] ?></textarea>
                    </div>
                        
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
$(document).ready(function(){
	var left = 44 - $('#meta_title').val().length;	
    $('#counter_meta_title').text('Restam: ' + left);

	var left = 160 - $('#meta_description').val().length;	
    $('#counter_meta_description').text('Restam: ' + left);
});

$('#meta_title').keyup(function () {
    var left = 44 - $(this).val().length;
    if (left < 0) {
        left = 0;
    }
    $('#counter_meta_title').text('Restam: ' + left);
});


$('#meta_description').keyup(function () {
    var left = 160 - $(this).val().length;
    if (left < 0) {
        left = 0;
    }
    $('#counter_meta_description').text('Restam: ' + left);
});
</script>