<?
  /**
  * FAQ page
  * @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos
  * @subpackage FAQ
 */

/* mark active page to cabmenu */
$active_page = 'faq'; 
 
$nosec = 1;
require("cab.php");

require('_class/_class_faq.php');
$faq = new faq;
$faq->faq_seccao = 'CEP';

/* Mensagens do sistema */
global $messa;
$file = '../messages/msg_faq.php';
if (file_exists($file)) { require($file); }

/* Sess�o e p�gina da Submissao */

echo '<H1>'.msg('faq_title').'</h1>';
echo '<Table width="'.$tab_max.'" class="lt1" align="center" >';
echo '<TR><TD>';
echo $faq->faq();
echo '</table>';
echo '</div>';

echo $hd->foot();
?>


