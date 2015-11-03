<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt

?>

<?php
  /**
  * Reports page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
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
	
	//array_push($menu,array(msg('committee_reports_cust'),msg('report_011'),'report_011.php'));
	}

	array_push($menu,array(msg('committee_reports_secr'),msg('scheduled_meeting'),'meeting_scheduled.php'));
	//array_push($menu,array(msg('committee_reports_secr'),msg('report_021'),'report_021.php'));

	echo '<div class="border1 pad5 ml2 mt20">';
	echo '<h1>' . msg('report_menu') . '</h1>';
	$tela = menus($menu,"3");
	echo $tela;
	echo '</div>';
?>