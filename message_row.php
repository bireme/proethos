<?
 /**
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Menssages
 */
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");

require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

if (strlen($dd[1]) > 0)
	{
		$sql = "delete from ".$messa->tabela."._messages
			where msg_field = '".trim($dd[1])."'";
		$rlt = db_query($sql);
		exit;
		
	}

$sql = "select * from ".$messa->tabela."._messages
		order by msg_field, msg_language
";
$rlt = db_query($sql);

$xfld = 'xxxx';
echo '<table width="800" bgcolor="white" class="lt0" border=1 cellpadding=2 cellspacing=0>';
echo '<TR><TH>Field';
echo '<TH width="5">AC';
echo '<TH>English';
echo '<TH>Spanish';
echo '<TH>French';
echo '<TH>Portugues';
while ($line = db_read($rlt))
	{
		$fld = trim($line['msg_field']);
		if (strlen($fld) > 0)
		{
		if ($xfld != $fld)
			{
				$s = $line['msg_field'];
				$link = '<A href="javascript:newxy2(';
				$link .= "'message_ed_pop.php?dd2=" . page() . "&dd1=" . $s;
				$link .= "',600,300);";
				$link .= '">';
				$cor = '';
				echo '<TR>';
				echo '<TD>'.$link.$fld;
				echo '&nbsp;';
				echo '<TD>';
				if (trim($line['msg_field'])==trim($line['msg_content']))
					{
						echo '<A HREF="'.page().'?dd1='.trim($line['msg_field']).'" target="new">XX</A></TD>';
					}
				$xfld = $fld;
			}
		$mmm = trim($line['msg_content']);
		$cor = '<font color="grey">';
		if ($mmm == $fld) { $cor = '<font color="red">'; }
		echo '<TD>'.$link.$cor.trim($line['msg_content']).'</font></A>';
		}
	}
echo '</table>';
echo '</div>';
echo $hd->foot();	
?>