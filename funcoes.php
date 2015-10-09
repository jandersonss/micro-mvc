<?php

function geraMeta(){
	if(isset($_GET['menu'])){
		if($_GET['menu'] == 'noticia'){
			if(isset($_GET['id'])){
				$_GET['COD_NOTICIA'] = addslashes($_GET['id']);
				$res = mysql_query("SELECT *, UNIX_TIMESTAMP(noticias.DATA_NOTICIA) as DATA_UNIX
									FROM noticias, categorias
									WHERE noticias.COD_NOTICIA = '" . $_GET['COD_NOTICIA'] . "'
									AND noticias.COD_CATEGORIA = categorias.COD_CATEGORIA
									AND noticias.STATUS_NOTICIA = 'ONLINE'
									LIMIT 1");
				while($row = mysql_fetch_assoc($res)){
					?>

<meta name="description" content="<?php echo substr(strip_tags($row['TEXTO_NOTICIA']), 0, 190); ?>..." />
<meta name="expires" content="-1" />
<link rel="canonical" href="<?php echo "http://".$_SERVER["HTTP_HOST"]. geraLink("noticias", $row["COD_NOTICIA"], $row["TITULO_NOTICIA"]);?>" />
<meta property="og:url" content="<?php echo "http://".$_SERVER["HTTP_HOST"]. geraLink("noticias", $row["COD_NOTICIA"], $row["TITULO_NOTICIA"]);?>" />
<meta property="og:title" content="<?php echo $row['TITULO_NOTICIA']; ?>" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>/?menu=noticia&id=<?php echo $row['COD_NOTICIA']; ?>" />
<?php
if(file_exists("../fotos/noticias/" . $row['COD_NOTICIA'] . "/IMAGEM_NOTICIA_0.jpg")){
?><meta property="og:image" content="<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>/fotos/noticias/<?php echo $row['COD_NOTICIA']; ?>/IMAGEM_NOTICIA_0.jpg" />
<?php
}
?>
<meta property="og:site_name" content="Dr. Marcio" />
<meta property="fb:admins" content="315443205218155" />
					<?php
				}
			}
		}
	}
}

function banner($COD_LOCAL){

	$res = mysql_query("SELECT banner_banner.`COD_BANNER`,

							   banner_local.`W_LOCAL`,

							   banner_local.`H_LOCAL`,

							   banner_banner.`ARQUIVO_BANNER`,

							   banner_banner.`LINK_BANNER`,

							   banner_banner.`EXIBICOES_BANNER`,

							   banner_banner.SCRIPT_BANNER,

							   banner_filtros.`EXIBICOES_FILTRO`

						FROM banner_banner,

							 banner_local,

							 `rel_local_banner`,

							 `banner_filtros`

						WHERE `banner_banner`.`COD_BANNER` = `rel_local_banner`.`COD_BANNER`

						AND banner_local.`COD_LOCAL` = `rel_local_banner`.`COD_LOCAL`

						AND banner_banner.`STATUS_BANNER` = 'ONLINE'

						AND banner_filtros.`COD_BANNER` = banner_banner.`COD_BANNER`

						AND (banner_banner.`DATA_INI_BANNER` = 0 OR banner_banner.`DATA_INI_BANNER` <= NOW())

						AND (banner_banner.`DATA_FIM_BANNER` = 0 OR banner_banner.`DATA_FIM_BANNER` >= NOW())

						AND `banner_filtros`.`EXIBICOES_FILTRO` <> 1

						AND `banner_filtros`.`CLICK_FILTRO` <> 1

						AND `banner_local`.`COD_LOCAL` = " . $COD_LOCAL . "

						AND FIND_IN_SET(" . date('w') . ", banner_filtros.`SEMANA_FILTRO`)

						AND FIND_IN_SET(" . date('G') . ", banner_filtros.`HORA_FILTRO`)

						ORDER BY RAND()

						LIMIT 1");

	if(mysql_num_rows($res) > 0){

		$row = mysql_fetch_assoc($res);

		$arquivoExt = "/banner/" . $row['COD_BANNER'] . "." . strtolower($row['ARQUIVO_BANNER']);

		$arquivo = "/banner/" . $row['COD_BANNER'];

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . $arquivoExt)){

			//conta + 1 nas exibicoes

			if($row['EXIBICOES_BANNER'] == 0){

				$row['EXIBICOES_BANNER'] = 1;

			}

			if($row['EXIBICOES_FILTRO'] != 0){

				mysql_query("UPDATE banner_filtros SET EXIBICOES_FILTRO = EXIBICOES_FILTRO - 1 WHERE COD_BANNER = '" . $row['COD_BANNER'] . "'");

			}

			mysql_query("UPDATE banner_banner SET EXIBICOES_BANNER = '" . ($row['EXIBICOES_BANNER']+1) . "' WHERE COD_BANNER = '" . $row['COD_BANNER'] . "'");



			if($row['ARQUIVO_BANNER'] == 'SWF'){

				$flashVars1 = "";

				$flashVars2 = "";

				if(!empty($row['LINK_BANNER'])){

					$flashVars1 = '<param name="flashvars" value="lnk=' . $row['LINK_BANNER'] . '&amp;url=' . $row['LINK_BANNER'] . '" />';

					$flashVars2 = "'flashvars','lnk=" . $row['LINK_BANNER'] . "&amp;url=" . $row['LINK_BANNER'] . "',";

				}

				?>

				<script type="text/javascript">

AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','<?php echo $row['W_LOCAL']; ?>','height','<?php echo $row['H_LOCAL']; ?>','src','<?php echo $arquivo; ?>',<?php echo $flashVars2; ?>'quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','<?php echo $arquivo; ?>' ); //end AC code

</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="<?php echo $row['W_LOCAL']; ?>" height="<?php echo $row['H_LOCAL']; ?>">

                      <param name="movie" value="<?php echo $arquivoExt; ?>" />

                      <param name="quality" value="high" />

					  <?php echo $flashVars1; ?>

                      <embed src="<?php echo $arquivoExt; ?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="<?php echo $row['W_LOCAL']; ?>" height="<?php echo $row['H_LOCAL']; ?>"></embed>

          	      </object>

            	</noscript>

				<?php

			}else{

				if(!empty($row['LINK_BANNER'])){

					echo "<a href='" . $row['LINK_BANNER'] . "' target='_blank'>";

				}

				?>

				<img src="<?php echo $arquivoExt; ?>" width="<?php echo $row['W_LOCAL']; ?>" height="<?php echo $row['H_LOCAL']; ?>" />

				<?php

				if(!empty($row['LINK_BANNER'])){

					echo "</a>";

				}

			}

		}else{

			if(!empty($row['SCRIPT_BANNER'])){

				echo $row['SCRIPT_BANNER'];

			}

		}

	}

}

