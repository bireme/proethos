<?php
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

