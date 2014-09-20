<?php
  /**
  * Reports page
  * @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos
  * @subpackage Reports
 */
$menu = array();
if (($perfil->valid('#ADM')) or ($perfil->valid('#MAS'))) 
	{
	/////////////////////////////////////////////////// MANAGERS
	array_push($menu,array(msg('committee_reports'),msg('report_001'),'report_001.php'));
	array_push($menu,array(msg('committee_reports'),msg('report_002'),'report_002.php'));
	array_push($menu,array(msg('committee_reports'),msg('report_003'),'report_003.php'));
	array_push($menu,array(msg('committee_reports'),msg('report_004'),'report_004.php'));
	
	array_push($menu,array(msg('committee_reports_cust'),msg('report_011'),'report_011.php'));
	}

	array_push($menu,array(msg('committee_reports_secr'),msg('scheduled_meeting'),'meeting_scheduled.php'));
	array_push($menu,array(msg('committee_reports_secr'),msg('report_021'),'report_021.php'));

	echo '<div class="border1 pad5 ml2 mt20">';
	echo '<h1>' . msg('report_menu') . '</h1>';
	$tela = menus($menu,"3");
	echo $tela;
	echo '</div>';
?>
