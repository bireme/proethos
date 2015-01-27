<? 
if ($protocolo != '0000000') {
echo '
<table class="tabela00">
	<TR>
		<TD>'.msg('pages').'</TD>';
for ($r=1;$r <=$pag_max ; $r++) 
	{
		
		if ($pag == $r) {
				$link = ''; 
				echo '<TD class="pageactive">'.$r,'</TD>';	
			} else {
				$link = '<A HREF="submit.php?dd91='.$r.'">';
				echo '<TD>'.$link.$r,'</A></TD>';	
			} 
			
		}

echo '</TR></table>';
} 
?>