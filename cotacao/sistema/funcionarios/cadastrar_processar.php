<?php
//Recebe dados do formulário
$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];


/**
 * Verifica se é um e-mail válido. Esse campo não pode ficar
 * vazio pois é o usuário de login. Caso esteja vazio ou seja
 * inválido, redireciona para página de cadastro avisando sobre 
 * e finaliza execução da página.
 **/
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    header("Location: ".HOST_URL."/funcionarios/cadastrar?status=1");
    exit(1);
}


/**
 * Verifica se já existe algum funcionário cadastrado com o e-mail
 * informado. Caso sim, redireciona para página de cadastro avisando 
 * sobre e finaliza execução da página.
 *
 * A consulta abaixo retorna 1 se e-mail já existi, do contrário
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


// Permissões
$p_funcionarios = implode('',$_POST['p_funcionarios']);


//Encripta senha em SHA1 
$senha_sha1 = sha1($senha);


//Inseri dados do novo usuário no BD
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
                    
                    
//Redireciona para página de listagem de funcionários com status do cadastro
header('Location: '.HOST_URL.'/funcionarios/listar?status=255');
exit(0);