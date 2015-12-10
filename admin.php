<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt

?>

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

/*********************** Menu do Comite *******************/
require ("committee_admin.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok == 0) {
	redirecina('main.php');
} else {
	$menu = array();
	array_push($menu, array(msg('admin_ghost'), msg('ghost'), 'admin_ghost_user.php'));
	/* array_push($menu, array(msg('admin_post_mail'), msg('post_mail'), 'admin_ic.php')); */
	array_push($menu, array(msg('dictamen'), msg('admin_parecer_modelo'), 'admin_parecer_modelo.php'));
}

echo '<h1>' . msg('admin_menu') . '</h1>';
echo '<fieldset>';
$tela = menus($menu, "3");
echo $tela;
echo '</fieldset>';

/* Admin Common */

if (($perfil -> valid('#ADM')) or ($_SESSION['user_name'] == 'ADMIN')) {
	$menu = array();
	array_push($menu, array(msg('admin_customize'), msg('customize_logo'), 'admin_customize_logo.php'));
	array_push($menu, array(msg('admin_customize'), msg('about_committe'), 'admin_committe.php'));

	//array_push($menu,array(msg('admin_metting'),msg('minutes_meeting'),'meeting_minutes.php'));
	array_push($menu, array(msg('admin_tables'), msg('calender_type'), 'admin_calender_type.php'));

	array_push($menu, array(msg('admin_tables'), msg('admin_country'), 'admin_country.php'));
	array_push($menu, array(msg('admin_tables'), msg('admin_register_unit'), 'admin_register_unit.php'));

	/* array_push($menu, array(msg('admin_tables'), msg('admin_parecer_modelo'), 'admin_parecer_modelo.php')); */

	array_push($menu, array(msg('admin_submission'), msg('admin_submission_field'), 'admin_submit_1.php'));

	$sql = "select * from cep_amendment_type where amt_ativo = 1 order by amt_ord";
	$rlt = db_query($sql);

	while ($line = db_read($rlt)) {
		array_push($menu, array(msg('admin_submission'), '__' . msg('amendment_'.trim($line['amt_codigo'])), 'admin_submit_000.php?dd90='.trim($line['amt_codigo'])));
	}
	
	array_push($menu, array(msg('admin_submission'), msg('admin_amend_type'), 'admin_cep_amendment_type.php?dd90='.trim($line['amt_codigo'])));

	array_push($menu, array(msg('admin_update'), msg('system_teste'), '_system_test.php'));
	array_push($menu, array(msg('admin_update'), msg('system_test_email'), '_system_email_test.php'));
	array_push($menu, array(msg('admin_update'), msg('system_php_info'), '_system_phpinfo.php'));

	$file = 'message.inf';

	if (file_exists($file)) {
		array_push($menu, array(msg('admin_message'), msg('admin_message_list'), 'message.php'));
		array_push($menu, array(msg('admin_message'), msg('admin_message_create'), 'message_create.php'));
		array_push($menu, array(msg('admin_message'), msg('admin_message_row'), 'message_row.php'));
		//array_push($menu, array(msg('admin_message'), msg('admin_utf8_convert'), 'message_convert_utf8.php'));
		//array_push($menu, array(msg('admin_message'), msg('admin_message_clear'), 'message_message_clear.php'));
		if ($edit_mode == 0) { array_push($menu, array(msg('admin_message'), msg('admin_message_enable'), 'admin_message_enable.php?dd1=1'));
		} else { array_push($menu, array(msg('admin_message'), msg('admin_message_disable'), 'admin_message_enable.php?dd1=0'));
		}
	}
	
	/* SQL Update */
	array_push($menu, array(msg('admin_update_system'), msg('system_update_system'), 'admin_update.php'));

	echo '<h1>' . msg('admin_menu_special') . '</h1>';
	echo '<fieldset>';
	$tela = menus($menu, "3");
	echo $tela;
	echo '</fieldset>';
}

require ("_version.php");

echo '</div>';

echo $hd -> foot();
?>
<script></script>