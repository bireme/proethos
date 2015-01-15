<?php
 /**
  * Protocol
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */
 
/* mark active page to cabmenu */
$active_page = 'research';
 
require("cab.php");

require("_class/_class_cep.php");
$cep = new cep;

require("_class/_class_cep_submit.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_resume.php");
$rs = new resume;

$proj = new submit;
/* Ajusta protocolos perdidos */
$sql = "update ".$proj->tabela." set doc_status = '@' where doc_status = '' ";
$rlt = db_query($sql);

/* Buscar projetos do pesquisador */
$proj->doc_autor_principal = $ss->user_codigo;
$pta = $proj->protocolos_todos($dd[1]);  

/* Search project form */
echo '<h1>'.msg('project_investigador').'</h1>';
echo $cep->form_search();

/* search form */
echo '<BR><BR>';
echo $rs->resume();

/* project in submission */
echo '<BR>';
echo '<h1>'.msg('caption_status_'.$dd[1]).'</h1>';

echo '<fieldset>';

echo '<table width="100%" class="lt1" border=0><TR><TD>';

echo '<font class="lt1">'.msg('caption_status_'.$dd[1].'_inf').'</font>';
echo '</table>';

echo '<table width="100%" border=0 >';

/* Protocol in submission */
echo $proj->protocolos_mostrar($pta);
echo '</table>';

/* Approved Research */
$cep->autor_principal = $ss->user_codigo;
echo $cep->protocol_in_investigation();

echo '</fieldset>';

echo '</div>';
echo $hd->foot();	
?>