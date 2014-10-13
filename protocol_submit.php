<?php
 /**
  * Protocol
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */
 
/* Add Styles */
$style_add = array('proethos_form.css');

require("cab.php");
require($include.'sisdoc_data.php');
require('_class/_class_cep.php');

$cep=new cep;

require('_class/_class_cep_submit.php');
$submit=new submit;

require('_class/_class_cep_email.php');
$comm = new comunication;

/* recupara ID do projeto */
$ID = strzero($dd[0],7);
$submit->le($ID);
$doc_tipo = $submit->doc_tipo;

/* Action */
$acao = $dd[5];
if ($acao == 'TO_SUBMIT')
	{
		$submit->protocolo_to_submit();
		redirecina('submit.php?dd0='.$dd[0].'&dd90='.checkpost($dd[0]));	 
	}
	

echo '<h1>Protocolo: '.$submit->status_show($submit->doc_status).'</h1>';

echo $submit->protocolo_mostrar();
$status = trim($submit->doc_status);

echo '<BR>';
require("_ged_config.php");
$ged->protocol = $ID;
echo $ged->filelist();

/*
 * Hidden Other information
 */
if ($acao == 'TO_CANCEL_ASK') { $status = '@@'; }
if ($acao == 'TO_CANCEL') { $status = '@@@'; }
	

if (trim($status) == '$')
	{
	echo '<form method="post">';
	echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
	echo '<input type="hidden" name="dd1" value="'.$dd[1].'">';
	echo '<input type="hidden" name="dd2" value="'.$dd[2].'">';
	echo '<input type="hidden" name="dd5" value="TO_SUBMIT">';
	echo '<input type="submit" value="'.msg('submit_send_to_edit').'" class="form_submit">';
	echo '</form>';
	}

/* Submiss�o */
if (trim($status) == '@')
	{
	echo '<table width="100%">';
	echo '<TR align="center">';
	echo '<TD>';
	echo '<form method="post">';
	echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
	echo '<input type="hidden" name="dd1" value="'.$dd[1].'">';
	echo '<input type="hidden" name="dd2" value="'.$dd[2].'">';
	echo '<input type="hidden" name="dd5" value="TO_SUBMIT">';
	echo '<input type="submit" value="'.msg('submit_send_to_edit').'" class="form_submit">';
	echo '</form>';

	echo '<TD>';
	echo '<form method="post">';
	echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
	echo '<input type="hidden" name="dd1" value="'.$dd[1].'">';
	echo '<input type="hidden" name="dd2" value="'.$dd[2].'">';
	echo '<input type="hidden" name="dd5" value="TO_CANCEL_ASK">';
	echo '<input type="submit" value="'.msg('cancel_this_project').'" class="form_submit">';
	echo '</form>';
	}
	
if (trim($status) == '@@')
	{
	echo '<table width="100%">';
	echo '<TR align="center">';
	echo '<TD>';
	echo '<form method="post">';
	echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
	echo '<input type="hidden" name="dd1" value="'.$dd[1].'">';
	echo '<input type="hidden" name="dd2" value="'.$dd[2].'">';
	echo '<input type="hidden" name="dd5" value="TO_CANCEL">';
	echo '<input type="submit" value="'.msg('confirm_cancel').'" class="form_submit">';
	echo '</form>';

	echo '<TD>';
	echo '<form method="post">';
	echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
	echo '<input type="hidden" name="dd1" value="'.$dd[1].'">';
	echo '<input type="hidden" name="dd2" value="'.$dd[2].'">';
	echo '<input type="hidden" name="dd5" value="">';
	echo '<input type="submit" value="'.msg('botton_return').'" class="form_submit">';
	echo '</form>';
	}	
	
if ($acao == 'TO_CANCEL')
	{
		if ($submit->protocolo_cancel())
			{
				echo '<font class="message_ok"><center>';
				echo msg('successfully_operation');
				echo '</center></font>';
				echo ' <META HTTP-EQUIV=Refresh CONTENT="5; URL=main.php">';
			}
		
	}
		
$comm->protocolo = $submit->doc_protocolo;
echo $comm->display();

echo '</table></div>';
echo $hd->foot();
?>
<script>
	
</script>