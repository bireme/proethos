<?php
/**
 * Admin Menu
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos
 * @subpackage admin
 */

$active_page = 'admin';
require ("cab.php");
require ($include . 'sisdoc_menus.php');

require ("committee_admin.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
} else {
	$menu = array();
	array_push($menu, array(msg('admin_ghost'), msg('ghost'), 'admin_ghost_user.php'));
	array_push($menu, array(msg('admin_post_mail'), msg('post_mail'), 'admin_ic.php'));
	array_push($menu, array(msg('dictamen'), msg('admin_parecer_modelo'), 'admin_parecer_modelo.php'));
	}

	echo '<h1>' . msg('admin_menu') . '</h1>';
	echo '<fieldset>';
	$tela = menus($menu, "3");
	echo $tela;
	echo '</fieldset>';

/* Admin Common */

if (($perfil -> valid('#ADM')) or ($_SESSION['user_name']=='ADMIN')) 
	{
	$menu = array();
	array_push($menu, array(msg('admin_customize'), msg('customize_logo'), 'admin_customize_logo.php'));
	array_push($menu, array(msg('admin_customize'), msg('about_committe'), 'admin_committe.php'));

	//array_push($menu,array(msg('admin_metting'),msg('minutes_meeting'),'meeting_minutes.php'));
	array_push($menu, array(msg('admin_tables'), msg('calender_type'), 'admin_calender_type.php'));

	array_push($menu, array(msg('admin_tables'), msg('admin_country'), 'admin_country.php'));
	array_push($menu, array(msg('admin_tables'), msg('admin_register_unit'), 'admin_register_unit.php'));

	array_push($menu, array(msg('admin_tables'), msg('admin_parecer_modelo'), 'admin_parecer_modelo.php'));

	array_push($menu, array(msg('admin_tables'), msg('admin_submission'), 'admin_submit.php'));

	array_push($menu, array(msg('admin_update'), msg('system_teste'), '_system_test.php'));
	array_push($menu, array(msg('admin_update'), msg('system_test_email'), '_system_email_test.php'));
	
	$file = 'message.inf';
	
	if (file_exists($file)) {
		array_push($menu, array(msg('admin_message'), msg('admin_message'), 'message.php'));
		array_push($menu, array(msg('admin_message'), msg('admin_message_create'), 'message_create.php'));
		array_push($menu, array(msg('admin_message'), msg('admin_message_row'), 'message_row.php'));
		array_push($menu, array(msg('admin_message'), msg('admin_utf8_convert'), 'message_convert_utf8.php'));

		if ($edit_mode == 0) { array_push($menu, array(msg('admin_message'), msg('admin_message_enable'), 'admin_message_enable.php?dd1=1'));
		} else { array_push($menu, array(msg('admin_message'), msg('admin_message_disable'), 'admin_message_enable.php?dd1=0'));
		}
	}	

	echo '<h1>' . msg('admin_menu_special') . '</h1>';
	echo '<fieldset>';
	$tela = menus($menu, "3");
	echo $tela;
	echo '</fieldset>';
}

require("_version.php");

echo '</div>';

echo $hd -> foot();
?>
<script></script>