function geraTitulo(){

	$retorno = '';
	$titulo = '';

	$meta = '';

	if(isset($_GET['menu'])){
		if($_GET['menu'] == 'noticias'){
			$titulo .= 'Notícias | ';

		}elseif($_GET['menu'] == 'noticia' && isset($_GET['COD_NOTICIA'])){

			$_GET['COD_NOTICIA'] = addslashes($_GET['COD_NOTICIA']);
			$res = mysql_query("SELECT COD_NOTICIA, TITULO_NOTICIA, DESC_NOTICIA
								FROM noticias
								WHERE COD_NOTICIA = '" . $_GET['COD_NOTICIA'] . "'
								LIMIT 1");
			$row = mysql_fetch_assoc($res);
			$titulo .= $row['TITULO_NOTICIA'] . ' | ';
			$meta .= '<meta property="og:type" content="article"/>' . "\n";
			$meta .= '<meta property="og:title" content="' . $row['TITULO_NOTICIA'] . '"/>' . "\n";
			$meta .= '<meta property="og:description" content="' . strip_tags($row['DESC_NOTICIA']) . '"/>' . "\n";
			if(file_exists("../fotos/noticias/" . $row['COD_NOTICIA'] . "/IMAGEM_NOTICIA_0.jpg")){
				$meta .= '<meta property="og:image" content="http://'. $_SERVER['HTTP_HOST'].'/fotos/noticias/' . $row['COD_NOTICIA'] . '/IMAGEM_NOTICIA_0.jpg"/>' . "\n";
			}
			$meta .= '<meta property="fb:app_id" content="590242084338895"/>' . "\n";
			$meta .= '<meta property="og:site_name" content="' . $titulo . 'EC Vit&oacute;ria"/>' . "\n";
			$meta .= '<meta property="og:url" content="http://'. $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'] . '"/>' . "\n";

		}elseif($_GET['menu'] == 'pagina' && isset($_GET['COD_PAGINA'])){

			$_GET['COD_PAGINA'] = addslashes($_GET['COD_PAGINA']);
			$res = mysql_query("SELECT *
								FROM paginas
								WHERE COD_PAGINA = '" . $_GET['COD_PAGINA'] . "'
								LIMIT 1");
			$row = mysql_fetch_assoc($res);
			$titulo .= $row['TITULO_PAGINA'] . ' | ';

		}elseif($_GET['menu'] == 'galerias'){

			$titulo .= 'Galerias | ';

		}elseif($_GET['menu'] == 'galeria' && isset($_GET['COD_GALERIA'])){

			$_GET['COD_GALERIA'] = addslashes($_GET['COD_GALERIA']);

			require_once("phpFlickr/phpFlickr.php");
			$f = new phpFlickr("31023bc4bea5901e50cd08878af2daf5");
			$f->enableCache("fs", "../cache/");
			$galeria = $f->photosets_getInfo($_GET['COD_GALERIA']);


			$titulo .= utf8_decode($galeria['title']) . ' | ';
			$meta .= '<meta property="og:type" content="article"/>' . "\n";
			$meta .= '<meta property="og:title" content="' . utf8_decode($galeria['title']) . '"/>' . "\n";
			$meta .= '<meta property="og:description" content="' . utf8_decode($galeria['title']) . '"/>' . "\n";
			//if(file_exists("../fotos/galerias/" . $row['COD_GALERIA'] . "/IMAGEM_GALERIA_0.jpg")){
				$meta .= '<meta property="og:image" content="http://farm' . $galeria['farm'] . '.staticflickr.com/' . $galeria['server'] . '/' . $galeria['primary'] . '_' . $galeria['secret'] . '.jpg"/>' . "\n";
			//}

			$meta .= '<meta property="fb:app_id" content="590242084338895"/>' . "\n";
			$meta .= '<meta property="og:site_name" content="' . $titulo . 'Prefeitura de Lauro de Freitas"/>' . "\n";
			$meta .= '<meta property="og:url" content="http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"/>' . "\n";
		}
	}

	$titulo .= 'Prefeitura de Lauro de Freitas';

	$retorno .= '<title>' . $titulo . '</title>' . "\n";
	$retorno .= $meta;

	return $retorno;
}


function remTag($texto){

	$texto = ereg_replace("<[^>]*>", "", $texto);

	return $texto;

}

function geraLink($pagina, $cod, $titulo){

	return "/" . $pagina . "/" . $cod . "," . converteUrl($titulo) . ".html";

}

function geraLinkFoto($pagina, $cod, $titulo, $num){

	return "/" . $pagina . "/" . $cod . "," . converteUrl($titulo) . "-" . $num . ".jpg";

}

/*function converteUrl($String){



		$Separador = "-";



		$String = trim($String); //Removendo espaços do inicio e do fim da string

		$String = strtolower($String); //Convertendo a string para minúsculas

		$String = strip_tags($String); //Retirando as tags HTML e PHP da string

		$String = eregi_replace("[[:space:]]", $Separador, $String); //Substituindo todos os espaços por $Separador



		$String = eregi_replace("[çÇ]", "c", $String); //Substituindo caracteres especiais pela letra respectiva

		$String = eregi_replace("[áÁäÄàÀãÃâÂ]", "a", $String);

		$String = eregi_replace("[éÉëËèÈêÊ]", "e", $String);

		$String = eregi_replace("[íÍïÏìÌîÎ]", "i", $String);

		$String = eregi_replace("[óÓöÖòÒõÕôÔ]", "o", $String);

		$String = eregi_replace("[úÚüÜùÙûÛ]", "u", $String);



		$String = eregi_replace("(\()|(\))", $Separador, $String); //Substituindo outros caracteres por "$Separador"

		$String = eregi_replace("(\/)|(\\\)", $Separador, $String);

		$String = eregi_replace("(\[)|(\])", $Separador, $String);

		$String = eregi_replace("[@#\$%&\*\+=\|º]", $Separador, $String);

		$String = eregi_replace("[;:'\"<>,\.?!_-]", $Separador, $String);

		$String = eregi_replace('[""]', $Separador, $String);

		$String = eregi_replace("(ª)+", $Separador, $String);

		$String = eregi_replace("[`´~^°]", $Separador, $String);



		$String = eregi_replace("($Separador)+", $Separador, $String); //Removendo o excesso de "$Separador" por apenas um



		$String = substr($String, 0, 100); //Quebrando a string para um tamanho pré-definido



		$String = eregi_replace("(^($Separador)+)|(($Separador)+$)", "", $String); //Removendo o "$Separador" do inicio e fim da string



		return $String;

}*/


function converteUrl($String){
	return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), removeAcento($String)));
}


