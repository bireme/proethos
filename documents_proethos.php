<?
$link1 = '<A HREF="" class="link lt2">';
$link2 = '<A HREF="" class="link lt2">';

$link3 = '<A HREF="" class="link lt2">';
$link4 = '<A HREF="" class="link lt2">';
$link5 = '<A HREF="" class="link lt2">';

$sx = '
<h1>'.msg('proethos_files').'</h1>
<BR>';
$sx .= '<fieldset>';

$sx .= '<table class="table_file" width="100%" border=0 >
	<tbody>
		<TR class="lt2" valign="top">
			<td>
				<ul class="documents">
				<li>'.$link1.msg('proethos_doc_guia').'</A></li>
				<li>'.$link2.msg('proethos_doc_adve').'</A></li>
				</ul>
			
			</td>			
			<td rowspan=5><B>'.msg('proethos_doc_dict').'</B>		
			<uL class="documents">
				<li>'.$link3.msg('proethos_doc_diap').'</A></li>
				<li>'.$link4.msg('proethos_doc_diac').'</A></li>
				<li>'.$link5.msg('proethos_doc_dina').'</A></li>
			<uL>
		</table>		
</table>';
$sx .= '</fieldset>';
echo $sx;
?>
