<?php
class FotoUpload
{
    /*
     * Verifica se arquivo de foto atende aos requisitos minimos
     * para upload da foto
     *
     * @return: 1 se foto não for em JPG ou PNG
     *          2 se tamanho for maior que permitido
     *          3 se foto ultrapassou da largura
     *          4 se foto ultrapassou da altura
     *          TRUE se passar nos requisitos
     */
    public function requisitos($arquivo)
    {
        $this->tamanho = '4000000'; //4.0MB = 4000000
        $this->largura = '2000'; //Em pixels (px)
        $this->altura  = '1500'; //Em pixels (px)
        
        //Verifica se o tipo de foto é inválido
        if(!preg_match("/(pjpeg|jpeg|jpg)/i", $arquivo["type"]))
        {
            return 1;
            exit();
        }
        //Verifica tamanho
        else if ($arquivo["size"] > $this->tamanho)
        {
            return 2;
            exit();
        }
        //Verifica dimensoes da foto
        else
        {
            $dimensoes = getimagesize($arquivo["tmp_name"]);
            
            //Largura
            if ($dimensoes[0] > $this->largura)
            {
                return 3;
                exit();
            }
            //Altura
            else if ($dimensoes[1] > $this->altura)
            {
                return 4;
                exit();
            }
        }
        
        //Retorna TRUE se tudo OK
        return true;
    }
    
    
    
    /*
     * Realiza upload do arquivo de imagem.
     * 
     * @param: $arquivo: Arquivo que está sendo enviado pelo usuário,
     *                   geralmente recebido de algum formulário.
     *
     * @param: $path: Local onde o arquivo será armazenado.
     *
     * @return: Nome da imagem (Hash MD5 + Extensão)
     */
    public function upload($arquivo, $path, $img_nome=false)
    {
        //Pega extensão do arquivo
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        
        
        //Gera nome unico para imagem
		$md5_nome = !$img_nome ? md5(uniqid(time())) : $img_nome;


        //Defini diretório de upload
        $diretorio_upload = $path;
		
                
        //Defini caminho completo para imagem
        $path_imagem = $diretorio_upload . $md5_nome . ".$extensao";

        
        //Faz upload da imagem
        //move_uploaded_file($arquivo["tmp_name"], $path_imagem);
        copy($arquivo["tmp_name"], $path_imagem);
        

        //Muda permissões de acesso do arquivo para 666
        chmod($path_imagem, 0666);
        
        
        //Se imagem for PNG, converte para JPG
        if ($extensao == 'png')
        {
            imagejpeg(imagecreatefrompng($path_imagem), $path_imagem, 100);
        }


        return $md5_nome . ".$extensao";
    }
    
    
    
    /*
     * Calcula dimensões proporcionais para redimensionar de
     * acordo com altura e largura máximas informadas.
     *
     * @param: $path_imagem: Caminho completo para a imagem, necessário
     *                       pois será pego as dimensoes atuais da imagem.
     *
     * @param: $largura_maxima: Largura máxima da imagem
     * @param: $altura_maxima: Altura máximo da imagem
     *
     * @return: $dimensoes['largura']
     *          $dimensoes['altura']
     */
    public function calcDimensoes($path_imagem, $largura_maxima, $altura_maxima)
    {
        //Cria array para armezenar novas dimensoes
        $dimensoes = array();
        
        
        //Pega dimensoes da imagem original
        list($largura, $altura) = getimagesize($path_imagem);
        
        
        //Calcula porcentagem para redimensionar
        $porcentagem = ($largura > $altura) ? ($largura_maxima / $largura) : ($altura_maxima / $altura);
        
        
        /*
         * Calcula nova largura e altura (pixels), arredonda 
         * valores quebrados e já armazena no array.
         */ 
        $dimensoes['largura'] = round($largura * $porcentagem);
        $dimensoes['altura']  = round($altura * $porcentagem); 
        
        
        return $dimensoes;
    }
    
    
    
    /*
     * Gera/Redimensiona imagem nas dimensoes informadas
     *
     * @param: $path_imagem
     * @param: $largura
     * @param: $altura
     * @param: $nome: Nome do arquivo de imagem a ser salvo com path
     *
     * @return: void
     */
    public function redimensionarImagem($path_imagem, $nova_largura, $nova_altura, $nome)
    {
        //Pega dimensoes da imagem
        list($largura, $altura, $tipo_imagem) = getimagesize($path_imagem);


        //Cria uma nova imagem True Color
        $ictc = imagecreatetruecolor($nova_largura, $nova_altura);
        
        
        //Pega extensão do arquivo
        $extensao = pathinfo($path_imagem, PATHINFO_EXTENSION);
        
        
        //Cria nova imagem a partir do path do arquivo
        $imagem = imagecreatefromjpeg($path_imagem);
        
        
        //Copia a redimensiona imagem
        imagecopyresampled($ictc, $imagem, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura, $altura);
        
        
        //Salva nova imagem na qualidade definida
        imagejpeg($ictc, $nome, 90);
    }
}
?>