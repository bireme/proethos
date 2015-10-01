<?
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
  * @subpackage ghost user
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')) or ($ss->user_ghost > 0));

if ($ok==0) {
	redirecina('main.php');
}

/* Valid Submit */
$chk = checkpost($dd[0]);
$ch2 = $dd[90];
if ($chk == $ch2)
	{
		
	/* Active Mode Ghost */		
	if (strlen($dd[1])==0)
		{
		/* Save original user */
		$ss->set_user_original();
		$ss->le($dd[0]);
	
		/* Active mode ghost */
		$ss->set_ghost();
		$ss->ghost_user();
	
		redirecina("main.php");
		}
	/* DesActive Mode Ghost */		
	if (strlen($dd[1]) > 0)
		{
			$ss->reset_user_original();
			$ss->reset_ghost();
			$ss->le($dd[0]);
			$ss->normal_user();
			redirecina("main.php");
		}
		
	} else {
		echo '<h1>'.msg('ghost_mode').'</h1>';
		echo '<div class="error">'.msg('access_error');'</div>';
	}
	
	echo '</div>';


echo $hd->foot(); 
?>