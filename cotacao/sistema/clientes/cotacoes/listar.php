<?php
//Verifica permissões de acesso a página
if (!preg_match("/v/i", $permissoes_clientes)) { header('Location: '.$_SERVER['HTTP_REFERER'].'?status=254'); exit(0); }


//Inclui topo do site
topo();


//Id do cliente
$id = (int)$_GET['id'];


?>
<h1>
    <a href="<?php echo HOST_URL ?>/clientes/listar">Clientes</a> » 
    <a href="<?php echo HOST_URL ?>/clientes/cotacoes/listar?id=<?php echo $id ?>">Cotações</a> » Listar
</h1>
</section>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            
                <div class="box-body table-responsive">

                    <a href="./cadastrar?id=<?php echo $id ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Criar nova cotação</a>

                    <br /><br />

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

	
	var oTable = $('.paginacao').dataTable(
	{		
		"bProcessing": true,
		"bServerSide": true,
		"bStateSave": true,
		
		
		"aoColumns": [
			
			// ID			
			{ 	
				"sTitle": "Número",
				"fnRender": function(obj)
				{
					var sReturn = obj.aData[ obj.iDataColumn ];
					
					//Pega o id do registro
					id_reg = sReturn;
					
					return sReturn;
				}
			},
			
			{ "sTitle": "Nome" },
			
			{
				"sTitle": "Cadastro",			
				"bSortable": false
			},

			{
				"sTitle": "Baixar PDF",
				"sClass": "textC w10 alignM",
				"mData" : null,
				"bSortable": false,
				"fnRender": function(obj)
				{
					var sReturn = "<?php if (preg_match("/e/i", $permissoes_clientes)): ?><a href='<?php echo HOST_URL ?>/sistema/clientes/cotacoes/exportar_pdf.php?id="+id_reg+"'><i class='fa fa-download' title='Baixar PDF'></i></a><?php endif; ?>";
										
					return sReturn;
				}
			},
			
			{
				"sTitle": "Editar",
				"sClass": "textC w10 alignM",
				"mData" : null,
				"bSortable": false,
				"fnRender": function(obj)
				{
					var sReturn = "<?php if (preg_match("/e/i", $permissoes_clientes)): ?><a href='<?php echo HOST_URL ?>/clientes/cotacoes/editar?id="+id_reg+"'><i class='fa fa-pencil' title='Editar'></i></a><?php endif; ?>";
										
					return sReturn;
				}
			},
			
			//Excluir
			{
				"sTitle": "Excluir",
				"sClass": "textC w10 alignM",
				"mData" : null,
				"bSortable": false,
				"fnRender": function(obj)
				{
					return "<?php if (preg_match("/d/i", $permissoes_clientes)): ?><a href='<?php echo HOST_URL ?>/clientes/cotacoes/deletar?id="+id_reg+"' onclick='return confirm(\"Isso irá apagar definitivamente esse registro e essa ação é irreversível. Deseja prosseguir?\")'><i class='fa fa-trash-o fontRed' title='Excluir'></i></a><?php endif; ?>";
				}
			}
		],
		
		"sAjaxSource": "<?php echo HOST_URL ?>/sistema/clientes/cotacoes/listar.ajax.php?id=<?php echo $id ?>"
	});


    //Remove o autofill na busca, adiciona o botão e inclui css
    $("div.dataTables_filter input").unbind();
    $("div.dataTables_filter input").addClass('form-control');
    $("div.dataTables_filter input").after('<a style="margin-left:10px" class="btn btn-primary" href="javascript:void(0)" id="filter">buscar</a>');    
    $('#filter').click(function(e){
        oTable.fnFilter($("div.dataTables_filter input").val());
    });

});
</script>