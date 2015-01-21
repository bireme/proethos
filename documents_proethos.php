<?
$img = '';

array_push($ar,array(msg('proethos_doc_adve'),''));

/* Header */
$sx = '
<h1>'.msg('proethos_files').'</h1>
<span class="lt0">'.msg('proethos_files_inf').'</span>
<BR>';

$sx .= '<table class="tabela00" width="100%" border=0 >';
$sx .= '<TR>';

/* Part One */
$sx .= '<TD width="50%">';
$sx .= '<h3>'.msg('proethos_docs').'</h3>';

$ar = array();
array_push($ar,array(msg('proethos_doc_guia'),''));
array_push($ar,array(msg('proethos_doc_adve'),''));

$sx .= '<UL>';
for ($r=0;$r < count($ar); $r++)
	{
		$sx .= '<LI>';
		$sx .= '<A href="'.$ar[$r][1].'" target="_new">';
		$sx .= $ar[$r][0];
		$sx .= '</A>';
		$sx .= '</LI>';
	}
$sx .= '</UL>';

/* Part One */
$sx .= '<TD width="50%">';
$ar = array();
array_push($ar,array(msg('proethos_doc_diap'),''));
array_push($ar,array(msg('proethos_doc_diac'),''));
array_push($ar,array(msg('proethos_doc_dina'),''));
$sx .= '<h3>'.msg('proethos_doc_dict').'</h3>';
$sx .= '<UL>';
for ($r=0;$r < count($ar); $r++)
	{
		$sx .= '<LI>';
		$sx .= '<A href="'.$ar[$r][1].'" target="_new">';
		$sx .= $ar[$r][0];
		$sx .= '</A>';
		$sx .= '</LI>';
	}
$sx .= '</UL>';
$sx .= '</table>';

echo $sx;
?>