function removeAcento($String){
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	return str_replace($a, $b, $String);
}


function pagina($results_tot, $results_parc, $qtd_pag, $num_pag, $aux_link){

	$menor = $num_pag - 5;

	$maior = $num_pag + 5;

	$aux = (int)ceil($results_tot/$qtd_pag);

	if($maior > $aux-5){

		$menor -= 5;

		$maior = $aux;

	}

	if($menor < 1){

		$menor = 1;

		$maior += 5;

		if($maior > $aux-5){

			$maior = $aux;

		}

	}

	if($menor > 1){

		echo "<a href='/" . $aux_link . ",,0," . $_GET['qtd_pag'] . ".html";





		echo "'>1</a>... ";

	}

	for($i=$menor;$i<=$maior;$i++){

		if($i == $num_pag+1){

			echo "<font color='#FF0000'>" . $i . "</font> ";

		}else{



			echo "<a href='/" . $aux_link . "num_pag=" . ($i-1) . "&qtd_pag=" . $_GET['qtd_pag'] . "";

			echo "'>" . $i . "</a> ";

		}

	}

	if($maior < $aux){

		echo "...<a href='/" . $aux_link . "num_pag=" . ($aux-1) . "&qtd_pag" . $_GET['qtd_pag'] . "";



		echo "'>" . $aux . "</a> ";

	}

}



