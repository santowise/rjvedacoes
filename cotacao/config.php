<?php
date_default_timezone_set('America/Sao_Paulo');

/**
 * Informações de localização do site
 **/

//Se o site nao estiver na raiz, especificar abaixo
define("DIRETORIO", '/cs/rjvedacoes/cotacao');
//URL completa
define("HOST_URL", "http://" . $_SERVER['SERVER_NAME'] . DIRETORIO);
//Caminho completo até a raiz do admin
define("HOST_PATH", dirname(__FILE__));
//Caminho completo para o sistema (onde fica toda programação em si)
define("SISTEMA_PATH", HOST_PATH . "/sistema");



/**
 * Definição da página atual sendo visualizada.
 *
 * Essa definição deveria acontecer usando apenas a variável
 * global $_SERVER["REQUEST_URI"] que já contem a página sendo
 * requisitada, porém se o site não estiver no diretório raiz,
 * o diretório que o site tiver (const DIRETORIO) irá aparecer em
 * $_SERVER["REQUEST_URI"]. Abaixo um exemplo de quando um site
 * está dentro da raiz:
 * 
 * Ex1 URL: http://localhost/cadastro
 * Ex2 URL: http://localhost/listar/produtos
 * 
 * A página sendo visualiza de acordo com $_SERVER["REQUEST_URI"]
 * no primeiro exemplo é 'cadastro' e no segundo exemplo 'listar/produtos'. 
 * Abaixo o mesmo exemplo mas tendo em conta que o site não está 
 * no diretório raiz:
 *
 * Ex1 URL: http://localhost/diretorio_site/cadastro
 * Ex2 URL: http://localhost/diretorio_site/listar/produtos
 *
 * A página sendo visualiza de acordo com $_SERVER["REQUEST_URI"]
 * no primeiro exemplo é 'diretorio_site/cadastro' e no segundo 
 * 'diretorio_site/listar/produtos'.
 *
 * O código abaixo faz a definição da página atual sempre como
 * no primeiro exemplo, mesmo se o site estiver dentro de algum
 * diretório... Apenas substituindo o valor de DIRETORIO em 
 * $_SERVER["REQUEST_URI"] por nada (uma string vazia).
 **/
$pagina_atual = (DIRETORIO != "") ? str_replace(DIRETORIO, "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)) : parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


//Define Path da URL atual sendo visitando pelo usuário
define("URL_PATH", $pagina_atual);



/**
 * Informacoes para conexao com banco de dados
 **/
//Endereço ou IP do servidor MySQL
define('DB_HOST', 'xmysql.rjvedacoes.com.br');
//Nome do banco de dados
define('DB_NAME', 'rjvedacoes');
//Usuário de acesso
define('DB_USER', 'rjvedacoes');
//Senha de acesso
define('DB_PASS', 'junt@890');



/**
 * Definição de cookies usados pelo site
 **/
//Cookie de login
define("COOKIE_LOGIN", "coklgn");



/**
 * Level de reportacao de erros no PHP
 * Ver levels em: http://www.php.net/manual/en/errorfunc.constants.php
 **/
error_reporting(E_ALL);



/**
 * Função para definir qual arquivo deve ser chamado
 * de acordo com o array de mapas de URL.
 **/
function definirArquivoDeURL($mapa_urls)
{
    //Percorre todas as página do mapa de URL's
    foreach ($mapa_urls as $url => $nome_arquivo)
    {
        /**
         * Adiciona contra barra antes de todas as barras da URL.
         * Necessário para expressão regular ficar correta.
         **/
        $url = str_replace("/", "\/", $url);
        
        
        //Verifica se URL atual é igual a URL sendo requisitada pelo usuário
        preg_match("/$url/i", URL_PATH, $dados_encontrados);
        
        
        /**
         * Se variável $dados_encontrados existir e for igual 
         * a URL sendo requisitada, retorna arquivo relativo
         * à URL.
         **/
        if (isset($dados_encontrados[0]) && $dados_encontrados[0] == URL_PATH)
        {
            return $nome_arquivo;
        }
    }
}



/**
 * Autoload: Qualquer classe quando for instanciada, automaticamente
 * o seu arquivo já será carregado.
 **/
function __autoload($nome_classe)
{
    //Todos as classes devem esta em letras minusculas
    $nome_classe = strtolower($nome_classe);
    
    if(file_exists(HOST_PATH . '/lib/'.$nome_classe.'.php'))

	    //Inclui arquivo de classe
	    include HOST_PATH . '/lib/'.$nome_classe.'.php';
}


//Paths
require_once HOST_PATH . "/path.php";