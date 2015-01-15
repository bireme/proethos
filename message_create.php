<?php
 /**
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Menssages
 */
 
require('cab.php');

$ln = new message;

if (is_dir('messages'))
	{ }
else 
	{ mkdir('messages'); }
echo $ln->language_page_create();
echo '<h2>';
echo msg('message_create_with_success');
echo '</h2>';
echo '</DIV>';
echo $hd->foot();
?>

