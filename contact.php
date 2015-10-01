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


  /**
  * Contact page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos
  * @subpackage Contact
 */
/* mark active page to cabmenu */
$active_page = 'contact';
$nosec = 1;
require("cab.php");

require("_class/_class_committee.php");
$cmt = new committee;
$cmt->le();

	echo '<H1>'.mst(msg('contact_us')).'</H1>';
	
	
	
	echo '<BR>';
	echo '<fieldset>';
	echo '<font class="lt3"><B>'.$cmt->institution_name.'</B></font>';
	echo '<BR>';
	echo '<A HREF="'.$cmt->institution_site.'">'.$cmt->institution_site.'</a>';
	echo '<BR>';
	echo mst($cmt->institution_email);
	echo '<BR><BR>';
	echo mst($cmt->institution_address);
	echo '<BR>';
	echo $cmt->institution_city.' - '.$cmt->institution_country;
	echo '<BR>';
	echo msg('phone_number').' '. $cmt->institution_phone;
	echo '<BR><BR>';
	
	/* Coordenadas */
	$institution_xpos = $cmt->institution_xpos;
	$institution_ypos = $cmt->institution_ypos;
	
	echo '
	<script>
	var committee_name = \'Comitê de Ética em Pesquisa \nPontifícia Universidade Católogica do Paraná\nCuritiba - PR - Brasil\';
	var xcoor = '.$institution_xpos.';
	var ycoor = '.$institution_ypos.';
	</script>
	';
	echo '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>';
	echo '<script src="js/google_maps.js"></script>';
	echo '<div id="map-canvas" style=" height: 100%; margin: 0px; padding: 0px"></div>';
	echo '</fieldset>';
echo '</div>';

echo $hd->foot();
?>
<script>
	
</script>