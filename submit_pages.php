<? 
if ($protocolo != '0000000') {
?>
<table class="pageactive">
	<TR>
		<TD><?=msg('pages');?></TD>
		<? for ($r=1;$r <=$pag_max ; $r++) {
			$link = '<A HREF="submit.php?dd91='.$r.'" class="pageactive">';
			if ($pag == $r) {
					$link = ''; 
					echo '<TD>'.$r,'</TD>';	
				} else {
					echo '<TD>'.$link.$r,'</A></TD>';	
				} 
				
			}
		?> 
	</TR>
</table>
<? } ?>