<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Char
*/

function nwin($link='',$w=200,$h=50,$resize=1,$scroll=0)
	{
		$sx = 'onclick="NewWindow=window.open(\'.$link.\',\'newwin\',\'scrollbars=no,resizable=no,width='+$w+',height='+$h+',top=10,left=10\'); NewWindow.focus(); void(0);} "';
		return($sx);
	}
	
function numberformat($vlr,$nc)
	{
	$nv = number_format($vlr,$nc);
	$nv = troca($nv,'.','#');
	$nv = troca($nv,',','.');
	$nv = troca($nv,'#',',');
	if ($nv == '0,00') { $nv = '<CENTER>-</CENTER>'; }
	return($nv);
	}

function ShowLink($link,$tipo='0',$target='',$label='')
	{
		$path = '';	$filename = 'icone_link.png';
		$fl = array('img/','../img/','../_include/img','_include/img');
		for ($r=0;$r < count($fl);$r++)
			{
				if (file_exists($fl[$r].$filename)) { $path = $fl[$r]; }
			}	
		if (strlen($target) > 0) { $tag = ' target="'.$target.'"';}
		if (strlen($link) ==0 ) { return(''); }
		switch($tipo)
			{
			case '1':
				$lk = '<A HREF="'.$link.'" title="'.$label.'" '.$tag.'>';
				$lk .= '<img src="'.$path.'icone_link.png" height="16" border="0">';
				$lk .= '</A>';
				break;
			default:
				$lk = '<A HREF="'.$link.'" title="'.$label.'" '.$tag.'>';
				$lk .= $link;
				$lk .= '</A>';
				break; 
			}
		return($lk);
	}
	
function customError_old($errno, $errstr, $errfile, $errline, $errcontext)
  {
  global $secu,$base,$base_name,$user_log,$debug,$ttsql,$rlt,$sql_query;
  if ($errno != '8')
  		{
		$email = 'brapcici@gmail.com';
		$tee = '<table width="600" bordercolor="#ff0000" border="3" align="center">';
		$tee .= '<TR><TD bgcolor="#ff0000" align="center"><FONT class="lt2"><FONT COLOR=white><B>ERRO  -['.$base.']-'.$base_name.'-</B></TD></TR>';
		$tee .= '<TR><TD align="center"><B><TT>';
		$tee .= 'Erro NÃºmero #'.$errno;
		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>Remote Address: '.$_SERVER['REMOTE_ADDR'];
		$tee .= '<BR>Metodo: '.$_SERVER['REQUEST_METHOD'];
		$tee .= '<BR>Nome da pÃ¡gina: '.$_SERVER['SCRIPT_NAME'];
		$tee .= '<BR>DomÃ­nio: '.$_SERVER['SERVER_NAME'];
		$tee .= '<BR>Data: '.date("d/m/Y H:i:s");
		
		if (strlen(trim($user_log)) > 0) { $tee .= '<TR><TD><TT>'; $tee .= 'User: '.$user_log; }
		if ($base == 'pgsql') { $tee .= '<TR><TD><B><TT>'; $tee .= pg_last_error(); }
		
		if (strlen(trim($sql_query)) > 0) { $tee .= '<TR><TD><TT>SQL:'.$sql_query; $tee .= $ttsql; }

		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>File: '.$errstr;
		$tee .= '<BR>Line: '.$errline;
		$tee .= '<BR>File: '.$errfile;
		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>Request URI:'.$_SERVER['REQUEST_URI'];
		$tee .= '<TR><TD><TT>';
		$args = $_SERVER['argv'];
		for ($rrr=0;$rrr < count($args);$rrr++)
			{ $tee .= 'args['.$rrr.'] == '.$args[$rrr].'<BR>'; }

		
		$tee .= '</table>';
		if ($debug == 1) { echo $tee; }
//		if ($debug == 3) { echo 'Muitas conexÃµes, aguarde....'; }
		
	
		$headers .= 'To: Brapci (Monitoramento) <brapcici@gmail.com>' . "\r\n";
		$headers .= 'From: BancoSQL (PG) <rene@sisdoc.com.br>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		

		mail($email, 'Erros de Script'.$secu, $tee, $headers);
				
		die();
		}
  } 

