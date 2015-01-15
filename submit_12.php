<?php
 /**
  * Sumissão de protocolo de pesquisa
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v0.12.22
  * @package Class
  * @subpackage UC0001 - Sumissao de protocolo de pesquisa
 */
$amendment_type = $proj->amendment_type;
$pagx = $pag;
$pag = $pag + 10*round($amendment_type);

require('submit_00_field.php');

	if (strlen($acao) > 0) 
		{ 
		require('submit_save.php');
		}

echo $s;
$pag = $pagx;
echo '<TR><TD colspan=2>'; require('submit_pages.php');
echo '</table>';

if (($ok > 0) and (strlen($acao) > 0))
	{
		$_SESSION['proj_page'] = ($pag+1);
		redirecina('submit.php?time'.date("dmYhis"));
	}
?>
