<?php
require("cab_install.php");
require("_class_install.php");
$inst = new install;

/* Header */
echo '<h1>Config at Data Base</h1>';

/* Check if directory exist */
$chk = $inst->check_directory_privileges('../_db');

/* Mostrar erro se $chk for diferente de 1 */
if ($chk != 1)
	{
		echo '<div class="erro">';
		echo $chk;
		echo '</div>';
		exit;
	}

/* Formulario */
require($include."_class_form.php");
$form = new form;

/* Formulário Campos */
$ops = '';
$ops .= ' : ';
$ops .= '&mysql:MYSQL';
$ops .= '&mysqlPDO:MySQL(PDO)';
$cp = array();
array_push($cp,array('$H8','','',False,True));
array_push($cp,array('$O '.$ops,'','Base type',False,True));
array_push($cp,array('$S40','','Database host',False,True));
array_push($cp,array('$S30','','Database name',False,True));
array_push($cp,array('$S30','','User name',False,True));
array_push($cp,array('$P30','','Password',False,True));

/* param */
$form->ajax = 1;
$form->frame = 'answer';
$form->form_name = 'answer';

$tela = $form->editar($cp,'');
echo $tela;

echo '<div id="answer">';
echo '<div id="answer_field"></div>';
echo '<div id="config_file"></div>';
echo '</div>';

?>