////////////////////////////////////////
function redireciona($pg) { redirecina($pg); }
function redirecina($pg)
	{
	header("Location: ".$pg);
	echo 'Stoped'; exit;
	}


function checkpost($_P)
	{
	global $secu;
	$chkp = substr(md5($_P.$secu),5,10);
	return($chkp);
	}
	
function dv($nrv)
	{
	$to = 0;
	$nrv = trim(sonumero($nrv));
	$trv = round(strlen($nrv));
	for ($tr=0;$tr < $trv;$tr++)
		{
		$ttr1 = ($tr/2);
		$ttr2 = round($tr/2);
		if ($ttr1 == $ttr2)
			{ $to = $to + round(substr($nrv,$tr,1)); }
			else
			{ $to = $to + round(substr($nrv,$tr,1))*7; }
		}
	while ($to > 10) { $to = $to - 10; }
	return($to);
	}
function splitx($in,$string)
	{
	$string .= $in;
	$vr = array();
	while (strpos(' '.$string,$in))
		{
		$vp = strpos($string,$in);
		$v4 = trim(substr($string,0,$vp));
		$string = trim(substr($string,$vp+1,strlen($string)));
		if (strlen($v4) > 0)
			{ array_push($vr,$v4); }
		}
	return($vr);
	}

function fmt($vlr=0,$dec=0)
	{
		if ($vlr == 0) { return('&nbsp;'); }
		$sx = number_format($vlr,$dec,',','.');
		return($sx);
	}
function fmt_data($data)
	{
		$data = round($data);
		if ($data < 19100000) { return(""); }
		$data = substr($data,6,2).'/'.substr($data,4,2).'/'.substr($data,0,4);
		return($data);
	}
function strzero($ddx,$ttz)
	{
	$ddx = round($ddx);
	while (strlen($ddx) < $ttz)
		{ $ddx = "0".$ddx; }
	return($ddx);
	}

function sonumero($it)
	{
	$rlt = '';
	for ($ki=0;$ki < strlen($it);$ki++)
		{
		$ord = ord(substr($it,$ki,1));
		if (($ord >= 48) and ($ord <= 57)) { $rlt = $rlt . substr($it,$ki,1); }
		}   
	return $rlt;
	}

function page()
	{
	$page = $_SERVER['SCRIPT_NAME'];
	while ($pos = strpos(' '.$page,'/'))
		{ $page = substr($page,$pos,strlen($page)); }
	return($page);
	}
	
function troca($qutf,$qc,$qt)
	{
	if (is_array($qutf))
		{
			print_r($qutf);
			exit;
		}
	return(str_replace(array($qc), array($qt),$qutf));
	}
	
function charConv($ddx)
	{
	while (strpos($ddx,'&#') > 0)
		{
		$ix = strpos($ddx,'&#');
		$ivlr = substr($ddx,$ix,6);
		$icha = char_ISO_Latin_1($ivlr);
		$ddx = troca($ddx,$ivlr,$icha);
		}
	$ddx = char_ISO_Latin_2($ddx);
	return($ddx);
	}

