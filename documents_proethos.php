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

$img = '';
$path = 'document/templates/';

/* Header */
$sx = '
<h1>' . msg('proethos_files') . '</h1>
<span class="lt0">' . msg('proethos_files_inf') . '</span>
<BR>';

$sx .= '<table class="tabela00" width="100%" border=0 >';
$sx .= '<TR valign="top">';

/* Part One */
$sx .= '<TD width="50%">';
$sx .= '<h3>' . msg('proethos_docs') . '</h3>';

$ar = array();
array_push($ar, array(msg('proethos_doc_guia'), $path . 'Guiding questions for reviewers (' . $LANG . ').rtf'));

$sx .= '<UL>';
for ($r = 0; $r < count($ar); $r++) {
	$sx .= '<LI>';
	$sx .= '<A href="' . $ar[$r][1] . '" target="_new">';
	$sx .= $ar[$r][0];
	$sx .= '</A>';
	$sx .= '</LI>';
}
$sx .= '</UL>';

/* Part Two */
$sx .= '<TD width="50%">';
$sx .= '<h3>' . msg('proethos_docs_models') . '</h3>';

$ar = array();
array_push($ar, array(msg('proethos_doc_adve'), $path . 'Reporte eventos adversos (' . $LANG . ').rtf'));
array_push($ar, array(msg('proethos_doc_soli_exte'), $path . 'Solicitud de EXTENSION DE APROBACION (' . $LANG . ').rtf'));
array_push($ar, array(msg('proethos_doc_soli_emen'), $path . 'Solicitud de ENMIENDA (' . $LANG . ').rtf'));

$sx .= '<UL>';
for ($r = 0; $r < count($ar); $r++) {
	$sx .= '<LI>';
	$sx .= '<A href="' . $ar[$r][1] . '" target="_new">';
	$sx .= $ar[$r][0];
	$sx .= '</A>';
	$sx .= '</LI>';
}
$sx .= '</UL>';

$sx .= '<TR valign="top">';

/* Part Three */
$sx .= '<TD colspan=2>';
$ar = array();
array_push($ar, array(msg('proethos_doc_diap'), $path . 'APROBADO (' . $LANG . ').rtf'));
array_push($ar, array(msg('proethos_doc_diac'), $path . 'CONDICIONALMENTE APROBADO (' . $LANG . ').rtf'));
array_push($ar, array(msg('proethos_doc_dina'), $path . 'NO APROBADO (' . $LANG . ').rtf'));
array_push($ar, array(msg('proethos_doc_diex'), $path . 'EXENTO (' . $LANG . ').rtf'));

array_push($ar, array(msg('proethos_doc_apem'), $path . 'aprobacion ENMIENDA (' . $LANG . ').rtf'));
array_push($ar, array(msg('proethos_doc_apex'), $path . 'aprobacion EXTENSION (' . $LANG . ').rtf'));

if (($perfil -> valid('#ADM')) or ($perfil -> valid('#COO')) or ($perfil -> valid('#MEN')) or ($perfil -> valid('#SCR'))) {
	$sx .= '<h3>' . msg('proethos_doc_dict') . '</h3>';
	$sx .= '<UL>';
	for ($r = 0; $r < count($ar); $r++) {
		$sx .= '<LI>';
		$sx .= '<A href="' . $ar[$r][1] . '" target="_new">';
		$sx .= $ar[$r][0];
		$sx .= '</A>';
		$sx .= '</LI>';
	}
	$sx .= '</UL>';
}
$sx .= '</table>';

echo $sx;
?>