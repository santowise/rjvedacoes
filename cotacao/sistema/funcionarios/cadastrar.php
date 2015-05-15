<?php
//Verifica permissões de acesso a página
if (!preg_match("/i/i", $permissoes_funcionarios)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Inclui topo do site
topo();


?>
<h1>
    <a href="<?php echo HOST_URL ?>/funcionarios/listar">Funcionários</a> » Cadastrar
</h1>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        
        <form method="post" action="./cadastrar_processar">
                
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Dados do Funcionário</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">* Nome</label>
                            <input type="text" name="nome" class="form-control"
                            placeholder="Informe o nome" required />
                        </div>
                        <div class="form-group">
                            <label for="email">* E-mail</label>
                            <input type="email" name="email" class="form-control"
                            placeholder="Insira o e-mail" required />
                        </div>
                        <div class="form-group">
                            <label for="senha">* Senha</label>
                            <input type="password" name="senha" class="form-control"
                            placeholder="Mínimo de 8 caracteres" autocomplete="off" required minlength="8" />
                        </div>
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (right) -->
        
        
        <!-- right column -->
        <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Permissões de Acesso</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    
                    	<?php
						$perms = array('Funcionários' => 'funcionarios');
						
						
						foreach($perms as $label => $name):
						?>                    	
                        
                        <label for="p_<?php echo $name ?>"><?php echo $label ?></label>
                        <div class="form-group">
                            <input type="checkbox" name="p_<?php echo $name ?>[]"
                            value="v" class="minimal-orange" checked> Visualizar
                            
                            <input type="checkbox" name="p_<?php echo $name ?>[]"
                            value="e" class="minimal-orange" checked> Editar
                            
                            <input type="checkbox" name="p_<?php echo $name ?>[]"
                            value="i" class="minimal-orange" checked> Cadastrar
                            
                            <input type="checkbox" name="p_<?php echo $name ?>[]"
                            value="d" class="minimal-orange" checked> Deletar
                        </div>
                        
                        <?php endforeach; ?>
                        
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