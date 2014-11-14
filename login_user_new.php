<?php
$include = '';
$nosec = 1;

/* Add Styles */
$style_add = array('proethos_new_user.css');
require("cab.php");

require($include.'_class_email.php');
require($include.'_class_form.php');
$mail = new email;
$form = new form;

			$form -> required_message = 0;
			$form -> required_message_post = 0;
			$form -> class_password = 'login_string';
			$form -> class_string = 'login_string';
			$form -> class_button_submit = 'login_submit';
			$form -> class_form_standard = 'login_table';
			$form -> class_select = 'login_string';
			$form -> class_textarea = 'login_textarea';

/* Login data */
$nw = new users;
$cp = $nw->cp();
		
	
		
	/* Check e-mail */
	$dd[1] = '';
	$dd[5] = email_restrition($dd[5]);
	$email = trim($dd[5]);
	
	if ($mail->email_check($email)==1)
		{
		$sql = "select * from ".$nw->tabela." where us_email = '".$email."' ";
		$rlt = db_query($sql);
			if ($line = db_read($rlt))
			{
				$cp[6][2] = '<font color="red">'.msg('email_exist').'</font>';	
			} else {
				$dd[1]='CHECKED';
			}
		} else {
			$cp[6][2] = '<font color="red">'.msg('is_not_valid_email').'</font>';
		}
		

echo '<Table width="'.$tab_max.'" class="lt1" align="center"  border=0 >';
echo '<TR><TD>';
echo '<h1>'.mst(msg('new_user_info')).'</h1>';

echo '<TR><TD>';
	
$tela = $form->editar($cp,$nw->tabela);

if ($form->saved > 0)
	{
		$nw->updatex();

		echo mst(msg('confirm_email'));
		$texto = '<BR>'.$dd[3];
		$texto .= '<BR>'.$dd[5].'<BR><BR>';
		if (substr($site,strlen($site),1)=='/')
			{
				$valid = $site.'login_user_valid.php?dd1='.$dd[5].'&dd90='.checkpost($dd[5]);
			} else {
				$valid = $site.'/login_user_valid.php?dd1='.$dd[5].'&dd90='.checkpost($dd[5]);	
			}
		
		$link = '<A HREF="'.$valid.'">';
		$texto .= $link.$valid.'</A><BR><BR>';
		
		$texto .= 'email_confirm_email';
		
		$sql = "select * from usuario where us_email = '".$email."' ";
		$rlt = db_query($sql);
		if ($line = db_read($rlt))
			{
			$email = trim($line['us_email']);		
			enviaremail($email,'',msg('confirm_email_title'),$texto);
			echo '<BR><BR>Send mail to '.$email;
			$email = 'renefgj@gmail.com';		
			enviaremail($email,'',msg('confirm_email_title'),$texto);
			//echo '<BR>Send mail to '.$email;
			}
		echo '</table>';
	} else {
		echo $tela;	
		echo '</table>';	
	}

echo $hd->foot();
?>