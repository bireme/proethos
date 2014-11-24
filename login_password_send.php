<?php
    /**
     * Security
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package Proethos
	 * @subpackage Security
    */
    
require('db.php');
require($include.'_class_email.php');

require($include.'_class_form.php');
$form = new form;

/* load config committee */		
require("_class/_class_header_proethos.php");
$hd = new header;


require('_class/_class_ic.php');
$ic = new ic;

/* load config committee */		
require("_class/_class_committee.php");
$cmt = new committee;
if ($cmt->config_exist_file()!=0)
	{ require_once($cmt->file); }

echo $hd->head();
$hd->load_committe();

require('_class/_class_message.php');
$ln = new message;
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

require('_class/_class_user.php');
$nw = new users;

echo '<h2>'.msg('send_email').'</h2>';

/* SQL Injection */
$dd[1] = email_restrition($dd[1]);
	
$form->class = ' class="lt1" style="width: 90%;" ';
$form->required_message_post = 0;
$cp = array();
array_push($cp,array('$H8','','',False,False));
array_push($cp,array('$S100','',msg('email'),True,True));
array_push($cp,array('$B8','',msg('send_email'),False,True));
$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		$rs = $nw->send_pass_email($dd[1]);
		if (trim($rs) == 'send_email_ok')
			{
				echo '<h2>'.$rs.'</h2>';
			} else {
				echo $tela;
				echo '<font color="red">'.$rs.'</font>';
			}
	} else {
		echo msg('send_email_info');
		echo $tela;
			
	}


?>