function GetXMLTree ($xmldata)

{

	// we want to know if an error occurs

	ini_set ('track_errors', '1');



	$xmlreaderror = false;



	$parser = xml_parser_create ('ISO-8859-1');

	xml_parser_set_option ($parser, XML_OPTION_SKIP_WHITE, 1);

	xml_parser_set_option ($parser, XML_OPTION_CASE_FOLDING, 0);

	if (!xml_parse_into_struct ($parser, $xmldata, $vals, $index)) {

		$xmlreaderror = true;

		echo "";

	}

	xml_parser_free ($parser);



	if (!$xmlreaderror) {

		$result = array ();

		$i = 0;

		if (isset ($vals [$i]['attributes']))

			foreach (array_keys ($vals [$i]['attributes']) as $attkey)

			$attributes [$attkey] = $vals [$i]['attributes'][$attkey];



		$result [$vals [$i]['tag']] = array_merge ($attributes, GetChildren ($vals, $i, 'open'));

	}



	ini_set ('track_errors', '0');

	return $result;

}



function GetChildren ($vals, &$i, $type)

{

	if ($type == 'complete') {

		if (isset ($vals [$i]['value']))

			return ($vals [$i]['value']);

		else

			return '';

	}



	$children = array (); // Contains node data



	/* Loop through children */

	while ($vals [++$i]['type'] != 'close') {

		$type = $vals [$i]['type'];

		// first check if we already have one and need to create an array

		if (isset ($children [$vals [$i]['tag']])) {

			if (is_array ($children [$vals [$i]['tag']])) {

				$temp = array_keys ($children [$vals [$i]['tag']]);

				// there is one of these things already and it is itself an array

				if (is_string ($temp [0])) {

					$a = $children [$vals [$i]['tag']];

					unset ($children [$vals [$i]['tag']]);

					$children [$vals [$i]['tag']][0] = $a;

				}

			} else {

				$a = $children [$vals [$i]['tag']];

				unset ($children [$vals [$i]['tag']]);

				$children [$vals [$i]['tag']][0] = $a;

			}



			$children [$vals [$i]['tag']][] = GetChildren ($vals, $i, $type);

		} else

			$children [$vals [$i]['tag']] = GetChildren ($vals, $i, $type);

		// I don't think I need attributes but this is how I would do them:

		if (isset ($vals [$i]['attributes'])) {

			$attributes = array ();

			foreach (array_keys ($vals [$i]['attributes']) as $attkey)

			$attributes [$attkey] = $vals [$i]['attributes'][$attkey];

			// now check: do we already have an array or a value?

			if (isset ($children [$vals [$i]['tag']])) {

				// case where there is an attribute but no value, a complete with an attribute in other words

				if ($children [$vals [$i]['tag']] == '') {

					unset ($children [$vals [$i]['tag']]);

					$children [$vals [$i]['tag']] = $attributes;

				}

				// case where there is an array of identical items with attributes

				elseif (is_array ($children [$vals [$i]['tag']])) {

					$index = count ($children [$vals [$i]['tag']]) - 1;

					// probably also have to check here whether the individual item is also an array or not or what... all a bit messy

					if ($children [$vals [$i]['tag']][$index] == '') {

						unset ($children [$vals [$i]['tag']][$index]);

						$children [$vals [$i]['tag']][$index] = $attributes;

					}

					$children [$vals [$i]['tag']][$index] = array_merge ($children [$vals [$i]['tag']][$index], $attributes);

				} else {

					$value = $children [$vals [$i]['tag']];

					unset ($children [$vals [$i]['tag']]);

					$children [$vals [$i]['tag']]['value'] = $value;

					$children [$vals [$i]['tag']] = array_merge ($children [$vals [$i]['tag']], $attributes);

				}

			} else

				$children [$vals [$i]['tag']] = $attributes;

		}

	}



	return $children;

}

