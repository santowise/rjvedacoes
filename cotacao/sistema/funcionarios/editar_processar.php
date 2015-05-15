<?php
//Recebe ID do funcionário sendo editado
$id = (int)$_GET['id'];


//Recebe dados do formulário
$nome     = $_POST['nome'];
$email    = $_POST['email'];
$senha    = $_POST['senha'];
$deletado = isset($_POST['deletado']) ? 's' : 'n';


/**
 * Verifica se é um e-mail válido. Esse campo não pode ficar
 * vazio pois é o login do funcionário. Caso esteja vazio ou seja
 * inválido, redireciona para página de cadastro avisando sobre 
 * e finaliza execução da página.
 **/
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    header("Location: ".HOST_URL."/funcionarios/editar?id=$id&status=1");
    exit(1);
}


/**
 * Verifica se campo de senha não está vazio.
 *
 * Caso esteja vazio, senha do funcionário continuará a mesmo caso
 * contrário, senha será atualizada no banco de dados.
 **/
if (!empty($senha))
{
    //Encripta nova senha em SHA1
    $nova_senha_sha1 = sha1($senha);
    
    
    //Atualiza nova senha no BD
    $mysql->query("UPDATE funcionarios SET senha = '$nova_senha_sha1' WHERE id = $id");
}




// Permissões
$p_funcionarios = implode('',$_POST['p_funcionarios']);


// Atualiza
$mysql->query("UPDATE
                   funcionarios

               SET
					nome                        = '$nome',
					email                       = '$email',
					deletado                    = '$deletado',
					permissoes_funcionarios     = '$p_funcionarios',
					dt_hr_atualizacao           = NOW()

               WHERE
                   id = $id");
                   
				   
header("Location: ".HOST_URL."/funcionarios/listar?status=255");
exit(0);