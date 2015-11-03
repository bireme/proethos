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
require ("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

echo '<h1>E-mail system check</h1>';

echo '<div class="border1 pad5">';
echo '<h2>E-mail</h2>';

require ($include . 'sisdoc_email.php');

require ($include . '_class_form.php');
$form = new form;
$cp = array();
array_push($cp, array('$S100', '', 'e-mail to send', True, True));
array_push($cp, array('$B8', '', 'send test >>>', False, True));

$tela = $form -> editar($cp, $tabela);

if ($form -> saved > 0) {
	echo $tela;

	$email_to = $dd[0];
	if (checaemail($email_to) == 1) {
		
		echo '<BR>SMTP-Server: ' . $hd -> email_smtp;
		echo '<BR>E-mail user: ' . $hd -> email_user .' &lt;'.$hd->email_name.'&gt;';
		echo '<BR>E-mail to: ' . $email;

		/* Send e-mail test */
		echo '<table width="100%"><TR><TD>';

		/* Sample */
		$title_sample = 'Proethos - Email test';
		$message_sample = '<h1>Email was sent with Successful!</h1>';

		ini_set('display_errors', 0);
		ini_set('error_reporting', 0);		
		
		/* Method 2 */
		echo '<HR><h1>Method 2</h1>';
		echo '<div id="method2" style="display:none; ">';
		require ("_system_emal_test_menthod_2.php");
		echo '</div>';
		echo '<A HREF="#" class="lt0" id="method2a">SHOW LOG</A>
				<script>
				$("#method2a").click(function() { $("#method2").toggle(); });
				</script>		
		';
		/* Method 1 */
		echo '<HR><h1>Method 1</h1>';
		echo '<div id="method1" style="display:none; ">';
		require ("_system_emal_test_menthod_1.php");
		echo '</div>';
		echo '<A HREF="#" class="lt0" id="method1a">SHOW LOG</A>
				<script>
				$("#method1a").click(function() { $("#method1").toggle(); });
				</script>		
		';		
		echo '</TD></TR></table>';
	} else {
		echo '<BR><font color="red">e-mail invalid</font>';
	}
} else {
	echo $tela;
}
echo '</div>';
echo '</div>';

echo $hd -> foot();

	function format_email_2($email, $name) {
		$name = trim($name);
		$email = trim($email);
		if (strlen($name) > 0) {
			$sx = $name . ' <' . $email . '>';
		} else {
			$sx = $email;
		}
		return ($sx);
	}
?>