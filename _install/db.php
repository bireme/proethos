<?
ob_start();
session_start();

//$include .= '../../include/';
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$include = '../_include/';
$inc = $include;
for ($r=0;$r < 10;$r++)
	{
		if (file_exists($inc.'sisdoc_char.php')) { $include = $inc; $r=99; }
		$inc = '../'.$inc;
	}
//-------------------------------------- Paramentros para DEBUG
//$debug = true;

global $user_id,$user_nome,$dd,$user_nivel;
require($include."sisdoc_char.php");
require($include.'sisdoc_sql.php');

//-------------------------------------- Leituras das Variaveis dd0 a dd99 (POST/GET)
$vars = array_merge($_GET, $_POST);
for ($k=0;$k < 100;$k++)
	{
	$varf='dd'.$k;
	$varf=$vars[$varf];
	//if (isset($varf) and ($k > 1)) {	//$varf = str_replace($varf,"A","�"); }
	$dd[$k] = xss_security_post($varf);
	}

function xss_security_post($s)
	{
		$s = troca($s,'<','&lt;');
		$s = troca($s,'>','&gt;');
		$s = troca($s,'"','&quot;');
		//$s = troca($s,'/','&#x27;');
		$s = troca($s,"'",'&#x2F;');
		return($s);		
	}
?>