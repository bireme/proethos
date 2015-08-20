<?php
 /**
  * Sumissão de protocolo de pesquisa
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.22
  * @package Class
  * @subpackage UC0001 - Sumissão de protocolo de pesquisa
 */
require("_class/_class_cep_submit_institution.php");
$inst = new instituicao;

$pag = 7;

echo '<table width="'.$tab_max.'" class="lt0">';
echo '<TR><TD colspan=2>'; require('submit_pages.php');
echo '</table>';

echo '<B>'.msg('submit_checklist').'</B>';
require('submit_checklist.php');
		
		echo '<BR>';
		
		$sx = '<span id="create_pdf" class="form_submit">'.msg('create_PDF').'</span>';
		$sx .= '
				<script>
				$("#create_pdf").click(function() {
					window.open(\'submit_pdf.php?dd0='.$protocolo.'&dd90='.checkpost($protocolo.$secu).'\', \'pdf\', \'create pdf\');
				});
				</script>
				';	
		echo $sx;

echo '<BR><BR>';
/* Compromisso */
//if (strlen($dd[81]) == 0) { $xok = 0; }

if ($xok == 1)
	{
		if (strlen($dd[81]) >0)
		{ redirecina('submit_end.php'); }
		/* Termo */
		echo '<form action="submit.php">';
		echo '<BR>';
		echo '<table width="!00%"><TR><TD>';
		echo mst(msg('submit_term'));
		echo '</table>';

		echo '<BR><B>';
		echo '<input type="checkbox" name="dd81" value="1">';
		echo msg('submit_term_accepted');
		echo '</B>';
		echo '<BR>';
		echo '<input type="submit" value="'.msg('#save_next').'" class="form_submit">';
		echo '</form>';		
	} else {
		echo msg('exist_pending_submit');
	}
?>
<script>

</script>