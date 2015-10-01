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


/**
 * Sumissão de protocolo de pesquisa
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.12.22
 * @package Class
 * @subpackage UC0001 - Sumissão de protocolo de pesquisa
 */
require ("_class/_class_cep_submit_institution.php");
$inst = new instituicao;

$pag = 3;

echo '<B>' . msg('submit_checklist') . '</B>';
require ('submit_checklist_amendment.php');

echo '<BR>';

		$sx = '<span id="create_pdf" class="form_submit">'.msg('create_PDF').'</span>';
		$sx .= '
				<script>
				$("#create_pdf").click(function() {
					window.open(\'submit_amendment_pdf.php?dd0='.$protocolo.'&dd90='.checkpost($protocolo.$secu).'\', \'pdf\', \'create pdf\');
				});
				</script>
				';	
		echo $sx;

echo '<BR><BR>';
/* Compromisso */
//if (strlen($dd[81]) == 0) { $xok = 0; }

if ($xok == 1) {
	if (strlen($dd[81]) > 0) { redirecina('submit_end_monitoreo.php');
	}
	/* Termo */
	require ('submit_pages.php');

	echo '<form action="submit.php">';
	echo '<BR>';
	echo mst(msg('submit_term_'.$doc_tipo));

	echo '<input type="hidden" name="dd81" value="1">';
	echo '<BR>';
	echo '<input type="submit" value="' . msg('submit_monitoreo') . '" class="form_submit">';
	echo '</form>';
} else {
	echo msg('exist_pending_submit');
}
?>
<script></script>