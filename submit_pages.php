<?
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
				echo '<TD class="page_normal">'.$link.$r,'</A></TD>';	
			} 
			
		}

echo '</TR></table>';
} 
?>