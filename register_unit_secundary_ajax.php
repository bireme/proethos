<?
 /**
  * Register Unit
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Ajax
 */
require("db.php");
require("_class/_class_message.php");
require($include.'sisdoc_colunas.php');
$ref=$dd[6];
$protocol = $dd[1];
$autor=$dd[3];
$campo = $dd[4];
$unit = $dd[10];
$number = $dd[11];

/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }
$LANG = $lg->language_read();
$edit_mode = round($_SESSION['editmode']);

require('_class/_class_register_unit.php');
$register = new register_unit;

/**** Funções ****/	
if ($dd[2]=='add') { $register->dados_add($protocol,$unit,$number);  }
if ($dd[2]=='del') { $register->dados_del($protocol,$number); }

/** Mostra os registros e formulario **/

$ops = $register->lista('S');
if (count($ops) > 0)
{
echo '<fieldset><legend>'.msg('register_secundary').'</legend>';
$op = '';
for ($r=0;$r < count($ops);$r++)
	{
		$op .= '<option value="'.$ops[$r][0].'">';
		$op .= $ops[$r][1];
		$op .= '</option>';
	}
$reg_id = $ref_.'_op';
$linka = 'register_unit_ajax.php?dd1='.$protocol.'&dd2=add&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
$linkr = 'register_unit_ajax.php?dd1='.$protocol.'&dd2=del&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
?>
<table width="100%" class="lt1" cellspacing="0" cellpadding="3" border=0>
	<TR><TD><?=msg('reg_unit');?></TD><TD><select name="<?=$reg_id;?>a" id="<?=$reg_id;?>a"><?=$op;?></select></TD></TR>
	<TR><TD><?=msg('reg_number');?></TD><td><input type="text" size=20 maxlength="20" id="<?=$reg_id;?>b">
		<input type="button" name="<?=$reg_id;?>z" id="<?=$reg_id;?>z" value="<?=msg('reg_botao');?>" />
	</td></TR>
</table>
<BR><BR>

<?
/**
 * Listar dados cadastrados de registros
 */
	echo '<table width="100%" class="lt1" cellspacing="0" cellpadding="3" border=1>';
	echo '<TR><TH>'.msg('register_unit').'</TH><TH>'.msg('number').'</TH>';
	echo '<TH>'.msg('acao');
	echo '</TR>';
	
	$regs = $register->dados_lista($protocol,'S');
	for ($r=0;$r < count($regs);$r++)
		{
			$line = $regs[$r];
			echo '<TR>';
			echo '<TD>'.$line['ru_name'];
			echo '<TD>'.$line['csru_number'];
			echo '<TD align="center">';
			$onclick = 'onclick="remove_register('.$line['id_csru'].')" ';
			echo '<img src="img/icone_remove.png" '.$onclick.'>';
		}
	?>
	</table>
<?
echo '</field>';
}
?>