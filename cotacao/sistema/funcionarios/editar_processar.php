<?php
//Recebe ID do funcion�rio sendo editado
$id = (int)$_GET['id'];


//Recebe dados do formul�rio
$nome     = $_POST['nome'];
$email    = $_POST['email'];
$senha    = $_POST['senha'];
$deletado = isset($_POST['deletado']) ? 's' : 'n';


/**
 * Verifica se � um e-mail v�lido. Esse campo n�o pode ficar
 * vazio pois � o login do funcion�rio. Caso esteja vazio ou seja
 * inv�lido, redireciona para p�gina de cadastro avisando sobre 
 * e finaliza execu��o da p�gina.
 **/
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    header("Location: ".HOST_URL."/funcionarios/editar?id=$id&status=1");
    exit(1);
}


/**
 * Verifica se campo de senha n�o est� vazio.
 *
 * Caso esteja vazio, senha do funcion�rio continuar� a mesmo caso
 * contr�rio, senha ser� atualizada no banco de dados.
 **/
if (!empty($senha))
{
    //Encripta nova senha em SHA1
    $nova_senha_sha1 = sha1($senha);
    
    
    //Atualiza nova senha no BD
    $mysql->query("UPDATE funcionarios SET senha = '$nova_senha_sha1' WHERE id = $id");
}




// Permiss�es
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