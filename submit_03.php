<?php
 /**
  * Sumissão de protocolo de pesquisa
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.22
  * @package Class
  * @subpackage UC0001 - Sumissão de protocolo de pesquisa
 */
require('submit_00_field.php');

	if (strlen($acao) > 0) 
		{ 
		require('submit_save.php');
		}
		
echo '<TR><TD colspan=2>'; 
require('submit_pages.php');

echo $s;

echo '</table>';

if (($ok > 0) and (strlen($acao) > 0))
	{
		$_SESSION['proj_page'] = ($pag+1);
		redirecina('submit.php?time'.date("dmYhis"));
	}
?>

<script>
<?
echo $scripts;
?>
</script>