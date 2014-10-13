<?php
/**
 * Login Page
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright Copyright (c) 2013 - sisDOC.com.br
 * @access public
 * @version v.0.13.46
 * @package index
 * @subpackage login
 */

/* mark active page to cabmenu */
$active_page = 'home';

$include = '';
$xlogin = 1;
/* Habilita o modo login */

/* Add Styles */
$style_add = array('proethos_login.css');
require ("cab.php");

/* Classses */
require ($include . '_class_windows.php');
require ($include . '_class_form.php');
$form = new form;
echo '
<table border=0 align="center">
	<tr VALIGN="TOP"><td width="300">
		<img src="'.logo(3).'" width="200" border=0>
		<BR>'.msg('about_cep').'
	<td>
	<img src="'.logo(2).'">
	<BR><BR>
';
?>
<!--- Login form -->
	<div id="loginform">
		<div id="facebook"><i class="fa fa-facebook"></i><div id="connect">Connect with</div>
		</div>
		<div id="mainlogin">
		<div id="or">or</div>
		<h2 style="text-align: center;"><?php echo msg('login_cab'); ?></h2>		

			<?
			/* Login form input */
			$cp = array();
			array_push($cp, array('$H8', '', '', False, True));
			array_push($cp, array('$S100', '', msg('email'), True, True));
			array_push($cp, array('$P20', '', msg('password'), True, True));
			array_push($cp, array('$B8', '', msg('submit'), False, True));

			$dd[1] = email_restrition($dd[1]);

			$form -> required_message = 0;
			$form -> required_message_post = 0;
			$form -> class_password = 'login_string';
			$form -> class_string = 'login_string';
			$form -> class_button_submit = 'login_submit';
			$form -> class_form_standard = 'login_table';
			$tela = $form -> editar($cp, '');

			/* Show Form */
			echo '<center>';
			echo $tela;
			echo '</center>';

			/* Check login */
			if ($form -> saved > 0) {
				$rst = $ss -> login($dd[1], $dd[2]);

				$rst = $ss -> user_erro;
				$msg_erro = 'Erro:' . abs($rst);
				/* recupera mensagem */

				if ($rst < 0) {
					$rst = abs($rst);
					$msg_erro = msg($ss -> user_msg);
				} else {
					if ($rst == 1) {
						redirecina('main.php');
					}
				}
			}
			
			/* ERRO */
			if (strlen($msg_erro) > 0)
				{
					$erros = '<TR><TD></TD><TD><div id="erro">'.$msg_erro.'</div>';
				}
			?>
	
		<!-- forgot passs or new user -->
			<A href="javascript:newxy2('login_password_send.php',500,200)" class="links">
			<?=msg('forgot_password'); ?></A>
			&nbsp;|&nbsp;
			<A href="login_user_new.php" class="link">
			<?=msg('user_new'); ?></A>
			<?=$erros;?>
			</TD></TR>
		</table>
		
		</div>

</div>		
		
</TR>	
</table>

<?
echo '<BR><BR>';
echo '<table width="500" align="center">';
echo '<TR><TD>';
echo '<A HREF="Disclaimer_es.pdf" class="link">' . msg('disclaimer') . '</A>';
echo '<TD align="right">';
echo '<A HREF="ProEthosTerms_of_Use_es.pdf" class="link">' . msg('terms_of_use') . '</A>';
echo '</table>';

echo $hd -> foot();
?>
</body>

<script>
	$('#div_msg').mouseover(function() {
		$('#div_login').fadeIn('slow', function() {
		});
		$('#div_msg').fadeOut('slow', function() {
		});
	});
	$('#div_msg').click(function() {
		$('#div_login').fadeIn('slow', function() {
		});
		$('#div_msg').fadeOut('slow', function() {
		});
	});
	$("#div_newuser").corner();
</script>

<?
echo '<BR><BR><BR><BR><BR>';
//echo $hd->foot();
?>

