<?php
/**
 * Reports page
 * @author Rene F. Gabriel Junior <renefgj@gmail.com>
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos
 * @subpackage Secretary
 */
 
if (($perfil -> valid('#ADM')) or ($perfil -> valid('#MAS')) or ($perfil -> valid('#SCR'))) {
	
	
	$menu = array();
	array_push($menu, array(msg('admin_protocols'), msg('protocols_new'), 'admin_protocols.php'));
	array_push($menu, array(msg('admin_research'), msg('admin_research'), 'admin_user.php'));
	array_push($menu, array(msg('admin_calender_type'), msg('scheduled_meeting'), 'meeting_scheduled.php'));
	array_push($menu, array(msg('admin_post_mail'), msg('post_mail'), 'admin_ic.php'));
	array_push($menu, array(msg('admin_faq'), msg('admin_faq'), 'admin_faq.php'));

	echo '<div class="border1 pad5 ml2 mt20">';
	echo '<h1>' . msg('secretary_menu') . '</h1>';
	$tela = menus($menu, "3");
	echo $tela;
	echo '</div>';
}
?>
