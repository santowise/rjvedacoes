<?php
/*
 * Classe MySQL
 *
 * @Autor: Marcelo [marcelo@9y.com]
 */


class MySQL extends mysqli
{
    /*
     * Criação de variáveis
     */
     
    //(boolean) Status da conexão
    private $con_status;
    
    
    
    /*
     * Método construtor:
     *
     * Abre conexão com o servidor. Se algum erro ocorrer,
     * o erro é mostrado e a classe morre.
     *
     * @retorno 
     *     $con_status = true: Se conexão estiver OK
     */
    public function __construct()
    {
        //Realiza conexão
        @parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        
		$this->set_charset("utf8");
        
        
        //Verifica se existem erros
        if (mysqli_connect_error())
        {
            die("Erro na conexão: " . mysqli_connect_error());
        }
        
        
        //Seta status da conexão como TRUE
        $this->con_status = true;
        
        return $this->con_status;
    }
    
    
    
    /*
     * Método destrutor:
     *
     * Fecha conexão apenas se o valor da variável que guarda
     * o status da conexão ($con_status) for TRUE.
     */
    public function __destruct()
    {
        if($this->con_status)
        {
            parent::close();
            unset($this->con_status);
        }
    }
    
    
    
    /*
     * Retorna resultado único de uma query, sempre a primeira
     * coluna da primeira linha independente de quantas linhas
     * ou colunas o resultado tiver.
     * 
     * @args:
     *     $query: SQL Query
     *
     * @retorno:
     *     $linha[0]: Primeira coluna da primeira linha
     */
    public function getResult($query)
    {
        //Executa SQL Query
        $resultado = parent::query($query);
        
        
        //Verifica se existe erros
        if(mysqli_error($this))
        {
            die("Erro ao executar query: " . mysqli_error($this));
        }
        
        
        //Pega apenas primeira linha do resultado da SQL Query
        $linha = mysqli_fetch_row($resultado);
        
        
        //Retorna apenas primeiro coluna da linha
        return $linha[0];
    }

    
    
    /*
     * Retorna todas as linhas e colunas de uma consulta SQL.
     *
     * @args:
     *     $query: SQL Query
     *
     * @retorno:
     *     $resultado_query: Array com todas as linhas e colunas da consulta
     */
    public function getRows($query)
    {
        //Executa query
        $resultado = parent::query($query);
        
        
        //Verifica se existem erros
        if(mysqli_error($this))
        {
            die("Erro ao executar query: " . mysqli_error($this));
        }
        
        
        //De: http://php.net/manual/en/function.mysql-fetch-array.php#87201
        //Pega todos as linhas da consulta. Um elemento vazio é adiciona no final.]
        for($i = 0; $resultado_query[$i] = mysqli_fetch_assoc($resultado); $i++);


        //Remove o último elemento do array, o vazio.
        array_pop($resultado_query);


        //Retorna todas as linhas
        return $resultado_query;
    }
    
    
    
    /*
     * Retorna linha unica com diversas colunas (se houver)
     * de uma query.
     *
     * @args:
     *     $query: SQL Query
     *
     * @retorno:
     *     $linha: Array com todas as colunas da consulta
     */
    public function getRow($query)
    {
        //Executa query
        $resultado = parent::query($query);
        
        
        //Verifica se existem erros
        if(mysqli_error($this))
        {
            die("Erro ao executar query: " . mysqli_error($this));
        }
        
        
        //Pega apenas primeira linha de resultado
        $linha = mysqli_fetch_assoc($resultado);
        
        
        //Retorna linha com suas colunas
        return $linha;
    }
    
    
    
    /*
     * Salva um registro no banco
     *
     * @args:
     *     $post: $_POST com os dados para salvar,
	 *     onde a chave é o nome do campo, e o valor é o valor a salvar.
	 *     $table: Nome da tabela para salvar.
     *
     * @retorno:
     *     TRUE ou FALSE
     */
    public function save($post,$table)
    {
        //Executa query
        foreach($post as $field => $value):

			//Se for um array, pula
			if(is_array($value)) continue;
			
			//Trata o valor
			$value = parent::real_escape_string($value);
			
			//Adiciona os campos e valores
			@$insert_fields .= " $field , ";
			@$insert_values .= " '$value' , ";
			
		endforeach;
		
		
		//Remove a última vírgula (desnecessária)
		$insert_fields = substr($insert_fields, 0, strlen(trim($insert_fields)) - 1);
		$insert_values = substr($insert_values, 0, strlen(trim($insert_values)) - 1);
		
		
		//Cadastra os dados
		$sql = parent::query("INSERT INTO $table ($insert_fields) VALUES ($insert_values)");
        
        
        //Retorna linha com suas colunas
        return $sql;
    }
    
    
    
    /*
     * Atualiza um registro no banco
     *
     * @args:
     *     $post: $_POST com os dados para salvar,
	 *     onde a chave é o nome do campo, e o valor é o valor a salvar.
	 *     $table: Nome da tabela para salvar.
     *
     * @retorno:
     *     TRUE ou FALSE
     */
    public function update($post,$table,$cond)
    {
        //Executa query
        foreach($post as $field => $value):

			//Se for um array, pula
			if(is_array($value)) continue;
			
			//Trata o valor
			$value = parent::real_escape_string($value);
			
			//Adiciona: $campo = '$valor'
			@$update .= " $field = '$value' , ";
			
		endforeach;


		//Remove a última vírgula (desnecessária)
		$update = substr($update, 0, strlen(trim($update)) - 1);
		echo "UPDATE $table SET $update WHERE $cond";
		
		//Atualiza os dados
		$sql = parent::query("UPDATE $table SET $update WHERE $cond");
        
        
        //Retorna linha com suas colunas
        return $sql;
    }
}