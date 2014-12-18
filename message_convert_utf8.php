<?php
 /**
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
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
echo $ln->convert_to_utf8();
echo '<h2>';
echo "Finished - Terminando - Cerrado!";
echo '</h2>';
echo '</DIV>';
echo $hd->foot();
?>

