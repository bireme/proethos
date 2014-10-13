<?
 /**
  * My Account
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
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

