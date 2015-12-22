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

require("_class/_class_action.php");
$ac = new action;

echo '<h2>'.msg('assign_to_user_profile').'</h2>';
echo '<fieldset><legend>'.msg('assign_to_user_profile').'</legend>';

//if (($perfil->valid('#ADM')) or ($perfil->valid('#MAS'))) 
	{
		echo $ac->perfil_atribui_form();
		
		$ss->user_codigo = $dd[1];
		
		echo '<HR>';
		$perfil->set($dd[1]);
		
		echo $perfil->display();
	}
echo '</div>';
echo $hd->foot();
?>