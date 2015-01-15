<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Char
*/

if (!(isset($mostar_versao))) { $mostar_versao = False; }
if ($mostar_versao == True) { array_push($sis_versao,array("sisDOC (Char)","0.0a",20140720)); }

if (strlen($include) == 0) { exit; }
/** Define o time zone, opcional para alguns servidores; */
//date_default_timezone_set('UTC'); 
/**/

/* Detecta tipo de caracter */
function codificacao($string) {
	return mb_detect_encoding($string . 'x', 'UTF-8, ISO-8859-1');
}

function email_restrition($s)
	{
		if (is_array($s)) { echo 'IS ARRAY'; exit; }
		$valid = ' abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@.-_+';
		$sr = '';
		for ($r=0;$r < strlen($s);$r++)
			{
				$ch = trim(substr($s,$r,1));
				if (strpos($valid,$ch) > 0)
					{ $sr .= $ch; }
			}
		return($sr);
	}

function ShowLink($link,$tipo='0',$target='',$label='')
	{
		if (strlen($target) > 0) { $tag = ' target="'.$target.'"';}
		if (strlen($link) ==0 ) { return(''); }
		switch($tipo)
			{
			case '1':
				$lk = '<A HREF="'.$link.'" title="'.$label.'" '.$tag.'>';
				$lk .= '<img src="'.$path.'"icone_link.png" height="16" border="0">';
				$lk .= '</A>';
			default:
				$lk = '<A HREF="'.$link.'" title="'.$label.'" '.$tag.'>';
				$lk .= $link;
				$lk .= '</A>';
				break; 
			}
		return($lk);
	}
function newwin($link,$szh=50,$szv=50)
	{
		if ($szh < 50) { $szh = 50; }
		if ($szv < 20) { $szv = 20; }
		$sx = '<A HREF="javascript:newxy3(';
		$sx .= "'".$link."',".$szh.",".$szv.");";
		$sx .= '">';
		return($sx);
	}
/*
 * function nocr
 * @para $text
 * @return $text
 */
function nocr($text)
	{
		$text = troca($text,chr(13),'���');
		$text = troca($text,chr(10),'');
		$text = troca($text,'.���','.'.chr(13));
		$text = troca($text,'!���','!'.chr(13));
		$text = troca($text,'?���','?'.chr(13));
		$text = troca($text,'���',' ');
		return($text);
	}
/**
 * Fun��o de formata��o em padr�o Brasileiro
 */
function fmt($vlr,$dec=2)
	{
		$fff = number_format($vlr,$dec);
		$fff = troca($fff,',',';');
		$fff = troca($fff,'.',',');
		$fff = troca($fff,';','.');
		return($fff);
	}

/** 
* Fun��o para formatar n�mero
* Esta fun��o est� vinculada a biblioteca sisdoc_row.php
*/
////////////////////////////////////////
function url_exists($url){
        $url = str_replace("http://", "", $url);
        if (strstr($url, "/")) {
            $url = explode("/", $url, 2);
            $url[1] = "/".$url[1];
        } else {
            $url = array($url, "/");
        }

        $fh = fsockopen($url[0], 80);
        if ($fh) {
            fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
            if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
            else { return TRUE;    }

        } else { return FALSE;}
    }
