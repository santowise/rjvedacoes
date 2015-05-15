<?php
//Recebe dados do formul�rio
$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];


/**
 * Verifica se � um e-mail v�lido. Esse campo n�o pode ficar
 * vazio pois � o usu�rio de login. Caso esteja vazio ou seja
 * inv�lido, redireciona para p�gina de cadastro avisando sobre 
 * e finaliza execu��o da p�gina.
 **/
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    header("Location: ".HOST_URL."/funcionarios/cadastrar?status=1");
    exit(1);
}


/**
 * Verifica se j� existe algum funcion�rio cadastrado com o e-mail
 * informado. Caso sim, redireciona para p�gina de cadastro avisando 
 * sobre e finaliza execu��o da p�gina.
 *
 * A consulta abaixo retorna 1 se e-mail j� existi, do contr�rio
 * retorna 0.
 **/
$existe_email = $mysql->getResult("SELECT 
                                       count(*)
                                        
                                   FROM 
                                       funcionarios
                                       
                                   WHERE 
                                       email = '$email'");

if ($existe_email == 1)
{
    header("Location: ".HOST_URL."/funcionarios/cadastrar?status=2");
    exit(2);
}


// Permiss�es
$p_funcionarios = implode('',$_POST['p_funcionarios']);


//Encripta senha em SHA1 
$senha_sha1 = sha1($senha);


//Inseri dados do novo usu�rio no BD
$mysql->query("INSERT INTO funcionarios
                   	(nome, 
					email, 
					senha,
					permissoes_funcionarios,
                    dt_hr_cadastro)
               VALUES
                   ('$nome',
                    '$email',
                    '$senha_sha1',
					'$p_funcionarios',
                    NOW())");
                    
                    
//Redireciona para p�gina de listagem de funcion�rios com status do cadastro
header('Location: '.HOST_URL.'/funcionarios/listar?status=255');
exit(0);