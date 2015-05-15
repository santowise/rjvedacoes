<?php
/*
 * Envia e-mails via SMTP;
 * @author Marcelo [marcelo@9y.com]
 *
 * Argumentos para envio no método Enviar:
 *    @remetente;
 *    @destinatario;
 *    @assunto;
 *    @mensagem;
 *    [OPCIONAL]@responder para (reply to);
 *
 * Exemplo: $smtp->Enviar($remetente, $destinatario, $assunto, $mensagem);
 */
 
class Smtp
{
    private $servidor = SMTP_HOST;
    private $porta    = SMTP_PORT;
    private $usuario  = SMTP_USER;
    private $senha    = SMTP_PASS;
    
    private $conexao;
    private $erro_num;
    private $erro_str;
    private $debug = true;
    
    private $remetente;
    private $destinatario;    
    private $assunto;
    private $mensagem;
    private $responder_para;
    


    /*
     * Assim que classe é instanciada abre conexão com servidor
     *
     * Se não houver argumentos necessários na instancia ($servidor, 
     * $usuario e $senha), tenta utilizar dados padrões.
     *
     * return boolen TRUE: Se conexão ok;
     *               FALSE: Se conexao falhou;
     */
    public function __construct($servidor='', $porta='', $usuario='', $senha='')
    {
        //Define novos dados de conexão se fornecidos na instancia
        if ($servidor && $porta && $usuario && $senha)
        {
            $this->servidor = $servidor;
            $this->porta    = $porta;
            $this->usuario  = $usuario;
            $this->senha    = $senha;
        }
        

        //Abre conexão com servidor
        $this->conexao = @fsockopen($this->servidor, $this->porta, $this->erro_num, $this->erro_str);
        
        
        //Se não conseguir conectar, mostra erro
        if (!$this->conexao)
        {
            echo "Erro($this->erro_num): $this->erro_str";
            
            return false;
        }
        
        
        //Se não houver erro, inicia sessão e autentica
        else
        {
            $this->IniciaSessao();
            $this->Autentica();
        }
    }
    
   
    
    
    //Envia comandos para servidor SMTP
    private function EnviaComando($comando)
    {
        fputs($this->conexao, $comando . "\r\n");
    }
    
    
    
    //Inicia sessão com servidor SMTP
    private function IniciaSessao()
    {
        $this->EnviaComando("EHLO $this->servidor");
    }
    
    
    
    //Realiza autenticação no servidor
    private function Autentica()
    {
        $this->EnviaComando("AUTH LOGIN");
        $this->EnviaComando(base64_encode($this->usuario));
        $this->EnviaComando(base64_encode($this->senha));
    }
    
    
    
    //Envia e-mail
    public function Enviar($remetente, $destinatario, $assunto, $mensagem, $responder_para='')
    {
        $this->remetente      = $remetente;
        $this->destinatario   = $destinatario;
        $this->assunto        = $assunto;
        $this->mensagem       = $mensagem;
        $this->responder_para = $responder_para;
        
        
        //Envia comandos com argumentos para o envio
        $this->EnviaComando("MAIL FROM: " . $this->remetente);
        $this->EnviaComando("RCPT TO: " . $this->destinatario);
        $this->EnviaComando("DATA");
        $this->EnviaComando($this->MontaCabecalho($this->remetente, $this->destinatario, 
                                                  $this->assunto, $this->responder_para));
        $this->EnviaComando("\r\n");
        $this->EnviaComando($this->mensagem);
        $this->EnviaComando(".");
        $this->FechaConexao();

        
        if(isset($this->conexao))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    
    //Monta cabeçalho
    private function MontaCabecalho($remetente, $destinatario, $assunto, $responder_para)
    {
        $this->remetente      = $remetente;
        $this->destinatario   = $destinatario;
        $this->assunto        = $assunto;
        $this->responder_para = $responder_para;
        

        //Começa a montar cabeçalho    
        $cabecalho  = "Message-Id: <". date('YmdHis').".". md5(microtime()).".". strtoupper($this->remetente) ."> \r\n";
        $cabecalho .= "From: <" . $this->remetente . "> \r\n";
        $cabecalho .= "To: <".$this->destinatario."> \r\n";
        
        
        //Se 'responder para' for fornecido, inclui no cabecalho
        if ($this->responder_para) $cabecalho .= "Reply-To: $responder_para \r\n";

        
        //Continua montando cabeçalho
        $cabecalho .= "Subject: ".$this->assunto." \r\n";
        $cabecalho .= "Date: ". date('D, d M Y H:i:s O') ." \r\n";
        $cabecalho .= "X-MSMail-Priority: High \r\n";
        $cabecalho .= "Content-Type: Text/plain; charset=iso-8859-1";
    
        return $cabecalho;
    }
    
    
    
    //Fecha conexao
    private function FechaConexao()
    {
        $this->EnviaComando("QUIT");
        
        
        //Mostra toda conversa com servidor se Debug ativado
        if ($this->debug == true)
        {
            while ($buffer = fgets($this->conexao))
            {
                echo $buffer . "<br />";
            }
        }
                
        return fclose($this->conexao);
    }
}
?>