function char_ISO_Latin_2($str)
{
	    $codigo_acentos = array(
	    '/&Agrave;/','/&Aacute;/','/&Acirc;/','/&Atilde;/','/&Auml;/','/&Aring;/',
	    '/&agrave;/','/&aacute;/','/&acirc;/','/&atilde;/','/&auml;/','/&aring;/',
	    '/&Ccedil;/',
	    '/&ccedil;/',
	    '/&Egrave;/','/&Eacute;/','/&Ecirc;/','/&Euml;/',
	    '/&egrave;/','/&eacute;/','/&ecirc;/','/&euml;/',
	    '/&Igrave;/','/&Iacute;/','/&Icirc;/','/&Iuml;/',
	    '/&igrave;/','/&iacute;/','/&icirc;/','/&iuml;/',
	    '/&Ntilde;/',
	    '/&ntilde;/',
	    '/&Ograve;/','/&Oacute;/','/&Ocirc;/','/&Otilde;/','/&Ouml;/',
	    '/&ograve;/','/&oacute;/','/&ocirc;/','/&otilde;/','/&ouml;/',
	    '/&Ugrave;/','/&Uacute;/','/&Ucirc;/','/&Uuml;/',
	    '/&ugrave;/','/&uacute;/','/&ucirc;/','/&uuml;/',
	    '/&Yacute;/',
	    '/&yacute;/','/&yuml;/',
	    '/&ordf;/',
	    '/&ordm;/');
	 
	    $acentos = array(
	    'À','Á','Â','Ã','Ä','Å',
	    'à','á','â','ã','ä','å',
	    'Ç',
	    'ç',
	    'È','É','Ê','Ë',
	    'è','é','ê','ë',
	    'Ì','Í','Î','Ï',
	    'ì','í','î','ï',
	    'Ñ',
	    'ñ',
	    'Ò','Ó','Ô','Õ','Ö',
	    'ò','ó','ô','õ','ö',
	    'Ù','Ú','Û','Ü',
	    'ù','ú','û','ü',
	    'Ý',
	    'ý','ÿ',
	    'ª',
	    'º');
	 
return preg_replace($codigo_acentos, $acentos, $str);
}
	
