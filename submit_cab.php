<?
echo '<div class="proto_menu">';
$edit_mode_old = $edit_mode; 

$cls = array('','prevStep','currentStep','','','','','','','','');
$cls = array('','','','','','','','','','','');

$ini = $pag;

for ($r=0;$r <= $ini;$r++) {$cls[$r] = 'prevStep'; }
$cls[$ini] = 'currentStep';
echo '<table width="100%" cellpadding=0 cellspacing=0 border=0 class="lt1">';

/* informa o total de paginas do Header */
/* Old - for ($r=1;$r < 7;$r++) */ 
for ($r=1;$r < $tot_paginas;$r++)
	{
		//$edit_mode = True;
		if ($doc_tipo != 'PROJE')
			{
				/* Label para monitoreo */
				$op = msg("top_submit_".$doc_tipo."_".$r);
			} else {
				/* Label para projeto */
				$op = msg("top_submit_menu_".$r);		
			}
		
		$name="item".$r;
		$class_name="topmenu_off";
		if ($ini == $r) { $class_name = 'topmenu_on'; }
		echo '<TD align="center" class="'.$class_name.'" height=30>';
		if ($protocolo != '0000000') { echo '<A HREF="submit.php?dd91='.$r.'">'; }
		echo '<center><font class="'.$class_name.'">';
		echo $op; 
		echo '</A></center>';
		echo '<TD class="'.$class_name.'" width="20">';
		echo '<img src="img/topmenu_sp.png">';
	}
echo '</table>';
$edit_mode = $edit_mode_old;

/* Omite título se não for projeto */
if ($doc_tipo == 'PROJE')
	{
		echo '<H1>'.msg("submit_process").'</h1>';
	}

/* Le dados do protocolo */
$proj->le($protocolo);

/* Classe que mostra os dados do protocolo */
echo $proj->protocolo_mostrar();

$clinic = round($proj->doc_clinic);
?>

