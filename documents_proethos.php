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
array_push($ar,array(msg('proethos_doc_guia'),'_documents/Guiding questions for reviewers ('.$LANG.').doc'));
array_push($ar,array(msg('proethos_doc_adve'),'Formato reporte eventos adversos ('.$LANG.').doc'));

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
array_push($ar,array(msg('proethos_doc_diap'),'_documents/APROBADO ('.$LANG.').doc'));
array_push($ar,array(msg('proethos_doc_diac'),'_documents/CONDICIONALMENTE APROBADO ('.$LANG.').doc'));
array_push($ar,array(msg('proethos_doc_dina'),'_documents/NO APROBADO ('.$LANG.').doc'));
array_push($ar,array(msg('proethos_doc_diex'),'_documents/EXENTO ('.$LANG.').doc'));
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