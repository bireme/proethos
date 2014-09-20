<?php
 /**
  * Sumissão de protocolo de pesquisa
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
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

echo $s;
echo '<TR><TD colspan=2>'; require('submit_pages.php');
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
//	$("#dd2").example('Introduction');
//	$("#dd5").example('Insert the goal');
//	$("#dd7").example('Insert the specific goal');
//	$("#dd10").example('Design Study');
//	$("#dd12").example('methodology');
?>
</script>

<script type="text/javascript">
var $tela = $.ajax({ url: "submit_ajax.php", type: "POST", 
			data: { dd11: "<?=$protocolo;?>", dd10: "budget" ,dd12: "<?php echo $bud->protocolo; ?>" }
			})
			.fail(function() { alert("error"); })
 			.success(function(data) { $("#budget").html(data); });
			;
var $tela = $.ajax({ url: "submit_ajax.php", type: "POST", 
			data: { dd11: "<?=$protocolo;?>", dd10: "crono" ,dd12: "<?php echo $bud->protocolo; ?>" }
			})
			.fail(function() { alert("error"); })
 			.success(function(data) { $("#crono").html(data); });
			;	
</script>