////////////////////////////////////////	
function format_fld($zq1,$zq2)
	{
		global $hd,$LANG;
		$zqr = '';
		if (strlen($zq2) > 0)
			{
			if (substr($zq2,0,1) == '(') 
				{ 
					$zqr = substr($zq2,strpos($zq2,$zq1.':')+2,100); 
//					echo '['.strpos($zq2,$zq1.':').']';
					if (strpos($zqr,'&') > 0) { $zqr = substr($zqr,0,strpos($zqr,'&')); }
					$zqr = $zq1.'-'.$zqr;
				}
				
			
			////////////////////// $
			if ($zq2 == '$') { $zqr =  Number_format($zq1/100,2); }
			////////////////////// $R
			if (($zq2 == '$R') or ($zq2 == '2'))
			{
				 $zqr =  Number_format($zq1,2);
				 if ($LANG == 'en_US')
				 	{ $zqr = $zqr;} 
				 if (($LANG == 'pt_BR') or ($zq2 == '2'))
				 	{ $zqr = troca(troca(troca($zqr,'.','#'),',','.'),'#','.'); }
			}
			////////////////////// #
			if (substr($zq2,0,1) == '#') 
				{ $zqr =  '<CENTER>';
				$zqr = $zqr . $zq1; }
			////////////////////// @
			if ($zq2 == 'SHORT') 
				{ 
				$zqr = $zqr . SubStr($zq1,0,1).LowerCase(SubStr($zq1,1,strpos($zq1,' '))); 
				}
			if ($zq2 == '@') 
				{ $zqr =  UpperCase(SubStr($zq1,0,1));
				if (substr($zq1,1,1) == ' ') { $zqr = $zqr . '&nbsp;'; }
				$zqr = $zqr . LowerCase(SubStr($zq1,1,200)); }
			////////////////////// Bold
			if ($zq2 == 'B') ////// BOLD
				{$zqr = $zqr .'<B>'.$zq1.'</B>'; }
			////////////////////// CB				
			if ($zq2 == 'CB') 
				{ $varf=$vars[$varf];
				$vvvt = '';
				$vvvt = $vars['chk'.$zq1];
				if ($vvvt=="1") { $vvvt = "checked"; }
				$zqr = $zqr . '<input type="checkbox" name="chk'.$zq1.'" '.$vvvt.' value="1">'; }	
			////////////////////// CEP				
			if ($zq2 == 'CEP') ////// CEP
				{ 
				$xxcep = sonumero($zq1);
				if (strlen($xxcep)==8) { $xxcep=substr($xxcep,0,2).'.'.substr($xxcep,2,3).'-'.substr($xxcep,5,3); }
				$zqr =  $zqr . $xxcep; 
				}
			////////////////////// D
			if ($zq2 == 'D') 
				{ $zqr =  '<CENTER>';
				$dta = trim($zq1);
				if ($dta == '19000101') { $zqr = $zqr . '-'; }
				else { $zqr = $zqr . stodbr($zq1); } }
			////////////////////// DR
			if ($zq2 == 'DR') 
				{ 
				$zqr =  '<CENTER>';
				$dta = trim($zq1);
				if ($dta == '19000101') { $zqr = $zqr . '-'; }
				else { $zqr = $zqr . substr(stodbr($zq1),0,5); }
				}					
			////////////////////// H
			if ((substr($zq2,0,1) == 'H') and ($zq2 != 'H1') and ($zq2 != 'H2'))
				{ 
				$zqr = '';
				if ($hd != trim($zq1))
					{ 
					$zq1v = $zq1;
					if (substr($zq2,1,1) =='D') { $zq1v = stodbr($zq1); }
//					$zqr .= '<TR><TD colspan="15" height="1" bgcolor="#c0c0c0"></TD></TR>';
					$zqr .= '<TR><TD  bgcolor="#FFFFFF" colspan="15" class="lt2" align="left"><HR size="1"><B>'.$zq1v.'</TD></TR>';
					$hd = trim($zq1);
					$zqr = $zqr . '<TR><TD></TD>';
					}
				} 
			if ($zq2 == 'H1') ////// ENFATIZADO
				{$zqr = $zqr .'<h1>'.$zq1.'</h1>'; }
			if ($zq2 == 'H2') ////// ENFATIZADO
				{$zqr = $zqr .'<h2>'.$zq1.'</h2>'; }				
			////////////////////// Italic
			if ($zq2 == 'I') ////// ITALIC
				{$zqr = $zqr .'<I>'.$zq1.'</I>'; }

			if ($$zq2 == 'NL') ////// Nova Linha
				{ $zqr = $zqr . '<TR '.$xcol.'><TD><TD>'.$linkv.$zq1; }
			if ($zq2 == 'SHORT') 
				{ $zqr = $zqr . LowerCase(SubStr($zq1,1,strpos($zq1,' '))); }
			////////////////////// SN
			if ($zq2 == 'SN') 
				{ 
				$zqr =  '<CENTER>';
				$dta = trim($zq1);
				if (($dta == '1') or ($dta == true) or ($dta=='S')) { $zqr = $zqr . 'SIM'; }
				else { $zqr = $zqr . 'NAO'; }
				}					
			if ($zq2 == 'Z') 
				{ 
				$zqr =  '<CENTER>';
				$zqr = $zqr .  strzero($zq1,'0'.substr($zq2,1,2)); 
				}							
			} else { $zqr =  $zq1; }	
			return($zqr);
	}
