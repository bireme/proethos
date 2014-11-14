<?php
$include = '';
$nosec = 1;
require("cab.php");
$nw = new users;
$chk = checkpost($dd[1]);

$nw->updatex();

if ($chk == $dd[90])
	{
		echo '<h2>'.msg('chk_email_ok_tit').'</h2>';
		echo msg('chk_email_ok');	
		$sql = "update ".$nw->tabela." set us_ativo = 1, us_confirmed = 1 ";
		$sql .= " where us_email = '".trim($dd[1])."' ";
		$rlt = db_query($sql);
	} else {
		echo '<h2>'.msg('chk_email_erro_tit').'</h2>';
		echo '<font color="red">';
		echo msg('chk_email_erro');
		echo '</font>';
	}
echo '</div>';;
echo $hd->foot();
?>

