<?
$link1 = '<A HREF="" class="link lt2">';
$link2 = '<A HREF="" class="link lt2">';

$link3 = '<A HREF="" class="link lt2">';
$link4 = '<A HREF="" class="link lt2">';
$link5 = '<A HREF="" class="link lt2">';

$sx = '
<h2>'.msg('proethos_files').'</h2>
<table class="table_file" width="100%" border=0 >
	<tbody>
		<TR class="lt2" valign="top">
			<td>'.$link1.msg('proethos_doc_guia').'</A>
			<br>'.$link2.msg('proethos_doc_adve').'</A>
			
			</td>			
			<td rowspan=5><B>'.msg('proethos_doc_dict').'</B>		
			<uL>
				<li>'.$link3.msg('proethos_doc_diap').'</A></li>
				<li>'.$link4.msg('proethos_doc_diac').'</A></li>
				<li>'.$link5.msg('proethos_doc_dina').'</A></li>
			<uL>
		</table>		
</table>';
echo $sx;
?>