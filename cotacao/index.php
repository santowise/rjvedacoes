<?php
//Inicia compressão do conteúdo
ob_start("ob_gzhandler");


//Arquivo de configuração geral
require 'config.php';


//Instancia classe para manupulação do banco de dados
$mysql = new MySQL();


/**
 * Verifica se funcionário está logado. Caso sim, é retornado
 * o ID + Nome do funcionário logado, do contrário false é
 * retornado. 
 *
 * Se não houver ID do funcionário, sistema chama a pagina
 * de login e finaliza execução da página.
 **/
list($id_funcionario_logado, $nome_funcionario_logado) = funcionarios::estaLogado();


//Se não houver ID do funcionario, chama para página de login
if (empty($id_funcionario_logado))
{
    require SISTEMA_PATH . '/funcionarios/login.php';
    exit(1);
}


//Pega permissoes do funcionario
$permissoes_funcionario = $mysql->getRow("SELECT
											  *
                                          FROM
                                              funcionarios
                                          WHERE 
                                              id = $id_funcionario_logado");

//Define dados em variáveis especificas
$permissoes_clientes     = 'veid';
$permissoes_funcionarios = $permissoes_funcionario['permissoes_funcionarios'];


/*
 * Funções abaixo para incluir o topo e rodapé
 * no início e final das páginas do sistema.
 */
function topo()   { require SISTEMA_PATH . '/topo.php'; }
function rodape() { require SISTEMA_PATH . '/rodape.php'; }



/**
 * Array com mapa de URLs do site.
 * Formato do array:
 *     array("URL_PATH", "ARQUIVO_REFERENTE_URL")
 **/
$mapa_urls = array('/' => '/index.php',	
				   
				   //Localizador de Lojas	   
				   '/clientes/cadastrar'           => '/clientes/cadastrar.php',
				   '/clientes/cadastrar_processar' => '/clientes/cadastrar_processar.php',
				   '/clientes/editar'              => '/clientes/editar.php',
				   '/clientes/editar_processar'    => '/clientes/editar_processar.php',	
				   '/clientes/listar'              => '/clientes/listar.php',
                   '/clientes/deletar'             => '/clientes/deletar_processar.php',				   
				   			   
                   //Funcionários
                   '/funcionarios/listar'              => '/funcionarios/listar.php',
                   '/funcionarios/editar'              => '/funcionarios/editar.php',
                   '/funcionarios/editar_processar'    => '/funcionarios/editar_processar.php',
                   '/funcionarios/cadastrar'           => '/funcionarios/cadastrar.php',
                   '/funcionarios/cadastrar_processar' => '/funcionarios/cadastrar_processar.php',
                   '/funcionarios/deletar'             => '/funcionarios/deletar_processar.php',
                   '/sair'                             => '/funcionarios/logout.php');


//Define qual arquivo a ser chamado (Esse que irá exibir o site)
$arquivo_site_final = url::definirArquivoDeURL($mapa_urls);


//Mostra site
require SISTEMA_PATH . $arquivo_site_final;


//Envia saida em HTML para o usuário
ob_end_flush();