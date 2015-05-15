<?php
//Verifica permissões de acesso a página
if (!preg_match("/v/i", $permissoes_funcionarios)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Inclui topo do site
topo();


?>
<h1>
    <a href="<?php echo HOST_URL ?>/funcionarios/listar">Funcionários</a> » Listar
</h1>
</section>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover paginacao">
                        
                        <!-- // DataTable -->
                        
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            
        </div>
    </div>
    
    
<?php
//Inclui rodapé do site
rodape();
?>

<!-- page script -->
<script type="text/javascript">
$(document).ready(function()
{
	//ID de cada registro
	var id_reg;  //ID de cada registro retornado
	var reg_del; //Se o funcionario está marcado como deletado no banco
	
	
	$('.paginacao').dataTable(
	{		
		"bProcessing": true,
		"bServerSide": true,
		"bStateSave": true,
		
		
		"aoColumns": [
			
			// ID			
			{ 	
				"sTitle": "ID",
				"fnRender": function(obj)
				{
					var sReturn = obj.aData[ obj.iDataColumn ];
					
					//Pega o id do registro
					id_reg = sReturn;
					
					return sReturn;
				}
			},
			
			// Nome
			{ "sTitle": "Nome" },
			
			// E-mail
			{ "sTitle": "E-mail" },
			
			// Deletado
			{
				"sTitle": "Deletado",
				"fnRender": function(obj)
				{
					var sReturn = obj.aData[ obj.iDataColumn ];
					
					reg_del = sReturn;
					
					if ( sReturn == "s" )
					{
						sReturn = "<span class='label label-danger'>Deletado</span>";
					}
					else
					{
						sReturn = "";
					}
					
					return sReturn;
				}
			},			
			
			//Opções
			{
				"sTitle": "Opções",
				"mData" : null,
				"bSortable": false,
				"fnRender": function(obj)
				{
					var sReturn = "<?php if (preg_match("/e/i", $permissoes_funcionarios)): ?><a href='<?php echo HOST_URL ?>/funcionarios/editar?id="+id_reg+"'><i class='fa fa-pencil' title='Editar'></i></a><?php endif; ?>";
					
					if(reg_del == 'n')
					{
						sReturn += "<?php if (preg_match("/d/i", $permissoes_funcionarios)): ?> <a onclick='return confirm(\"Deseja realmente deletar esse registro?\")' href='<?php echo HOST_URL ?>/funcionarios/deletar?id="+id_reg+"'><i class='fa fa-times-circle'></i></a><?php endif; ?>";
					}
					
					return sReturn;
				}
			}
		],
		
		"sAjaxSource": "<?php echo HOST_URL ?>/sistema/funcionarios/listar.ajax.php"
	} );
} );
</script>