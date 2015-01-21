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

/* Date library */
require($include.'sisdoc_data.php');

/* CEP Class */
require("_class/_class_cep.php");
$cep = new cep;

echo '<H2>'.msg('protocolos').'</h2>';

echo '<div id="result" class="border1 pad5">';
echo $cep->protocolos_search($dd[50]);
echo '</div>';

echo '</div>';

echo $hd->foot();
?>
<script>
	
</script>
