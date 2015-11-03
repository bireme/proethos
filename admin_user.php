<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage user
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

require($include.'sisdoc_colunas.php');
require($include.'sisdoc_debug.php');

//$sql = "delete from _messages where 1=1";
//$rlt = db_query($sql);

	$clx = new users;
	$tabela = $clx->tabela;
	
	$label = msg('tit_'.$tabela);
	$http_edit = 'admin_user_ed.php'; 
	$editar = True;
	
	$http_ver = 'admin_user_detalhe.php';
	
	$http_redirect = 'admin_user.php?dd98='.$dd[98].'&dd97='.$dd[97];
	
	$cdf = array('id_us','us_nome','us_email','us_email_alt','us_codigo');
	$cdm = array('cod',msg('name'),msg('email'),msg('email_alt'),'codigo');
	$masc = array('','','','','','','');
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	

	
	$order  = "us_nome";
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
	echo '</div>';
?>
<script>
	
</script>

<? echo $hd->foot(); ?>