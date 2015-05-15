<?php
class Utilidades
{
    
    /**
     * Formata CPF com apenas números para o formato
     * padrao: 111.222.333-11
     * 
     * @param: $cpf_numerico
     **/
    public static function formataCPF($cpf_numerico)
    {
        //Separa dados
        $parte1 = substr($cpf_numerico, 0, 3);
        $parte2 = substr($cpf_numerico, 3, 3);
        $parte3 = substr($cpf_numerico, 6, 3);
        $parte4 = substr($cpf_numerico, 9, 2);
        
        
        //Coloca no formato padrao do CPF
        $cpf = "$parte1.$parte2.$parte3-$parte4";
        
        
        return $cpf;
    }
    
    
    
    
    /**
     * Funcao para validade CPF.
     * Pego em: http://codigofonte.uol.com.br/codigo/php/validacao/validacao-de-cpf-com-php
     * 
     * @param: $cpf_numerico
     **/
    public static function validaCPF($cpf_numerico)
    {
        //Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf_numerico) != 11 || 
            $cpf_numerico == '00000000000' || 
            $cpf_numerico == '11111111111' || 
            $cpf_numerico == '22222222222' || 
            $cpf_numerico == '33333333333' || 
            $cpf_numerico == '44444444444' || 
            $cpf_numerico == '55555555555' || 
            $cpf_numerico == '66666666666' || 
            $cpf_numerico == '77777777777' || 
            $cpf_numerico == '88888888888' || 
            $cpf_numerico == '99999999999')
	    {
	        return false;
        }
	   else
	   {
	       //Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) 
            {
                for ($d = 0, $c = 0; $c < $t; $c++) 
                {
                    $d += $cpf_numerico{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf_numerico{$c} != $d) 
                {
                    return false;
                }
            }

            return true;
        }
    }
    
    
    
    
    /**
     * Formata CNPJ com apenas números para o formato
     * padrao:
     * 
     *     Formato 1 (14 numeros): xx.xxx.xxx/xxxx-xx
     *     Formato 2 (15 numeros): xxx.xxx.xxx/xxxx-xx
     * 
     * @param: $cnpj_numerico
     **/
    public static function formataCNPJ($cnpj_numerico)
    {
        //Pega quantidade de números
        $qtd_numeros_cnpj = strlen($cnpj_numerico);
        
        
        //Separa números de acordo com quantidade
        if ($qtd_numeros_cnpj == 14)
        {
            //Separa dados
            $parte1 = substr($cnpj_numerico, 0, 2);
            $parte2 = substr($cnpj_numerico, 2, 3);
            $parte3 = substr($cnpj_numerico, 5, 3);
            $parte4 = substr($cnpj_numerico, 8, 4);
            $parte5 = substr($cnpj_numerico, 12, 2);
        }
        else
        {
            //Separa dados
            $parte1 = substr($cnpj_numerico, 0, 3);
            $parte2 = substr($cnpj_numerico, 3, 3);
            $parte3 = substr($cnpj_numerico, 6, 3);
            $parte4 = substr($cnpj_numerico, 9, 4);
            $parte5 = substr($cnpj_numerico, 13, 2);
        }
        
        
        //Coloca no formato padrao do CPNJ
        $cnpj = "$parte1.$parte2.$parte3/$parte4-$parte5";
        
        
        return $cnpj;
    }
    
    
    
    
    /**
     * Gera URL Amigável a partir de um string.
     * 
     * @param: $string
     * @param: $data_my (Opcional)
     * 
     * Se apenas a string for passada, a url será gerada no tipo:
     *     De: "Evento Qualquer na Via Show"
     *     Para: "eventoqualquernaviashow"
     * 
     * Se a data no formato MySQL for passada, a data será concatenada
     * no final da url assim:
     *     De: "Evento Qualquer na Via Show" e Data: "2010-11-15"
     *     Para: "eventoqualquernaviashow.15Nov10"
     **/
    /*public static function slugify($string, $data_my = "")
    {
        //Coloca toda string em letras minusculas
        echo $string = mb_strtolower(utf8_decode($string));
        
        
        //Substitucao acentos
        $string = str_replace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $string);                  
        $string = str_replace(array('à', 'è', 'ì', 'ò', 'ù'), array('a', 'e', 'i', 'o', 'u'), $string);
        $string = str_replace(array('â', 'ê', 'î', 'ô', 'û'), array('a', 'e', 'i', 'o', 'u'), $string);
        $string = str_replace(array('ã', 'õ', 'ç'), array('a', 'o', 'c'), $string);
        
        
        //Retira todos os caracteres que não forem de A-Z à 0-9
        $string = preg_replace('/[^a-zA-Z0-9-\s]/', '', $string);
        
        
        //Substitui traço e espaco por nada
        $string = str_replace(' ', '-', $string);
        $string = str_replace('--', '-', $string);
        $string = str_replace('--', '-', $string);
        
        
        /**
         * Verifica se a data no formato MySQL foi passada via parametro.
         * Se nao, cria url sem data no final. Se sim, cria url com data
         * no final. 
         **/
        /*if (empty($data_my))
        {
            //Cria url nome no formato stringsemespacos (String)
            $string = "$string";
        }
        else
        {
            //Coloca data no formato BR
            $data_br = datas::my2BR($data_my);
            
            //Pega numero do mes
            $mes_numero = substr($data_br, 3, 2);
            
            //Pega nome extenso do mes
            $mes_nome = strtolower(substr(datas::pegaNomeMes($mes_numero), 0, 3));
            
            //Pega dia e ano
            $dia = substr($data_br, 0, 2);
            $ano = substr($data_br, 8, 4);
            
            //Cria url nome no formato nomeevento.08Nov10 (Nome do evento [ponto] Dia Mes Ano)
            $string = "$string.$dia$mes_nome$ano";
        }
        
        
        return $string;
    }*/
	
