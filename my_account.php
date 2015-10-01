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
  * My Account
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */



/* Add Styles */
$style_add = array('proethos_form.css');
$active_page = 'my';

require("cab.php");
require($include.'sisdoc_data.php');
require($include.'_class_form.php');
$form = new form;
require("form_css.php");

$uss = new users;
$cp = $uss->cp_myaccount();

$dd[0] = $ss->user_id;
$uss->id = $dd[0];

$tabela = 'usuario';

echo '<h1>'.msg('my_account').'</h1>';
echo '<fieldset><legend>'.msg('my_account').'</legend>';
$tela = $form->editar($cp,$uss->tabela);

if ($form->saved > 0)
	{
		$uss->updatex();
		redirecina('main.php');
	} else {
			echo $tela;
			echo '<center>'.msg('my_profile').'</center>';
			echo $perfil->display();
	}
	
echo $hd->foot();
?>