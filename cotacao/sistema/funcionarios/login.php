<?php
/**
 * Página de login.
 *
 * Existe na página a variável $status_login que controla
 * o status atual de login, por padrão o valor é 0. Outros
 * valores são definidos ao longo da página se necessário
 * para definir o status de login e informar ao funcionario o
 * que aconteceu.
 **/
$status_login = 0;

 
 
/**
 * Se funcionario estiver enviando dados, realiza procedimentos
 * de login. Se login for bem sucedido, redireciona para página 
 * principal do administrativo.
 **/
if ($_POST)
{
    //Recebe dados de login
    $email       = $_POST['email'];
    $senha       = $_POST['senha'];
    $url_retorno = isset($_POST['url_retorno']) ? $_POST['url_retorno'] : '';
    
    
    //Só continua se o e-mail for válido
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
         //Pega ID do funcionário a partir do e-mail
        $id_funcionario = funcionarios::pegaFuncionarioID($email);
        
        
        //Se não houver ID do funcionário, e-mail de login não válido
        if (empty($id_funcionario))
        {
            //Define status de login como 2 (E-Mail inválido)
            $status_login = 2;
        }
        else
        {
            //Encripta senha em SHA1
            $senha = sha1($senha);
        
        
            //Verifica se dados estão corretos
            $dados_corretos = funcionarios::verificaDados($id_funcionario, $senha);
            
        
            //Se dados de login estiverem corretos, procede com login
            if ($dados_corretos == true)
            {
                //Seta cookie para o usuário
                funcionarios::setaCookie($id_funcionario, $senha);
            
            
                /**
                 * Verifica se existe URL de retorno, se sim, redireciona
                 * para página que usuário estava tentando acessar sem
                 * está logado. Do contrario, redireciona para pagina
                 * principal.
                 **/
                if (empty($url_retorno))
                {
                    header("Location: ".HOST_URL."");
                    exit(0);
                }
                else
                {
                    header("Location: http://$url_retorno");
                    exit(0);
                }
            }
            else
            {
                //Define status de login como 3 (Senha invalida)
                $status_login = 3;
            }
        }
    }
    else
    {
        //Define status de login como 1 (Formato do e-mail inválido)
        $status_login = 1;
    }
}


?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Sistema Administrativo</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo HOST_URL ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo HOST_URL ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo HOST_URL ?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo HOST_URL ?>/media/css/styles.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Login</div>
            <form action="" method="post">
                <!-- Grava página que usuário estava tentando acessar sem está logado -->
                <input type="hidden" name="url_retorno" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" />
                
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="E-mail" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="senha" class="form-control" placeholder="Senha" autocomplete="off" />
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Entrar</button>
                </div>
            </form>

    
		<?php
		//Mostra status de login se houver
		if($status_login > 0):
		?>
        
        <div class="info_login">Os dados informados não são válidos.</div>
        
        <?php endif; ?>
        
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo HOST_URL ?>/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>