function enquete($local){

	echo "<script language=\"javascript\" type=\"text/javascript\" src=\"/_js/funcoes.js\"></script>";

	echo "<div id='enquete_div'>";

	$res = mysql_query("SELECT COD_PERGUNTA

						FROM enq2009_pergunta

						WHERE STATUS_PERGUNTA = 'ONLINE'

						AND LOCAL_PERGUNTA = '" . $local . "'

						ORDER BY RAND()

						LIMIT 1");

	$row = mysql_fetch_assoc($res);

	$res2 = mysql_query("SELECT enq2009_pergunta.`COD_PERGUNTA`,

								enq2009_pergunta.`DESC_PERGUNTA`,

								enq2009_resposta.`COD_RESPOSTA`,

								enq2009_resposta.`DESC_RESPOSTA`,

								 (SELECT COUNT(COD_VOTO)

									FROM enq2009_voto

									WHERE enq2009_voto.COD_RESPOSTA = `enq2009_resposta`.`COD_RESPOSTA`) as VOTOS

						FROM enq2009_pergunta,

							 enq2009_resposta

						WHERE enq2009_pergunta.`COD_PERGUNTA` = enq2009_resposta.`COD_PERGUNTA`

						AND `enq2009_pergunta`.`LOCAL_PERGUNTA` = '" . $local . "'

						AND enq2009_pergunta.`STATUS_PERGUNTA` = 'ONLINE'

						AND enq2009_pergunta.COD_PERGUNTA = '" . $row['COD_PERGUNTA'] . "'");

	//echo "<form action='#' method='post' name='enquete'>";

	//echo "<input name='COD_PERGUNTA' type='hidden' value='" . $row['COD_PERGUNTA'] . "' />";

	$i = 0;

	$aux = array();

	$total = 0;

	while($row2 = mysql_fetch_assoc($res2)){

		array_push($aux, $row2);

		$total += $row2['VOTOS'];

		if(isset($voto[$row2['COD_RESPOSTA']])){

			$voto[$row2['COD_RESPOSTA']] += $row2['VOTOS'];

		}else{

			$voto[$row2['COD_RESPOSTA']] = $row2['VOTOS'];

		}

	}

	foreach($aux as $row2){

		if($i == 0){

			echo "<p style='text-align: left;'><strong>" . $row2['DESC_PERGUNTA'] . "</strong></p>

			<div id='polls-2-ans' class='wp-polls-ans'><ul class='wp-polls-ul'>

			";

		}

		$i++;

		if(!isset($_COOKIE['enquete'][$row['COD_PERGUNTA']])){

			echo "<li><input onclick=\"ajaxEnquete('" . $row2['COD_PERGUNTA'] . "', '" . $row2['COD_RESPOSTA'] . "', '" . $local . "')\" name='COD_RESPOSTA' value='" . $row2['COD_RESPOSTA'] . "' type='radio'><label for='poll-answer-6'>" . $row2['DESC_RESPOSTA'] . "</label></li>";

		}else{

			echo "<li>" . number_format(round(100*($voto[$row2['COD_RESPOSTA']]/$total),2), 2, ',', '.') . "% - <label for='poll-answer-6'>" . $row2['DESC_RESPOSTA'] . "</label></li>";

			echo "<li><img src=\"/_img/enq_" . $i . ".jpg\" height=\"10\" width=\"" . round((100*($voto[$row2['COD_RESPOSTA']]/$total)*2)+1,0) . "\" /></li>";

		}

	}

	echo "</ul>";

	//if(!isset($_COOKIE['enquete'][$row['COD_PERGUNTA']])){

	//	echo "<p style='text-align: left;'><input src='/capa_arquivos/bot_vot.jpg' name='vote' value='   Votar   ' type='image'> <a href='#'><img src='/capa_arquivos/botao_resultados.gif' alt='botao resultado'></a></p>";

	//}

	echo "</div>";

	//echo "</form>";

	echo "</div>";

}



function linkYoutube($url) {

	if(strstr($url,"/v/")){

		$aux = explode("v/",$url);

		$aux2 = explode("?", $aux[1]);

		$cod_youtube = $aux2[0];

		echo $cod_youtube;

	}elseif(strstr($url, "v=")) {

		$aux = explode("v=", $url);

		$aux2 = explode("&", $aux[1]);

		$cod_youtube = $aux2[0];

		echo $cod_youtube;

	}elseif(strstr($url, "/embed/")) {

		$aux = explode("/embed/", $url);

		$cod_youtube = $aux[1];

		echo $cod_youtube;

	}elseif(strstr($url, "be/")) {

		$aux = explode("be/", $url);

		$cod_youtube = $aux[1];

		echo $cod_youtube;

	}



}

function returnlinkYoutube($url) {

	if(strstr($url,"/v/")){

		$aux = explode("v/",$url);

		$aux2 = explode("?", $aux[1]);

		$cod_youtube = $aux2[0];

		return $cod_youtube;

	}elseif(strstr($url, "v=")) {

		$aux = explode("v=", $url);

		$aux2 = explode("&", $aux[1]);

		$cod_youtube = $aux2[0];

		return $cod_youtube;

	}elseif(strstr($url, "/embed/")) {

		$aux = explode("/embed/", $url);

		$cod_youtube = $aux[1];

		return $cod_youtube;

	}elseif(strstr($url, "be/")) {

		$aux = explode("be/", $url);

		$cod_youtube = $aux[1];

		return $cod_youtube;

	}



}

function limitarTexto($frase, $limite) {

	$count = strlen($frase);

	if ($count > $limite) {

		$frase = substr($frase, 0, strrpos(substr($frase, 0, $limite), ' ')) . '...';

	}

	return $frase;

}



function getExtensao($diretorio) {

	if(is_dir($diretorio)) {


		$ponteiro = opendir($diretorio);

		while($arquivos = readdir($ponteiro)) {;

			$itens[] = $arquivos;

		}

		foreach($itens as $lista) {

			if($lista != "." && $lista != "..") {

				$arquivo = $lista;

			}

		}



	}

	$extensao = substr($arquivo,-3);

	return $extensao;

}



function paginacao($results_tot, $results_parc, $qtd_pag, $num_pag, $aux_link){

	$menor = $num_pag - 5;

	$maior = $num_pag + 5;

	$aux = (int)ceil($results_tot/$qtd_pag);

	if($maior > $aux-5){

		$menor -= 5;

		$maior = $aux;

	}

	if($menor < 1){

		$menor = 1;

		$maior += 5;

		if($maior > $aux-5){

			$maior = $aux;

		}

	}

	if($menor > 1){

		echo "<li><a href='/" . $aux_link . ",,0," . $qtd_pag . ".html";





		echo "'>1</a>...</li> ";

	}

	for($i=$menor;$i<=$maior;$i++){

		if($i == $num_pag+1){

			echo "<li class='current'><a href='#' >" . $i . "</a></li> ";

		}else{



			echo "<li><a href='/" . $aux_link . "num_pag=" . ($i-1) . "&qtd_pag=" . $qtd_pag . "";

			echo "'>" . $i . "</a></li> ";

		}

	}

	if($maior < $aux){

		echo "<li>...</li><li><a href='/" . $aux_link . "num_pag=" . ($aux-1) . "&qtd_pag" . $qtd_pag . "";



		echo "'>" . $aux . "</a></li> ";

	}

}

function paginacao2($results_tot, $results_parc, $qtd_pag, $num_pag, $aux_link){
	$menor = $num_pag - 5;
	$maior = $num_pag + 5;
	$aux = (int)ceil($results_tot/$qtd_pag);
	if($maior > $aux-5){
		$menor -= 5;
		$maior = $aux;
	}
	if($menor < 1){
		$menor = 1;
		$maior += 5;
		if($maior > $aux-5){
			$maior = $aux;
		}
	}
	if($menor > 1){
		echo "<li><a href='/" . $aux_link . "/,,0.html";


		echo "'>1</a>...</li> ";
	}
	for($i=$menor;$i<=$maior;$i++){
		if($i == $num_pag+1){
			echo "<li class='active'><a href='#' >" . $i . "</a></li> ";
		}else{

			echo "<li><a href='/" . $aux_link . "/,," . ($i-1) . ".html";
			echo "'>" . $i . "</a></li> ";
		}
	}
	if($maior < $aux){
		echo "<li>...</li><li><a href='/" . $aux_link . "/,," . ($aux-1) . ".html";

		echo "'>" . $aux . "</a></li> ";
	}
}

?>