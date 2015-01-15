<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage SQL
*/
///////////////////////////////////////////
// Versao atual           //    data     //
//---------------------------------------//
// 0.11.34                    23/08/2011 // Fun��o limit
// 0.0G                       13/01/2011 // Fun��o tableexist
// 0.0F                       19/10/2010 // Corre��o da Mensagem Postgres
// 0.0e                       29/05/2009 // Envio por e-mail de erros
// 0.0d                       20/05/2008 //
// 0.0a                       25/02/2006 //
///////////////////////////////////////////
if (!isset($mostar_versao)) { $mostar_versao = False; }
if ($mostar_versao == True) { array_push($sis_versao,array("sisDOC (SQL)","0.0b",20080520)); }
global $sql_query;

function limit($vlr,$tp)
	{
	global $base;
	if (($base == 'mysql') and ($tp == 'f')) { $limit = ' limit '.$vlr; }
	if (($base == 'mssql') and ($tp == 'i')) { $limit = ' top '.$vlr; }
	if (($base == 'pgsql') and ($tp == 'f')) { $limit = ' limit '.$vlr; }
	return($limit);
	}
	
function pg_email_erro($serro)
	{
	global $secu,$base,$base_name;
	$email = 'rene@fonzaghi.com.br';
	$tee = '<table width="400" bordercolor="#ff0000" border="3" align="center">';
	$tee .= '<TR><TD bgcolor="#ff0000" align="center"><FONT class="lt2"><FONT COLOR=white><B>Erro  -'.$base.'-['.$base_name.']-</TD></TR>';
	$tee .= '<TR><TD><B><TT>';
	$tee .= $serro;
	$tee .= '<TR><TD><B><TT>';
	$tee .= pg_last_error();
	$tee .= '<TR><TD><B><TT>';
	$tee .= '<BR>Remote Address: '.$_SERVER['REMOTE_ADDR'];
	$tee .= '<BR>Metodo: '.$_SERVER['REQUEST_METHOD'];
	$tee .= '<BR>Nome da pagina: '.$_SERVER['SCRIPT_NAME'];
	$tee .= '<BR>Dominio: '.$_SERVER['SERVER_NAME'];
	$tee .= '<BR>Data: '.date("d/m/Y H:i:s");
	$tee .= '</table>';

	$headers .= 'To: Rene (Monitoramento) <rene@fonzaghi.com.br>' . "\r\n";
	$headers .= 'From: BancoSQL (PG) <rene@sisdoc.com.br>' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		

	mail($to, $subject, $message, $headers);	
	mail($email, 'Erros de SQL '.$secu, $tee, $headers);
//	echo '<BR>e-mail enviado para '.$email ;
	}

function tableexist($ttable)
	{
	global $base,$rlt;
	if ($base=='pgsql') 
		{
		$ttsql = "select * from pg_tables where (tablename='".$ttable."') and (schemaname='public')";
		$ttrlt = db_query($ttsql);
		if ($tline = db_read($ttrlt)) { return(1); } else {return(0); }
		}
	}
	
function pg_error()
	{
	global $secu,$base;	
	echo '<table width="400" bordercolor="#ff0000" border="3" align="center">';
	echo '<TR><TD bgcolor="#ff0000" align="center"><FONT class="lt2"><FONT COLOR=white><B>Erro  -'.$base.'-</TD></TR>';
	echo '<TR><TD><B><TT>';
	}

function db_erro()
	{
	global $base,$rlt;
	if ($base=='pgsql') { return(pg_error() . '<BR>'.$rlt); }
	if ($base=='mssql') { return(mssql_get_last_message() . '<BR>'.$rlt); }
	}
