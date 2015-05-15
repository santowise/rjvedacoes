<?php
/**
 * Classe para manipulação de URL's no sistema
 **/

class URL
{
    /**
     * Função para definir qual arquivo deve ser chamado
     * de acordo com o array de mapas de URL.
     * 
     * @args:
     *      $mapa_urls: Array com mapa de URL's
     *      $pagina_erro_404: Página de erro 404 para o caso de nenhum
     *                        arquivo seja encontrado no mapa de urls.
     * 
     * @return:
     *      $nome_arquivo: Nome do arquivo referente a URL sendo chamada
     *      void: Se nenhuma URL do mapa de URL's for igual a que está
     *            sendo requisitada pelo usuário
     **/
    public static function definirArquivoDeURL($mapa_urls, $pagina_erro_404 = "/404.php")
    {
        //Variavel irá armazenar arquivo final que deverá ser chamado
        $nome_arquivo_final = "";
        
        
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
                $nome_arquivo_final = $nome_arquivo;
            }
        }
        
        
        //Se $nome_arquivo_final estiver vazia, atribui a ela a página de erro 404
        if (empty($nome_arquivo_final)) $nome_arquivo_final = $pagina_erro_404;
        
        
        return $nome_arquivo_final;
    }
    
    
    
    
    
    
    /**
     * Gera URL Amigável a partir de uma string.
     * 
     * @args:
     *     $string: String que será transformada em URL
     *     $separador: O que deverá ser usado no lugar de espaços
     *     $data_my (Opcional): Caso a data no formato MySQL seja
     *                          informado, será concatenada no final
     *                          da url gerada no formato: 03Jun11
     * 
     * 
     * @return:
     *     $url_amigavel: URL Amigável de acordo com os parametros
     * 
     * 
     * @example:
     *     Chamando: geraUrlAmigavel('Evento Qualquer na Via Show')
     *     Retorno:  eventoqualquernaviashow
     * 
     *     Chamando: geraUrlAmigavel('Evento Qualquer na Via Show', '-')
     *     Retorno:  evento-qualquer-na-via-show
     * 
     *     Chamando: geraUrlAmigavel('Evento Qualquer na Via Show', '.', '2011-06-22'')
     *     Retorno:  evento.qualquer.na.via.show.22Jun11
     **/
    public static function geraUrlAmigavel($string, $separador = "", $data_my = "")
    {
        //Coloca toda string em letras minusculas
        $string = strtolower($string);
        
        
        //Substitui espaços pelo separados
        $string = str_replace(" ", $separador);
        
        
        //Substitui letras com acento por letras sem acento
        $string = str_replace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $string);                  
        $string = str_replace(array('à', 'è', 'ì', 'ò', 'ù'), array('a', 'e', 'i', 'o', 'u'), $string);
        $string = str_replace(array('â', 'ê', 'î', 'ô', 'û'), array('a', 'e', 'i', 'o', 'u'), $string);
        $string = str_replace(array('ã', 'õ', 'ç'), array('a', 'o', 'c'), $string);
        
        
        //Retira todos os caracteres que não forem de A-Z e 0-9
        $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
        
        
        /**
         * Verifica se a data no formato MySQL foi passada via parametro.
         * Se nao, cria url sem data no final. Se sim, cria url com data
         * no final. 
         **/
        if (empty($data_my))
        {
            //Cria url nome no formato stringsemespacos (String)
            $url_amigavel = "$string";
        }
        else
        {
            //Pega número do mes
            $mes_numero = substr($data_my, 5, 2);
            
            //Pega nome extenso do mes no formato: Jan, Fev, Mai etc
            $mes_nome = ucfirst(strtolower(substr(datas::pegaNomeMes($mes_numero), 0, 3)));
            
            //Pega dia e ano
            $dia = substr($data_br, 8, 2);
            $ano = substr($data_br, 0, 4);
            
            //Cria url nome no formato nomeevento.08Nov10 (Str [ponto] Dia Mes Ano)
            $url_amigavel = "$string$separador$dia$mes_nome$ano";
        }
        
        
        return $url_amigavel;
    }
}
?>