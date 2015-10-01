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
  * Dictamen Checklist
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Dictamen
 */
$include = '../';
require("db.php");
require('_security_v2.php');
$user = new usuario;
$user->Security();

require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

require('_class/_class_cep_parecer_avaliation.php');
$parav = new parecer_avaliation;
$parav->le($dd[0]);

echo '<h1>'.msg("decline").'</h1>';

echo msg('confirme_decline');
echo '<BR>';
echo '<A HREF="'.page().'?dd0='.$dd[0].'&dd90='.$dd[90].'&dd1=CONFIRM">';
echo msg('yes');
echo '</A>';
echo ' | ';
echo '<A HREF="'.page().'?dd0='.$dd[0].'&dd90='.$dd[90].'&dd1=NO">';
echo msg('no');
echo '</A>';

if (strlen($dd[1]) > 0)
	{
		if ($dd[1]=='CONFIRM')
			{
				$parav->set_decline($dd[0]);
			}
		require("close.php");
	}

?>