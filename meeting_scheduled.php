<?php
 /**
  * Scheduled Popup
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Scheduled
 */
require("cab.php");
require($include.'sisdoc_data.php');
require("_class/_class_meeting.php");
$mt = new meeting;

require($include.'_class_form.php');
$form = new form;

if (strlen($dd[2])==0) { $dd[2] = '10'; }
$cp = array();
array_push($cp,array('$H8','','',false,true));
array_push($cp,array('$D8','','<nobr>'.msg('scheduled_meeting'),True,true));
array_push($cp,array('$[6-20]','','<nobr>'.msg('works_for_page'),True,true));
array_push($cp,array('$B8','',msg('show'),False,true));

if ((strlen($acao)==0) or (strlen($dd[1]) < 10))
	{
	echo '<h2>'.msg('agenda_for_meeting').'</h2>';
	echo '<TABLE width="400" border=0 class="tabela01" >
			<TR><TH colspan=2 align="center" class="tabela00">
			'.msg('inform_the_data').'
			<TR><TD>';
	$tela = $form->editar($cp,$tabela);
	echo '</table>';
	} else {
		$form->saved = 1;
	}	

if ($form->saved > 0)
	{
		echo $tela;
		$data = brtos($dd[1]);
		echo $mt->mostra($data,$dd[2]);
	} else {
		echo $tela;
	}

echo $mt->mostra_proximas();

echo '</div>';


echo $hd->foot();
?>
<script>
	
</script>
