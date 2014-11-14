<?php
require ("cab.php");

echo '<h1>E-mail system check</h1>';

echo '<div class="border1 pad5">';
echo '<h2>E-mail</h2>';

require ($include . '_class_email.php');

require ($include . '_class_form.php');
$form = new form;
$cp = array();
array_push($cp, array('$S100', '', 'e-mail to send', True, True));
array_push($cp, array('$B8', '', 'send test >>>', False, True));


$tela = $form -> editar($cp, $tabela);

if ($form -> saved > 0) {
	echo $tela;
	$email = $dd[0];
	if (checaemail($email) == 1) {
		echo '<BR>SMTP-Server: ' . $hd -> email_smtp;
		echo '<BR>E-mail user: ' . $hd -> email;
		$ok = enviaremail($email, '', 'teste', 'teste');
		echo $ok;
		if ($ok >= 0) {
			echo '<P>An test was send to ' . $email;
		} else {
			echo '<P>Error</P>';
		}
	} else {
		echo '<BR><font color="red">e-mail invalid</font>';
	}
} else {
	echo $tela;
}
echo '</div>';

echo $hd -> foot();
?>
