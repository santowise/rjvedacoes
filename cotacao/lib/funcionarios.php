<?php
/*
 * Classe para manipulação de login
 */
 
class Funcionarios
{
    /**
     * Verifica se dados de login (id do funcionario e senha) estão
     * corretos. A senha já deve ser recebida pelo método em SHA1.
     *
     * @args:
     *      $id_funcionario: ID do funcionário
     *      $senha: Senha de acesso
     *
     * @return:
     *      $nome: Se dados corretos
     *      false: Se dados incorretos
     **/
    public static function verificaDados($id_funcionario, $senha)
    {
        //Importa objeto global de conexão com BD
        global $mysql;
        
        
        /*
         * Faz verificação dos dados no BD. Retorna nome do
         * funcionario se dados estiverem corretos, 0 se não.
         */
        $nome = $mysql->getResult("SELECT 
                                       nome
                                                  
                                   FROM 
                                       funcionarios
                                                  
                                   WHERE 
                                       id = $id_funcionario 
                                       AND 
                                       senha = '$senha'
									   AND
									   deletado = 'n'");
                                                   
        
        //Se nao houver nome, os dados estao incorretos
        if (empty($nome))
        {
            return false;
        }
        else
        {
            return $nome;
        }
    }




    /**
     * Pega ID do funcionário a partir do e-mail. Caso não 
     * exista, retorna falso.
     *
     * @args:
     *      $email: E-Mail cadastrado
     *
     * @return:
     *      ID do funcionário: Caso e-mail exista no banco de dados
     *      false: Caso e-mail não exista
     **/
    public static function pegaFuncionarioID($email)
    {
        //Importa objeto global de conexão com BD
        global $mysql;
        
        
        //Pega ID no BD a partir do e-mail
        $id_funcionario = $mysql->getResult("SELECT 
                                                 id
                                                 
                                             FROM 
                                                 funcionarios
                                                 
                                             WHERE 
                                                 email = '$email'");
                                         

        /*
         * Verifica se ID retorna é válido. Para isso a variável
         * $id_usuario deve ser um valor inteiro e maior que zero.
         *
         * Se for válido, esse será o valor do retorno.
         */
        if (is_numeric($id_funcionario) & $id_funcionario > 0)
        {
            return $id_funcionario;
        }
        else
        {
            return false;
        }
    }
    
    
    
    /**
     * Seta cookie de login. 
     * 
     * Os dados (ID do funcionario e senha) são gravados em um 
     * único cookie separados por # (tralha)
     * 
     * @args:
     *      $id_funcionario: ID do funcionário
     *      $senha: Senha do codificada em SHA1
     *
     * @return:
     *      void (NULL no caso do PHP)
     **/
    public static function setaCookie($id_funcionario, $senha)
    {
        //Define dados para entrar no cookie
        $dados_cookie = "$id_funcionario#$senha";
        
        
        //Cria cookie
        setcookie(COOKIE_LOGIN, $dados_cookie, 0, '/');
        
        
        //Redireciona para página principal do admin
        header("Location: ".HOST_URL."");
        
        
        return null;
    }
    
    
    
    /**
     * Verifica se funcionário está logado.
     *
     * @return:
     *     $dados_usuario: ID + Nome do funcionário logado
     *     false: Caso não exista o cookie ou dados do cookie incorretos
     **/
    public static function estaLogado()
    {
        //Se cookie não estiver vazio faz verificação
        if (!empty($_COOKIE[COOKIE_LOGIN]))
        {
            //Separa dados do cookie separados por tralha
            $dados_cookie = explode('#', $_COOKIE[COOKIE_LOGIN]);
            
            
            //Define dados do cookie em variáveis especificas
            $id_funcionario_logado = $dados_cookie[0];
            $senha_sha1            = $dados_cookie[1];
            
            
            //Verifica se dados do cookie batem com os dados do BD (Retorna apelido se sim)
            $nome = funcionarios::verificaDados($id_funcionario_logado, $senha_sha1);
            
            
            //Se nao houver nome, os dados estao incorretos
            if (empty($nome))
            {
                return false;
            }
            else
            {
                //Define dados do funcionario (ID + Nome) num array para retorno
                $dados_usuario = array($id_funcionario_logado, $nome);
                
                
                //Retorna dados do usuario em array
                return $dados_usuario;
            }
        }
        else
        {
            return false;
        }
    }
	
	
	// Pega as permissões no banco
	/*public static function setPermissoes($tabelas,$id_funcionario)
	{
		global $mysql;
		
		//
		foreach($tabelas as $tabela):
			@$tabelas_string .= ',permissoes_' . $tabela;
		endforeach;
		
		// Verifica se o usuário tem permissão
		$sql = $mysql->getResult("SELECT
									  --
									  $tabelas_string
								  FROM
								      funcionarios
								  WHERE
								      id = $id_funcionario");
									  
		$this->
	}
	
	
	// Retorna as permissoes para consulta
	public static function getPermissoes($permissao)
	{
	}*/
}























