<?php
//Verifica permissões de acesso a página
if (!preg_match("/e/i", $permissoes_funcionarios)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Recebe o id do funcionário
$id = (int)$_GET['id'];


//Pega dados do funcionário
$dados = $mysql->getRow("SELECT
							 *                                         
						 FROM 
							 funcionarios
							 
						 WHERE
							 id = $id");


//Separa dados em variáveis especificas
$nome     = $dados['nome'];
$email    = $dados['email'];
$deletado = $dados['deletado'];


//Inclui topo do site
topo();


?>
<h1>
    <a href="<?php echo HOST_URL ?>/funcionarios/listar">Funcionários</a> » Editar
</h1>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        
	<form method="post" action="./editar_processar?id=<?php echo $id ?>">
                
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box">
                <div class="box-header">
                    <h3 class="box-title">Dados do Funcionário</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" class="form-control"
                            placeholder="Informe o nome" value="<?php echo $nome ?>"
                            required />
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" class="form-control"
                            placeholder="Insira o e-mail" value="<?php echo $email ?>"
                            required />
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" class="form-control"
                            placeholder="Deixe em branco para não trocar" autocomplete="off" />
                        </div>
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (right) -->
        
        
        <!-- right column -->
        <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="box box">
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
                        value="v" class="minimal-orange"
                        <?php if(preg_match("/v/i", $dados['permissoes_' . $name])) echo 'checked' ?> />
                        Visualizar
                        
                        <input type="checkbox" name="p_<?php echo $name ?>[]"
                        value="e" class="minimal-orange"
                        <?php if(preg_match("/e/i", $dados['permissoes_' . $name])) echo 'checked' ?> /> Editar
                        
                        <input type="checkbox" name="p_<?php echo $name ?>[]"
                        value="i" class="minimal-orange"
                        <?php if(preg_match("/i/i", $dados['permissoes_' . $name])) echo 'checked' ?> /> Cadastrar
                        
                        <input type="checkbox" name="p_<?php echo $name ?>[]"
                        value="d" class="minimal-orange"
                        <?php if(preg_match("/d/i", $dados['permissoes_' . $name])) echo 'checked' ?> /> Deletar
                    </div>
                    
                    <?php endforeach; ?>
                        
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            
            <!-- general form elements disabled -->
            <div class="box box">
                <div class="box-header">
                    <h3 class="box-title">Opções</h3>
                </div><!-- /.box-header -->
                <div class="box-body">     	
                    <div class="form-group">
                        <input type="checkbox" name="deletado" value="s" class="minimal-orange"
                        <?php if($deletado == 's') echo 'checked' ?> /> Deletado
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