<?
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
  * FAQ page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
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