function char_ISO_Latin_1($ddv)
	{
	////// ISO Latin-1 Characters and Control Characters
	$ddr = '?';
	if ($ddv == '&#160;') { $ddr = ' '; }
	if ($ddv == '&#161;') { $ddr = '¡'; }
	if ($ddv == '&#162;') { $ddr = '¢'; }
	if ($ddv == '&#163;') { $ddr = '£'; }
	if ($ddv == '&#164;') { $ddr = '¤'; }
	if ($ddv == '&#165;') { $ddr = '¥'; }
	if ($ddv == '&#166;') { $ddr = '¦'; }
	if ($ddv == '&#167;') { $ddr = '§'; }
	if ($ddv == '&#168;') { $ddr = '¨'; }
	if ($ddv == '&#169;') { $ddr = '©'; }

	if ($ddv == '&#170;') { $ddr = 'ª'; }
	if ($ddv == '&#171;') { $ddr = '«'; }
	if ($ddv == '&#172;') { $ddr = '¬'; }
	if ($ddv == '&#173;') { $ddr = ' '; }
	if ($ddv == '&#174;') { $ddr = '®'; }
	if ($ddv == '&#175;') { $ddr = '¯'; }
	if ($ddv == '&#176;') { $ddr = '·'; }
	if ($ddv == '&#177;') { $ddr = '±'; }
	if ($ddv == '&#178;') { $ddr = '²'; }
	if ($ddv == '&#179;') { $ddr = '³'; }

	if ($ddv == '&#180;') { $ddr = '´'; }
	if ($ddv == '&#181;') { $ddr = 'µ'; }
	if ($ddv == '&#182;') { $ddr = '¶'; }
	if ($ddv == '&#183;') { $ddr = '·'; }
	if ($ddv == '&#184;') { $ddr = '¸'; }
	if ($ddv == '&#185;') { $ddr = '¹'; }
	if ($ddv == '&#186;') { $ddr = 'º'; }
	if ($ddv == '&#187;') { $ddr = '»'; }
	if ($ddv == '&#188;') { $ddr = '¼'; }
	if ($ddv == '&#189;') { $ddr = '½'; }

	if ($ddv == '&#190;') { $ddr = '¾'; }
	if ($ddv == '&#191;') { $ddr = '¿'; }
	if ($ddv == '&#192;') { $ddr = 'À'; }
	if ($ddv == '&#193;') { $ddr = 'Á'; }
	if ($ddv == '&#194;') { $ddr = 'Â'; }
	if ($ddv == '&#195;') { $ddr = 'Ã'; }
	if ($ddv == '&#196;') { $ddr = 'Ä'; }
	if ($ddv == '&#197;') { $ddr = 'Å'; }
	if ($ddv == '&#198;') { $ddr = 'Æ'; }
	if ($ddv == '&#199;') { $ddr = 'Ç'; }

	if ($ddv == '&#200;') { $ddr = 'È'; }
	if ($ddv == '&#201;') { $ddr = 'É'; }
	if ($ddv == '&#202;') { $ddr = 'Ê'; }
	if ($ddv == '&#203;') { $ddr = 'Ë'; }
	if ($ddv == '&#204;') { $ddr = 'Ì'; }
	if ($ddv == '&#205;') { $ddr = 'Í'; }
	if ($ddv == '&#206;') { $ddr = 'Î'; }
	if ($ddv == '&#207;') { $ddr = 'Ï'; }
	if ($ddv == '&#208;') { $ddr = 'Ð'; }
	if ($ddv == '&#209;') { $ddr = 'Ñ'; }

	if ($ddv == '&#210;') { $ddr = 'Ò'; }
	if ($ddv == '&#211;') { $ddr = 'Ó'; }
	if ($ddv == '&#212;') { $ddr = 'Ô'; }
	if ($ddv == '&#213;') { $ddr = 'Õ'; }
	if ($ddv == '&#214;') { $ddr = 'Ö'; }
	if ($ddv == '&#215;') { $ddr = '×'; }
	if ($ddv == '&#216;') { $ddr = 'Ø'; }
	if ($ddv == '&#217;') { $ddr = 'Ù'; }
	if ($ddv == '&#218;') { $ddr = 'Ú'; }
	if ($ddv == '&#219;') { $ddr = 'Û'; }

	if ($ddv == '&#220;') { $ddr = 'Ü'; }
	if ($ddv == '&#221;') { $ddr = 'Ý'; }
	if ($ddv == '&#222;') { $ddr = 'Þ'; }
	if ($ddv == '&#223;') { $ddr = 'ß'; }
	if ($ddv == '&#224;') { $ddr = 'à'; }
	if ($ddv == '&#225;') { $ddr = 'á'; }
	if ($ddv == '&#226;') { $ddr = 'â'; }
	if ($ddv == '&#227;') { $ddr = 'ã'; }
	if ($ddv == '&#228;') { $ddr = 'ä'; }
	if ($ddv == '&#229;') { $ddr = 'å'; }

	if ($ddv == '&#230;') { $ddr = 'æ'; }
	if ($ddv == '&#231;') { $ddr = 'ç'; }
	if ($ddv == '&#232;') { $ddr = 'è'; }
	if ($ddv == '&#233;') { $ddr = 'é'; }
	if ($ddv == '&#234;') { $ddr = 'ê'; }
	if ($ddv == '&#235;') { $ddr = 'ë'; }
	if ($ddv == '&#236;') { $ddr = 'ì'; }
	if ($ddv == '&#237;') { $ddr = 'í'; }
	if ($ddv == '&#238;') { $ddr = 'î'; }
	if ($ddv == '&#239;') { $ddr = 'ï'; }

	if ($ddv == '&#240;') { $ddr = 'ð'; }
	if ($ddv == '&#241;') { $ddr = 'ñ'; }
	if ($ddv == '&#242;') { $ddr = 'ò'; }
	if ($ddv == '&#243;') { $ddr = 'ó'; }
	if ($ddv == '&#244;') { $ddr = 'ô'; }
	if ($ddv == '&#245;') { $ddr = 'õ'; }
	if ($ddv == '&#246;') { $ddr = 'ö'; }
	if ($ddv == '&#247;') { $ddr = '÷'; }
	if ($ddv == '&#248;') { $ddr = 'ø'; }
	if ($ddv == '&#249;') { $ddr = 'ù'; }

	if ($ddv == '&#250;') { $ddr = 'ú'; }
	if ($ddv == '&#251;') { $ddr = 'û'; }
	if ($ddv == '&#252;') { $ddr = 'ü'; }
	if ($ddv == '&#253;') { $ddr = 'ý'; }
	if ($ddv == '&#254;') { $ddr = 'þ'; }
	if ($ddv == '&#255;') { $ddr = 'ÿ'; }
	
	return($ddr);
	}

