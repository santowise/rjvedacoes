<?php
/*
 * Mostra mensagem de status ao usuário se houver.
 * O controle é feito via URL através da variável:
 * 'status'. Por exemplo:
 *
 * URL Ex1: http://www.site.com.br/cadastro?status=3
 * 
 * No exemplo acima a mensagem de status número 3 será
 * enviada a tela do usuário.
 *
 * Após 15 segundos, a frase automáticamente irá desaparecer
 * da tela do usuário. Esse controle pode ser feito através
 * do arquivo 'geral_padrao.js' na pasta de javascript's
 *
 * Usar as seguintes classes na DIV para controle da 
 * cor da frase que será exibida a mensagem de status:
 *
 *     'erro': Cor de fundo vermelha
 *     'sucesso': Cor de fundo verde
 *     'aviso': Cor de fundo amarela 
 */

//Verifica se existe variável na URL
if (!empty($_GET['status']))
{
    //Se houver, define número do status em variável especifica
    $numero_msg_status = (int)$_GET['status'];

    
    //Verifica qual mensagem deve ser enviada ao usuário
    switch ($numero_msg_status)
    {
        case 254:
            echo '
			<div class="alert alert-warning alert-dismissable">
				<i class="fa fa-warning"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Atenção!</b> Você não tem permissões de acesso à página que está tentando acessar.
			</div>';
            break;
            
        case 255:
            echo '
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Sucesso!</b> Operação realizada com sucesso.
			</div>';			
            break;
            
        case 256:
            echo '
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Erro!</b> Não foi possível exportar os usuários. Entre em contato com o suporte.
			</div>';
            break;
            
        case 1:
            echo '
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Erro!</b> O E-Mail inserido não é válido.
			</div>';
            break;
            
        case 2:
            echo '
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Erro!</b> O E-Mail inserido já está cadastrado.
			</div>';
            break;            
    }
}