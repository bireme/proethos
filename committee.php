<?php
  /**
  * Committe page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos
  * @subpackage Committe
 */
 
/* mark active page to cabmenu */
$active_page = 'committee';

require("cab.php");
require($include.'sisdoc_menus.php');
require("_class/_class_resume.php");
require("_class/_class_cep.php");

require($include.'sisdoc_debug.php');
$cep = new cep;

$rs = new resume;

	echo $rs->resume_cep();

	echo $cep->form_search();
	
	//echo $cep->form_search();
	
require("committee_secretary.php");

require("committee_reports.php");

echo '</div>';
?>
<script>
	
</script>
<?php 
echo $hd->foot();
?>
