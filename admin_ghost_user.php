<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage ghost user
 */
require("cab.php");

require($include.'sisdoc_debug.php');

//$sql = "delete from _messages where 1=1";
//$rlt = db_query($sql);

	$clx = new users;
	$tabela = $clx->tabela;
	
	$label = msg('tit_'.$tabela);
	$http_edit = 'admin_user_ed.php'; 
	$editar = False;
	
	$http_ver = 'admin_ghost_user_sel.php';
	
	$http_redirect = page();
	
	$cdf = array('id_us','us_nome','us_email','us_email_alt');
	$cdm = array('cod',msg('name'),msg('email'),msg('email_alt'));
	$masc = array('','','','','','','');
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";

	$order  = "us_nome";
	
	echo '<H2>'.msg('ghost_top').'</h2>';
	echo '<div align="justify">';
	echo msg('ghost_instruction');
	echo '</div>';
	echo '<BR><BR>';
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
	echo '</div>';

	echo $hd->foot(); ?>