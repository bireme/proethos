<?
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