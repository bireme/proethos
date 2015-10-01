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


$include = '';
$nosec = 1;
require("cab.php");
$nw = new users;
$chk = checkpost($dd[1]);

$nw->updatex();

echo '<H1>'.msg('user_new').'</h1>';

$ok1 = (($perfil->valid('#ADM')) or ($perfil->valid('#MAS')) or ($perfil->valid('##MEM')));
$ok2 = (($perfil->valid('#ADC')) and ($dd[1] == 'Z'));

/* Nao alterar - dados comuns */

if ($chk == $dd[90])
	{
		echo '<h2>'.msg('chk_email_ok_tit').'</h2>';
		echo '<table width="100%"><TR><TD>'.msg('chk_email_ok').'</table>';	
		$sql = "update ".$nw->tabela." set us_ativo = 1, us_confirmed = 1 ";
		$sql .= " where us_email = '".trim($dd[1])."' ";
		$rlt = db_query($sql);
	} else {
		echo '<h2>'.msg('chk_email_erro_tit').'</h2>';
		echo '<font color="red">';
		echo msg('chk_email_erro');
		echo '</font>';
	}
echo '</div>';
echo '</div>';
echo $hd->foot();
?>