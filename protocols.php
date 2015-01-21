<?php
 /**
  * Protocol
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */
require("cab.php");

/* Date Library */
require($include.'sisdoc_data.php');

/* CEP Class */
require("_class/_class_cep.php");
$cep = new cep;

echo '<H2>'.msg('protocolos').'</h2>';
echo '<H4>'.msg('cep_status_'.$dd[1]).'</h4>';

$ok1 = (($perfil->valid('#ADM')) or ($perfil->valid('#MAS')) or ($perfil->valid('##MEM')));
$ok2 = (($perfil->valid('#ADC')) and ($dd[1] == 'Z'));

if ($ok1 or $ok2)
	{
	echo $cep->protocolos_avaliacao($dd[1]);
	}

echo '</div>';

echo $hd->foot();
?>
<script>
	
</script>
