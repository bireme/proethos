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
	require_once 'libs/email/PHPMailerAutoload.php';
	echo $tela;

	$email = $dd[0];
	if (checaemail($email) == 1) {
		echo '<BR>SMTP-Server: ' . $hd -> email_smtp;
		echo '<BR>E-mail user: ' . $hd -> email .' &lt;'.$hd->email_name.'&gt;';

		/* Send e-mail test */
		echo '<table width="100%"><TR><TD>';

		/* Sample */
		$title_sample_original = 'Proethos - Email test';
		$message_sample = '<h1>Email was sent with Successful!</h1>';
		$smtp = trim($hd -> email_smtp);
		$from = trim($hd -> email);
		$replay = trim($hd -> email_replay);
		$pass = trim($hd -> email_pass);
		$from_name = $hd->email_name;
		$email_to = $dd[0];
		
		//print_r($hd);
		

		/* Method 1 */
		echo '<HR><h1>Method 1</h1>';
		$title_sample = $title_sample_original . ' - Method 1';
		require ("_system_emal_test_menthod_1.php");

		/* Method 2 */
		echo '<HR><h1>Method 2</h1>';
		$title_sample = $title_sample_original . ' - Method 2';
		require ("_system_emal_test_menthod_2.php");

		echo '</TD></TR></table>';
	} else {
		echo '<BR><font color="red">e-mail invalid</font>';
	}
} else {
	echo $tela;
}
echo '</div>';

echo $hd -> foot();
?>