function db_connect()
	{
	global $base_host, $base_port, $base_name ,$base_user, $base_pass, $base, $conn, $charset;
	$RST = '';
	if ($base=='pgsql')
		{
		$conn = "host=".$base_host." port=".$base_port." dbname=".$base_name." user=".$base_user." password=".$base_pass."";
		$db = pg_connect($conn);
		}
		
	if ($base=='mysqlPDO')
		{
		//$conn=mysql_connect($base_host,$base_user,$base_pass) or die ("Erro de Conexao !");
		$txt = 'mysql:host='.$base_host.';dbname='.$base_name.';charset=utf8'; //.$charset;
		$conn = new PDO($txt,$base_user,$base_pass);
		//$banco=mysql_select_db(trim($base_name),$conn) or die ("Erro ao Selecionar o Banco !");
		$RST = 'MYSQL';
		}
		
	if ($base=='mysql')
		{
		$conn=mysql_connect($base_host,$base_user,$base_pass) or die ("Erro de Conexao !");
		$banco=mysql_select_db(trim($base_name),$conn) or die ("Erro ao Selecionar o Banco !");
		$RST = 'MYSQL';
		}
		
	if ($base=='mssql')
		{
		$conn=mssql_connect($base_host,$base_user,$base_pass) or die ("Erro de Conex�o !");;
		$banco=mssql_select_db($base_name,$conn) or die ("Erro ao Selecionar o Banco !");
		$RST = 'MSSQL';
		}	
	if ($base=='sybase')
		{
		$conn=sybase_connect($base_host,$base_user,$base_pass) or die ("Erro de Conex�o !");;
		$banco=sybase_select_db($base_name,$conn) or die ("Erro ao Selecionar o Banco !");
		$RST = 'MSSQL';
		}				
	return($RST);
	}
	
function db_query($rlt)
	{
	global $base,$debug,$sql_query,$conn;	
	$sql_query = $rlt;
	//echo $rlt;
//	if (strlen($debug) > 0) { echo '<HR>'.$rlt; }
	////////////////////////////// PostGre
	if ($base=='pgsql')
		{ 
		if (strlen($debug) > 0) { $xxx = pg_query($rlt) or die($rlt . pg_email_erro($rlt) ); } else
		{ $xxx = pg_query($rlt) or die('Erro de base <BR>' . pg_email_erro($rlt)); }
		}
	////////////////////////////// MySQL
	if ($base=='mysqlPDO')
		{
		$xxx = $conn->query($rlt);
		//if (strlen($debug) > 0) { $xxx = mysql_query($rlt) or die(mysql_error() . '<BR>'.$rlt); }
		//else {  $xxx = mysql_query($rlt) or die('Erro de base'); }
		}
			
	if ($base=='mysql')
		{
		if (strlen($debug) > 0) { $xxx = mysql_query($rlt) or die(mysql_error() . '<BR>'.$rlt); }
		else {  $xxx = mysql_query($rlt) or die('Erro de base'); }
		}
	if ($base=='mssql')
		{
		$rlt = sql_convert($rlt);
		$sql_query = $rlt;
		if (strlen($debug) > 0)  { $xxx = mssql_query($rlt) or die(pg_error(). '<BR>'.$rlt); } else
		 { $xxx = mssql_query($rlt); }
		}
		 
	if ($base=='sybase')
		{ $xxx = sybase_query($rlt) or die(pg_error(). '<BR>'.$rlt); }
	return $xxx;
	}
	
function sql_convert($sql)
	{
		if (strpos($sql,'serial NOT NULL') > 0)
			{
				$posi = strpos($sql,'('); 
				$posf = strpos($sql,'serial NOT NULL');
				$key = trim(substr($sql,$posi+1,($posf-$posi-1))); 
				$sql = troca($sql,'serial NOT NULL',' int PRIMARY KEY IDENTITY ');
//				$sql = substr($sql,0,strlen($sql)-2);
//				$sql .= ", PRIMARY KEY($key) );";
				
				$sql = troca($sql,'int(1)','int');
				$sql = troca($sql,'int(4)','int');
				$sql = troca($sql,'int(8)','int');
				$sql = troca($sql,'int(16)','int');
				$sql = troca($sql,'int(11)','int');
			}
		return($sql);
	}
function db_read($rlt)
	{
	global $base,$conn;
	if ($base=='pgsql')
		{ $xxx = pg_fetch_array($rlt); }
	if ($base=='mysql')
		{ $xxx = mysql_fetch_array($rlt); }
	if ($base=='mssql')
		{ $xxx = mssql_fetch_array($rlt); }
	if ($base=='mysqlPDO')
		{
			$xxx = $rlt->fetch(PDO::FETCH_ASSOC);
		}		
	return($xxx);
	}
?>