function page()
	{
	$page = $_SERVER['SCRIPT_NAME'];
	while ($pos = strpos(' '.$page,'/'))
		{ $page = substr($page,$pos,strlen($page)); }
	return($page);
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

function nr_format($vr,$vs)
	{
	$vrr = number_format($vr,$vs);
	$vrr = troca($vrr,',','#');
	$vrr = troca($vrr,'.',',');
	$vrr = troca($vrr,'#','.');
	return($vrr);
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

function chkmd5($dq)
	{
	global $secu;
		return(md5($dp.$secu));
	}
	
function customError_olds($errno, $errstr, $errfile, $errline, $errcontext)
  {
  global $secu,$base,$base_name,$user_log,$debug,$ttsql,$rlt,$sql_query;
  if ($errno != '8')
  		{
		$email = 'rene@fonzaghi.com.br';
		$tee = '<table width="600" bordercolor="#ff0000" border="3" align="center">';
		$tee .= '<TR><TD bgcolor="#ff0000" align="center"><FONT class="lt2"><FONT COLOR=white><B>ERRO  -['.$base.']-'.$base_name.'-</B></TD></TR>';
		$tee .= '<TR><TD align="center"><B><TT>';
		$tee .= 'Erro N�mero #'.$errno;
		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>Remote Address: '.$_SERVER['REMOTE_ADDR'];
		$tee .= '<BR>Metodo: '.$_SERVER['REQUEST_METHOD'];
		$tee .= '<BR>Nome da p�gina: '.$_SERVER['SCRIPT_NAME'];
		$tee .= '<BR>Dom�nio: '.$_SERVER['SERVER_NAME'];
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
//		if ($debug == 3) { echo 'Muitas conex�es, aguarde....'; }
		
		$headers = '';	
		$headers .= 'To: Rene (Monitoramento) <rene@fonzaghi.com.br>' . "\r\n";
		$headers .= 'From: BancoSQL (PG) <rene@sisdoc.com.br>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		

		//mail($email, 'Erros de Script'.$secu, $tee, $headers);
		echo $tee;	
		die();
		}
  } 

function checkpost($_P)
	{
	global $secu;
	$chkp = substr(md5($_P.$secu),5,10);
	return($chkp);
	}
function checkform()
	{
	global $dd,$secu;
	$chkp = substr(md5($dd[0].$secu),5,10);
	if ($chkp == $dd[90]) 
		{ return( 1 ); } 
	else { 
		$msg="Erro na transmiss�o dos dados, tente novamente";
		echo '<CENTER><BR><BR>';
		echo msg_erro($msg);
		$msg = '';
		return( 0 ); 
	}
	}
function redirecina($pg)
	{
	header("Location: ".$pg);
	echo 'Stoped'; exit;
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
function sonumero($it)
	{
	$rlt = '';
	for ($ki=0;$ki < strlen($it);$ki++)
		{
		$ord = ord(substr($it,$ki,1));
		if (($ord >= 48) and ($ord <= 57)) { $rlt = $rlt . substr($it,$ki,1); }
		}   
//$rlt = round($rlt); 
//	if ($rlt > 256*256*256) { $rlt = -1; }
	return $rlt;
	}

function dsp_sn($y)
	{
	global $LANG;
	$SIM = "SIM"; $NAO = 'N�O';
	if ($LANG == 'en') { $SIM = 'YES'; $NAO = 'NO'; }
	$yy = $NAO;
	if ($y=='1') { $yy = $SIM; }
	if ($y=='S') { $yy = $SIM; }
	return($yy);	
	}
function strzero($ddx,$ttz)
	{
	$ddx = round($ddx);
	while (strlen($ddx) < $ttz)
		{ $ddx = "0".$ddx; }
	return($ddx);
	}
	
function mst($ddx)
	{
	$ddx = troca($ddx,chr(13),'<BR>');
	return($ddx);
	}

function mst_hexa($ddx)
	{
	$ddr = '';
	$ddi = '';
	$dda = '<TT>';
	$rrow = 0;
	for ($rt = 0;$rt < strlen($ddx);$rt++)
		{
		$ddr .= bin2hex(substr($ddx,$rt,1)).' ';
		$ddi .= substr($ddx,$rt,1).'&nbsp;';
		$rrow++;
		if ($rrow > 7)
			{
				$dda .= $ddr.'&nbsp;'.$ddi.'<BR>';
				$ddr = '';
				$ddi = '';
				$rrow = 0;
			}
		}
	$dda .= $ddr.'&nbsp;'.$ddi.'<BR>';
	$dda .= '<HR>'.mst($ddx);
	return($dda);
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
	    '�','�','�','�','�','�',
	    '�','�','�','�','�','�',
	    '�',
	    '�',
	    '�','�','�','�',
	    '�','�','�','�',
	    '�','�','�','�',
	    '�','�','�','�',
	    '�',
	    '�',
	    '�','�','�','�','�',
	    '�','�','�','�','�',
	    '�','�','�','�',
	    '�','�','�','�',
	    '�',
	    '�','�',
	    '�',
	    '�');
	 
return preg_replace($codigo_acentos, $acentos, $str);
}
	
function char_ISO_Latin_1($ddv)
	{
	////// ISO Latin-1 Characters and Control Characters
	$ddr = '?';
	if ($ddv == '&#160;') { $ddr = ' '; }
	if ($ddv == '&#161;') { $ddr = '�'; }
	if ($ddv == '&#162;') { $ddr = '�'; }
	if ($ddv == '&#163;') { $ddr = '�'; }
	if ($ddv == '&#164;') { $ddr = '�'; }
	if ($ddv == '&#165;') { $ddr = '�'; }
	if ($ddv == '&#166;') { $ddr = '�'; }
	if ($ddv == '&#167;') { $ddr = '�'; }
	if ($ddv == '&#168;') { $ddr = '�'; }
	if ($ddv == '&#169;') { $ddr = '�'; }

	if ($ddv == '&#170;') { $ddr = '�'; }
	if ($ddv == '&#171;') { $ddr = '�'; }
	if ($ddv == '&#172;') { $ddr = '�'; }
	if ($ddv == '&#173;') { $ddr = ' '; }
	if ($ddv == '&#174;') { $ddr = '�'; }
	if ($ddv == '&#175;') { $ddr = '�'; }
	if ($ddv == '&#176;') { $ddr = '�'; }
	if ($ddv == '&#177;') { $ddr = '�'; }
	if ($ddv == '&#178;') { $ddr = '�'; }
	if ($ddv == '&#179;') { $ddr = '�'; }

	if ($ddv == '&#180;') { $ddr = '�'; }
	if ($ddv == '&#181;') { $ddr = '�'; }
	if ($ddv == '&#182;') { $ddr = '�'; }
	if ($ddv == '&#183;') { $ddr = '�'; }
	if ($ddv == '&#184;') { $ddr = '�'; }
	if ($ddv == '&#185;') { $ddr = '�'; }
	if ($ddv == '&#186;') { $ddr = '�'; }
	if ($ddv == '&#187;') { $ddr = '�'; }
	if ($ddv == '&#188;') { $ddr = '�'; }
	if ($ddv == '&#189;') { $ddr = '�'; }

	if ($ddv == '&#190;') { $ddr = '�'; }
	if ($ddv == '&#191;') { $ddr = '�'; }
	if ($ddv == '&#192;') { $ddr = '�'; }
	if ($ddv == '&#193;') { $ddr = '�'; }
	if ($ddv == '&#194;') { $ddr = '�'; }
	if ($ddv == '&#195;') { $ddr = '�'; }
	if ($ddv == '&#196;') { $ddr = '�'; }
	if ($ddv == '&#197;') { $ddr = '�'; }
	if ($ddv == '&#198;') { $ddr = '�'; }
	if ($ddv == '&#199;') { $ddr = '�'; }

	if ($ddv == '&#200;') { $ddr = '�'; }
	if ($ddv == '&#201;') { $ddr = '�'; }
	if ($ddv == '&#202;') { $ddr = '�'; }
	if ($ddv == '&#203;') { $ddr = '�'; }
	if ($ddv == '&#204;') { $ddr = '�'; }
	if ($ddv == '&#205;') { $ddr = '�'; }
	if ($ddv == '&#206;') { $ddr = '�'; }
	if ($ddv == '&#207;') { $ddr = '�'; }
	if ($ddv == '&#208;') { $ddr = '�'; }
	if ($ddv == '&#209;') { $ddr = '�'; }

	if ($ddv == '&#210;') { $ddr = '�'; }
	if ($ddv == '&#211;') { $ddr = '�'; }
	if ($ddv == '&#212;') { $ddr = '�'; }
	if ($ddv == '&#213;') { $ddr = '�'; }
	if ($ddv == '&#214;') { $ddr = '�'; }
	if ($ddv == '&#215;') { $ddr = '�'; }
	if ($ddv == '&#216;') { $ddr = '�'; }
	if ($ddv == '&#217;') { $ddr = '�'; }
	if ($ddv == '&#218;') { $ddr = '�'; }
	if ($ddv == '&#219;') { $ddr = '�'; }

	if ($ddv == '&#220;') { $ddr = '�'; }
	if ($ddv == '&#221;') { $ddr = '�'; }
	if ($ddv == '&#222;') { $ddr = '�'; }
	if ($ddv == '&#223;') { $ddr = '�'; }
	if ($ddv == '&#224;') { $ddr = '�'; }
	if ($ddv == '&#225;') { $ddr = '�'; }
	if ($ddv == '&#226;') { $ddr = '�'; }
	if ($ddv == '&#227;') { $ddr = '�'; }
	if ($ddv == '&#228;') { $ddr = '�'; }
	if ($ddv == '&#229;') { $ddr = '�'; }

	if ($ddv == '&#230;') { $ddr = '�'; }
	if ($ddv == '&#231;') { $ddr = '�'; }
	if ($ddv == '&#232;') { $ddr = '�'; }
	if ($ddv == '&#233;') { $ddr = '�'; }
	if ($ddv == '&#234;') { $ddr = '�'; }
	if ($ddv == '&#235;') { $ddr = '�'; }
	if ($ddv == '&#236;') { $ddr = '�'; }
	if ($ddv == '&#237;') { $ddr = '�'; }
	if ($ddv == '&#238;') { $ddr = '�'; }
	if ($ddv == '&#239;') { $ddr = '�'; }

	if ($ddv == '&#240;') { $ddr = '�'; }
	if ($ddv == '&#241;') { $ddr = '�'; }
	if ($ddv == '&#242;') { $ddr = '�'; }
	if ($ddv == '&#243;') { $ddr = '�'; }
	if ($ddv == '&#244;') { $ddr = '�'; }
	if ($ddv == '&#245;') { $ddr = '�'; }
	if ($ddv == '&#246;') { $ddr = '�'; }
	if ($ddv == '&#247;') { $ddr = '�'; }
	if ($ddv == '&#248;') { $ddr = '�'; }
	if ($ddv == '&#249;') { $ddr = '�'; }

	if ($ddv == '&#250;') { $ddr = '�'; }
	if ($ddv == '&#251;') { $ddr = '�'; }
	if ($ddv == '&#252;') { $ddr = '�'; }
	if ($ddv == '&#253;') { $ddr = '�'; }
	if ($ddv == '&#254;') { $ddr = '�'; }
	if ($ddv == '&#255;') { $ddr = '�'; }
	
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
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
	
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }
		if ($xok==0) { $xok = strpos($utt,UTF8_encode('�')); }

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
	$qch1="������������������������������������������������";
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
	$qch1='����������������������������������������������';
	$qch2='����������������������������������������������';
	
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
	$qch1='����������������������������������������������';
	$qch2='����������������������������������������������';
	
	$d = strtolower($d);
	for ($qk=0;$qk < strlen($qch2);$qk++)
		{
		$d = troca($d,substr($qch1,$qk,1),substr($qch2,$qk,1));
		}
		 
	return trim($d);
	}
		
function LowerCaseSQL($d)
	{
	$qch1="������������������������������������������������";
	$qch2="aeiouaeiouaeiouaeiouaeiouaeiouccaeiouaeiouaoaoao";
	
	for ($qk=0;$qk < strlen($qch2);$qk++)
		{
		$d = troca($d,substr($qch1,$qk,1),substr($qch2,$qk,1));
		}
		 
	$d = strtolower($d);
	return $d;
	}		
	
function troca($qutf,$qc,$qt)
	{
	return(str_replace(array($qc), array($qt),$qutf));
	}
?>