<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage faq
 */
 
require('cab.php');
require('_class/_class_faq.php');

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	$cl = new faq;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	$http_edit = $tabela.'_ed.php';
	$http_redirect = '';
	$tit = msg("tit".$tabela);
	
	/** Comandos de Edicao */
	echo '<CENTER><h2>'.$tit.'</h2></CENTER>';
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	
	echo '</div>';
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina($tabela.'.php');
		}
echo $hd->foot();	
?>

