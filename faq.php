<?
  /**
  * FAQ page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
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

/* Sess�o e pagina da Submissao */

echo '<H1>'.msg('faq_title').'</h1>';
echo '<fieldset><legend>'.msg('faq').'</legend>';
echo '<Table width="'.$tab_max.'" class="lt1" align="center" >';
echo '<TR><TD>';
echo $faq->faq();
echo '</table>';
echo '</fieldset>';
echo '</div>';

echo $hd->foot();
?>


