<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Member User
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

require($include.'sisdoc_menus.php');
require($include.'sisdoc_data.php');

echo '<h2>'.msg('assign_to_user_profile').'</h2>';
echo '<fieldset><legend>'.msg('assign_to_user_profile').'</legend>';

if (($perfil->valid('#ADM')) or ($perfil->valid('#MAS'))) 
	{
		echo $perfil->perfil_atribui_form();
		
		$ss->user_codigo = $dd[1];
		
		echo '<HR>';
		$perfil->set($dd[1]);
		
		echo $perfil->display();
	}
echo '</div>';
echo $hd->foot();
?>