function charset_start()
	{
	global $qcharset,$charset;
	if (($qcharset=='UTF8') or ($charset == 'UTF8'))
		{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		return("UFT8");
		}
	else
		{
		return("ASCII");
		}
	}
	
function utf8_detect($utt)
	{
	$utt = ' '.$utt;
	$xok = 0;
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ã')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('É')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Í')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ó')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ú')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('á')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('é')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('í')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ó')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ú')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ñ')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ñ')); }
	
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ã')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('õ')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Â')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ê')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Î')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ô')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Û')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('â')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ê')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('î')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ô')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('û')); }
		
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('ç')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('Ç')); }

		if ($xok > 0)
			{
				return 1;
			} else {
				return 0;
			}
	}
	
function e($rr)
	{
	global $qcharset,$charset;
	if (($qcharset=='UTF8') or ($charset == 'UTF8'))
		{
			return(UTF8_encode($rr));
		}
	else
		{
			//while(utf8_detect($rr)) { $rr=utf8_decode($rr); }
			return($rr);
		}
	}	
	
function CharE($rr)
	{
	global $qcharset,$charset;
	if (($qcharset=='UTF8') or ($charset == 'UTF8'))
		{
			return(UTF8_encode($rr));
		}
	else
		{
			//while(utf8_detect($rr)) { $rr=utf8_decode($rr); }
			return($rr);
		}
	}
	
function UpperCaseSQL($d)
	{
	$qch1="ÁÉÍÓÚáéíóúàèìòùÀÈÌÒÙÂÊÎÔÛâêîôûÇçäëïöüÄËÏÖÜÃÕãõªº";
	$qch2="AEIOUaeiouaeiouAEIOUAEIOUaeiouCcaeiouAEIOUAOAOao";
	for ($qk=0;$qk < strlen($qch2);$qk++)
		{
		$d = troca($d,substr($qch1,$qk,1),substr($qch2,$qk,1));
		}
		 
	$d = strtoupper($d);
	return $d;
	}

function UpperCase($dx)
	{
	$qch1='ÁÉÍÓÚáéíóúàèìòùÀÈÌÒÙÂÊÎÔÛâêîôûÇçäëïöüÄËÏÖÜÃÕãõ';
	$qch2='ÁÉÍÓÚÁÉÍÓÚÀÈÌÒÙÀÈÌÒÙÂÊÎÔÛÂÊÎÔÛÇÇÄËÏÖÜÄËÏÖÜÃÕÃÕ';
	
	$dx = strtoupper($dx);
	
	for ($qk=0;$qk < strlen($qch2);$qk++)
		{
		$dx = troca($dx,substr($qch1,$qk,1),substr($qch2,$qk,1));
		}
	
	return $dx;
	}
	
function LowerCase($d)
	{
	$d = $d . ' ';
	$qch1='ÁÉÍÓÚáéíóúàèìòùÀÈÌÒÙÂÊÎÔÛâêîôûÇçäëïöüÄËÏÖÜÃÕãõ';
	$qch2='áéíóúáéíóúàèìòùàèìòùâêîôûâêîôûççäëïöüäëïöüãõãõ';
	
	$d = strtolower($d);
	for ($qk=0;$qk < strlen($qch2);$qk++)
		{
		$d = troca($d,substr($qch1,$qk,1),substr($qch2,$qk,1));
		}
		 
	return trim($d);
	}
		
function LowerCaseSQL($d)
	{
	$qch1="ÁÉÍÓÚáéíóúàèìòùÀÈÌÒÙÂÊÎÔÛâêîôûÇçäëïöüÄËÏÖÜÃÕãõªº";
	$qch2="aeiouaeiouaeiouaeiouaeiouaeiouccaeiouaeiouaoaoao";
	
	for ($qk=0;$qk < strlen($qch2);$qk++)
		{
		$d = troca($d,substr($qch1,$qk,1),substr($qch2,$qk,1));
		}
		 
	$d = strtolower($d);
	return $d;
	}

?>