	static public function slugify($string,$slug='-')
	{
      $string = mb_strtolower($string);

      // Código ASCII das vogais
      $ascii['a'] = range(224, 230);
      $ascii['e'] = range(232, 235);
      $ascii['i'] = range(236, 239);
      $ascii['o'] = array_merge(range(242, 246), array(240, 248));
      $ascii['u'] = range(249, 252);

      // Código ASCII dos outros caracteres
      $ascii['b'] = array(223);
      $ascii['c'] = array(231);
      $ascii['d'] = array(208);
      $ascii['n'] = array(241);
      $ascii['y'] = array(253, 255);

      foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
      }

      $string = preg_replace(array_values($troca), array_keys($troca), $string);

      // Slug?
      if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
      }

      return $string;
  }
    
    
    
    
    
    /*
     * Retorna lista de estados do Brasil com abreviaçao
     * e nome completo
     *
     * @return: array
     */
    public static function pegaEstados()
    {
        //Cria array com lista de estado
        $lista_estados = array(
                                'ac' => 'Acre',
                                'al' => 'Alagoas',
                                'ap' => 'Amapá',
                                'am' => 'Amazonas',
                                'ba' => 'Bahia',
                                'ce' => 'Ceará',
                                'df' => 'Distrito Federal',
                                'es' => 'Espirito Santo',
                                'go' => 'Goiás',
                                'ma' => 'Maranhão',
                                'ms' => 'Mato Grosso do Sul',
                                'mt' => 'Mato Grosso',
                                'mg' => 'Minas Gerais',
                                'pa' => 'Pará',
                                'pb' => 'Paraíba',
                                'pr' => 'Paraná',
                                'pe' => 'Pernanbuco',
                                'pi' => 'Piauí',
                                'rj' => 'Rio de Janeiro',
                                'rn' => 'Rio Grande do Norte',
                                'rs' => 'Rio Grande do Sul',
                                'ro' => 'Rondônia',
                                'rr' => 'Roraima',
                                'sc' => 'Santa Catarina',
                                'sp' => 'São Paulo',
                                'se' => 'Sergipe',
                                'to' => 'Tocantis'
                              );


        return $lista_estados;
    }
    
    
    
    
    
    
    
    /*
     * Retorna nome do estado de acordo com a sigla passada
     *
     * @return: Nome Estado
     */
    public static function pegaNomeEstado($sigla)
    {
        //Pega lista de estados
        $lista_estados = utilidades::getEstados();


        //Define nome do estado
        $nome_estado = $lista_estados[$sigla];


        return $nome_estado;
    }
    
    
    
    
    
    
    /*
     * Retorna lista de paises com abreviaçao e nome completo
     *
     * @return: array
     */
    public static function pegaPaises()
    {
        //Cria array com lista de paises
        $lista_paises = array("AF" => "Afghanistan",
                              "AL" => "Albania",
                              "DZ" => "Algeria",
                              "AS" => "American Samoa",
                              "AD" => "Andorra",
                              "AO" => "Angola",
                              "AI" => "Anguilla",
                              "AQ" => "Antarctica",
                              "AG" => "Antigua And Barbuda",
                              "AR" => "Argentina",
                              "AM" => "Armenia",
                              "AW" => "Aruba",
                              "AU" => "Australia",
                              "AT" => "Austria",
                              "AZ" => "Azerbaijan",
                              "BS" => "Bahamas",
                              "BH" => "Bahrain",
                              "BD" => "Bangladesh",
                              "BB" => "Barbados",
                              "BY" => "Belarus",
                              "BE" => "Belgium",
                              "BZ" => "Belize",
                              "BJ" => "Benin",
                              "BM" => "Bermuda",
                              "BT" => "Bhutan",
                              "BO" => "Bolivia",
                              "BA" => "Bosnia And Herzegowina",
                              "BW" => "Botswana",
                              "BV" => "Bouvet Island",
                              "BR" => "Brazil",
                              "IO" => "British Indian Ocean Territory",
                              "BN" => "Brunei Darussalam",
                              "BG" => "Bulgaria",
                              "BF" => "Burkina Faso",
                              "BI" => "Burundi",
                              "KH" => "Cambodia",
                              "CM" => "Cameroon",
                              "CA" => "Canada",
                              "CV" => "Cape Verde",
                              "KY" => "Cayman Islands",
                              "CF" => "Central African Republic",
                              "TD" => "Chad",
                              "CL" => "Chile",
                              "CN" => "China",
                              "CX" => "Christmas Island",
                              "CC" => "Cocos (Keeling) Islands",
                              "CO" => "Colombia",
                              "KM" => "Comoros",
                              "CG" => "Congo",
                              "CD" => "Congo, The Democratic Republic Of The",
                              "CK" => "Cook Islands",
                              "CR" => "Costa Rica",
                              "CI" => "Cote D'Ivoire",
                              "HR" => "Croatia (Local Name: Hrvatska)",
                              "CU" => "Cuba",
                              "CY" => "Cyprus",
                              "CZ" => "Czech Republic",
                              "DK" => "Denmark",
                              "DJ" => "Djibouti",
                              "DM" => "Dominica",
                              "DO" => "Dominican Republic",
                              "TP" => "East Timor",
                              "EC" => "Ecuador",
                              "EG" => "Egypt",
                              "SV" => "El Salvador",
                              "GQ" => "Equatorial Guinea",
                              "ER" => "Eritrea",
                              "EE" => "Estonia",
                              "ET" => "Ethiopia",
                              "FK" => "Falkland Islands (Malvinas)",
                              "FO" => "Faroe Islands",
                              "FJ" => "Fiji",
                              "FI" => "Finland",
                              "FR" => "France",
                              "FX" => "France, Metropolitan",
                              "GF" => "French Guiana",
                              "PF" => "French Polynesia",
                              "TF" => "French Southern Territories",
                              "GA" => "Gabon",
                              "GM" => "Gambia",
                              "GE" => "Georgia",
                              "DE" => "Germany",
                              "GH" => "Ghana",
                              "GI" => "Gibraltar",
                              "GR" => "Greece",
                              "GL" => "Greenland",
                              "GD" => "Grenada",
                              "GP" => "Guadeloupe",
                              "GU" => "Guam",
                              "GT" => "Guatemala",
                              "GN" => "Guinea",
                              "GW" => "Guinea-Bissau",
                              "GY" => "Guyana",
                              "HT" => "Haiti",
                              "HM" => "Heard And Mc Donald Islands",
                              "VA" => "Holy See (Vatican City State)",
                              "HN" => "Honduras",
                              "HK" => "Hong Kong",
                              "HU" => "Hungary",
                              "IS" => "Iceland",
                              "IN" => "India",
                              "ID" => "Indonesia",
                              "IR" => "Iran (Islamic Republic Of)",
                              "IQ" => "Iraq",
                              "IE" => "Ireland",
                              "IL" => "Israel",
                              "IT" => "Italy",
                              "JM" => "Jamaica",
                              "JP" => "Japan",
                              "JO" => "Jordan",
                              "KZ" => "Kazakhstan",
                              "KE" => "Kenya",
                              "KI" => "Kiribati",
                              "KP" => "Korea, Democratic People's Republic Of",
                              "KR" => "Korea, Republic Of",
                              "KW" => "Kuwait",
                              "KG" => "Kyrgyzstan",
                              "LA" => "Lao People's Democratic Republic",
                              "LV" => "Latvia",
                              "LB" => "Lebanon",
                              "LS" => "Lesotho",
                              "LR" => "Liberia",
                              "LY" => "Libyan Arab Jamahiriya",
                              "LI" => "Liechtenstein",
                              "LT" => "Lithuania",
                              "LU" => "Luxembourg",
                              "MO" => "Macau",
                              "MK" => "Macedonia, Former Yugoslav Republic Of",
                              "MG" => "Madagascar",
                              "MW" => "Malawi",
                              "MY" => "Malaysia",
                              "MV" => "Maldives",
                              "ML" => "Mali",
                              "MT" => "Malta",
                              "MH" => "Marshall Islands",
                              "MQ" => "Martinique",
                              "MR" => "Mauritania",
                              "MU" => "Mauritius",
                              "YT" => "Mayotte",
                              "MX" => "Mexico",
                              "FM" => "Micronesia, Federated States Of",
                              "MD" => "Moldova, Republic Of",
                              "MC" => "Monaco",
                              "MN" => "Mongolia",
                              "MS" => "Montserrat",
                              "MA" => "Morocco",
                              "MZ" => "Mozambique",
                              "MM" => "Myanmar",
                              "NA" => "Namibia",
                              "NR" => "Nauru",
                              "NP" => "Nepal",
                              "NL" => "Netherlands",
                              "AN" => "Netherlands Antilles",
                              "NC" => "New Caledonia",
                              "NZ" => "New Zealand",
                              "NI" => "Nicaragua",
                              "NE" => "Niger",
                              "NG" => "Nigeria",
                              "NU" => "Niue",
                              "NF" => "Norfolk Island",
                              "MP" => "Northern Mariana Islands",
                              "NO" => "Norway",
                              "OM" => "Oman",
                              "PK" => "Pakistan",
                              "PW" => "Palau",
                              "PA" => "Panama",
                              "PG" => "Papua New Guinea",
                              "PY" => "Paraguay",
                              "PE" => "Peru",
                              "PH" => "Philippines",
                              "PN" => "Pitcairn",
                              "PL" => "Poland",
                              "PT" => "Portugal",
                              "PR" => "Puerto Rico",
                              "QA" => "Qatar",
                              "RE" => "Reunion",
                              "RO" => "Romania",
                              "RU" => "Russian Federation",
                              "RW" => "Rwanda",
                              "KN" => "Saint Kitts And Nevis",
                              "LC" => "Saint Lucia",
                              "VC" => "Saint Vincent And The Grenadines",
                              "WS" => "Samoa",
                              "SM" => "San Marino",
                              "ST" => "Sao Tome And Principe",
                              "SA" => "Saudi Arabia",
                              "SN" => "Senegal",
                              "SC" => "Seychelles",
                              "SL" => "Sierra Leone",
                              "SG" => "Singapore",
                              "SK" => "Slovakia (Slovak Republic)",
                              "SI" => "Slovenia",
                              "SB" => "Solomon Islands",
                              "SO" => "Somalia",
                              "ZA" => "South Africa",
                              "GS" => "South Georgia, South Sandwich Islands",
                              "ES" => "Spain",
                              "LK" => "Sri Lanka",
                              "SH" => "St. Helena",
                              "PM" => "St. Pierre And Miquelon",
                              "SD" => "Sudan",
                              "SR" => "Suriname",
                              "SJ" => "Svalbard And Jan Mayen Islands",
                              "SZ" => "Swaziland",
                              "SE" => "Sweden",
                              "CH" => "Switzerland",
                              "SY" => "Syrian Arab Republic",
                              "TW" => "Taiwan",
                              "TJ" => "Tajikistan",
                              "TZ" => "Tanzania, United Republic Of",
                              "TH" => "Thailand",
                              "TG" => "Togo",
                              "TK" => "Tokelau",
                              "TO" => "Tonga",
                              "TT" => "Trinidad And Tobago",
                              "TN" => "Tunisia",
                              "TR" => "Turkey",
                              "TM" => "Turkmenistan",
                              "TC" => "Turks And Caicos Islands",
                              "TV" => "Tuvalu",
                              "UG" => "Uganda",
                              "UA" => "Ukraine",
                              "AE" => "United Arab Emirates",
                              "GB" => "United Kingdom",
                              "US" => "United States",
                              "UM" => "United States Minor Outlying Islands",
                              "UY" => "Uruguay",
                              "UZ" => "Uzbekistan",
                              "VU" => "Vanuatu",
                              "VE" => "Venezuela",
                              "VN" => "Viet Nam",
                              "VG" => "Virgin Islands (British)",
                              "VI" => "Virgin Islands (U.S.)",
                              "WF" => "Wallis And Futuna Islands",
                              "EH" => "Western Sahara",
                              "YE" => "Yemen",
                              "YU" => "Yugoslavia",
                              "ZM" => "Zambia",
                              "ZW" => "Zimbabwe");


        return $lista_paises;
    }
    
    
    
    
    
    
    
    /*
     * Retorna nome do pais de acordo com a sigla passada
     *
     * @return: Nome Pais
     */
    public static function pegaNomePais($sigla)
    {
        //Pega lista de paises
        $lista_paises = utilidades::pegaPaises();


        //Define nome do pais
        $nome_pais = $lista_paises[$sigla];


        return $nome_pais;
    }
	
	
	
	


	/**
	 * Converte uma data completa no formato
	 * SQL para o formato brasileiro
	 */
	public static function dateToSQL($date,$sep='/',$new_sep='-')
	{
		/**
		 * $date -> data a ser convertida
		 */
		$date = explode($sep,trim($date));
		return $date[2].$new_sep.$date[1].$new_sep.$date[0];
		
	}
	
	
	
	


	/**
	 * Converte uma data completa no formato
	 * brasileiro para o formato SQL
	 */
	public static function dateToBr($date,$new_sep='/',$sep='-')
	{
		/**
		 * $date -> data a ser convertida
		 */
		$date = explode($sep,$date);
		return $date[2].$new_sep.$date[1].$new_sep.$date[0];	
	}






	/**
	 * Reduz um texto longo em um menor.
	 * Geralmente utilizado para encurtar descrições, etc.
	 * Ex.: (Esse é um exemplo de texto reduzido pelo...)
	 * Essa função impede que a última palavra fique cortada
	 * Ex.: (Esse texto é mui...)
	 */
	public static function reduceText($text,$lenght)
	{
		//Trata os texto
		$text = trim(substr($text,0,$lenght));
		//Converte em um array
		$text = explode(' ',$text);
		//Remove o último bloco de texto que pode estar cortado
		array_pop($text);
		//converte a array em texto novamente, já sem o último elemento
		$text = implode(' ',$text);
		
		//retorna o texto
		return $text;
	}
	
	
	
	


	/**
	 * Retorna o mês numérico no nome dele em português
	 */
	static public function mes($i)
	{
		/**
		 * $i -> armazena a representação numérica do mês
		 */
		//prepara os dados
		$i = (int)$i;
		//verifica o tipo e define o tamanho
		switch($i):
			case 1  : $mes = 'Janeiro';   break;
			case 2  : $mes = 'Fevereiro'; break;
			case 3  : $mes = 'Março';     break;
			case 4  : $mes = 'Abril';     break;
			case 5  : $mes = 'Maio';      break;
			case 6  : $mes = 'Junho';     break;
			case 7  : $mes = 'Julho';     break;
			case 8  : $mes = 'Agosto';    break;
			case 9  : $mes = 'Setembro';  break;
			case 10 : $mes = 'Outubro';   break;
			case 11 : $mes = 'Novembro';  break;
			case 12 : $mes = 'Dezembro';  break;
			//retorna falso caso o valor passado não seja válido
			default : $mes = ''; break;
		endswitch;
		
		//retorna a saída em uma matriz
		return $mes;
	}
	
	
	
	
	
	
	/**
	 * Converte a data no formato sql para slug
	 */	
	static public function dateToSlug($data)
	{
		//Separa a data
		$data = explode('-',$data);
		
		//Cria o slug
		$slug = $data[2].'-'.utilidades::slugify(utilidades::mes($data[1])).'-'.$data[0];
		
		//Retorna o slug da data
		return $slug;
	}
	
	
	
	
	
	
	/**
	 * Pega a data e hora atual
	 */	
	static public function curdate()
	{
		return date("Y-m-d");
	}
	
	
	/**
	 * Pega a data e hora atual
	 */	
	static public function now()
	{
		return date("Y-m-d H:i:s");
	}
	
	
	
	
	
	
	/**
	 * Retorna a extensão do arquivo
	 **/
	public function fileExt($file){
		/**
		 * $file -> Armazena o nome do arquivo
		 *          que se deseja descobrir a extensão.
		 */
		//explde o nome do arquivo em um array
		$ext = explode(".",$file);
		//verifica se há mais de um elemento na array
		if(count($ext)<=1):
			return false;
		//se existir mais de 1 elemento, retorna o último,
		//que é a provável extensão
		else:
			//armazena o último elemento da array
			return array_pop($ext);
		endif;
	}
	
	
	
	
	
	
	/**
	 * Retorna a extensão do arquivo
	 **/
	static public function toUTF8($string)
	{
		$iso88591_1 = utf8_decode($string);
		$iso88591_2 = iconv('UTF-8', 'ISO-8859-1', $string); 
		return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
	}






}