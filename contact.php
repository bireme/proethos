<?php
  /**
  * Contact page
  * @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos
  * @subpackage Contact
 */
/* mark active page to cabmenu */
$active_page = 'contact';
$nosec = 1;
require("cab.php");

	echo '<H1>'.mst(msg('contact_us')).'</H1>';
	echo mst(msg('contact_us_inf'));
	
	echo '<BR><BR>';
	echo '<font class="lt3"><B>'.$institution_name.'</B></font>';
	echo '<BR>';
	echo '<A HREF="'.$institution_site.'">'.$institution_site.'</a>';
	echo '<BR><BR>';
	echo mst($institution_address);
	echo '<BR>';
	echo $institution_city.' - '.$institution_country;
	echo '<BR>';
	echo msg('phone_number').' '. $institution_phone;
	echo '<BR><BR>';
	
	/* Coordenadas */
	$institution_xpos = -25.4519876;
	$institution_ypos = -49.2508669;
	
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
	
echo '</div>';



echo $hd->foot();
?>
<script>
	
</script>
