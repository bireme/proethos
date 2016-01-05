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
 * Ged - Download file
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.11.29
 * @package index
 * @subpackage ged
 */

require ("db.php");

header("Content-type: text/xml");

$sql = "select * from cep_submit_manuscrito_field ";
$rlt = db_query($sql);
echo '<fields>' . cr();
while ($line = db_read($rlt)) {
	$sa = '<reg>'.cr();
	$sa .= '<sub_pos>'.$line['sub_pos'].'</sub_pos>'.cr();
	$sa .= '<sub_field>'.$line['sub_field'].'</sub_field>'.cr();
	$sa .= '<sub_css>'.$line['sub_css'].'</sub_css>'.cr();
	$sa .= '<sub_descricao>'.$line['sub_descricao'].'</sub_descricao>'.cr();
	$sa .= '<sub_ativo>'.$line['sub_ativo'].'</sub_ativo>'.cr();
	$sa .= '<sub_codigo>'.$line['sub_codigo'].'</sub_codigo>'.cr();
	$sa .= '<sub_pag>'.$line['sub_pag'].'</sub_pag>'.cr();
	$sa .= '<sub_obrigatorio>'.$line['sub_obrigatorio'].'</sub_obrigatorio>'.cr();
	$sa .= '<sub_editavel>'.$line['sub_editavel'].'</sub_editavel>'.cr();
	$sa .= '<sub_informacao>'.$line['sub_informacao'].'</sub_informacao>'.cr();
	$sa .= '<sub_projeto_tipo>'.$line['sub_projeto_tipo'].'</sub_projeto_tipo>'.cr();
	$sa .= '<sub_ordem>'.$line['sub_ordem'].'</sub_ordem>'.cr();
	$sa .= '<sub_pdf_title>'.$line['sub_pdf_title'].'</sub_pdf_title>'.cr();
	$sa .= '<sub_pdf_mostra>'.$line['sub_pdf_mostra'].'</sub_pdf_mostra>'.cr();
	$sa .= '<sub_pdf_align>'.$line['sub_pdf_align'].'</sub_pdf_align>'.cr();
	$sa .= '<sub_pdf_font_size>'.$line['sub_pdf_font_size'].'</sub_pdf_font_size>'.cr();
	$sa .= '<sub_pdf_space>'.$line['sub_pdf_space'].'</sub_pdf_space>'.cr();
	$sa .= '<sub_limite>'.$line['sub_limite'].'</sub_limite>'.cr();
	$sa .= '<sub_caption>'.$line['sub_caption'].'</sub_caption>'.cr();
	$sa .= '<sub_id>'.$line['sub_id'].'</sub_id>'.cr();
	$sa .= '</reg>'.cr();
	$sa = troca($sa,'&','[e]');
	echo $sa;
}
echo '</fields>' . cr();

function cr() {
	$sx = chr(13) . chr(10);
	return ($sx);
}
?>

