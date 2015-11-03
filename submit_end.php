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
require("cab.php");
require("_class/_class_cep_submit.php");
require("_class/_class_team.php");
require($include.'sisdoc_data.php');

require($include.'sisdoc_email.php');

require('_class/_class_ic.php');
$ic = new ic;

$proj = new submit;
$proj->doc_autor_principal = $ss->user_codigo;

require("_class/_class_ged.php");
require("_class/_class_cep.php");
$cep = new cep;

/****/
if (strlen($dd[91]) > 0)
	{
		$_SESSION['proj_page'] = $dd[91];
		redirecina('submit.php?time'.date("dmYhis"));				
	}
	
	$pag_id = round($_SESSION['proj_id']);
	$pag_page = round($_SESSION['proj_page']);

//if ($pag_id == 0) { $pag_page = 1; }
//if ($pag_page == 0) { $pag_page = 1; }
$pag_id = $_SESSION['proj_id'];
$dd[0] = $pag_id;
$protocolo = strzero($dd[0],7);

echo '<H2>'.msg('submission_end_title').'</h2>';
echo '<BR><BR>';

	/* Checa diretorio de submissão do pdf */
	$ged = new ged;
	$ged->dir('document');
	$ged->dir('document/'.date("Y"));
	$ged->dir('document/'.date("Y").'/'.date("m"));	
	
$proj->le($dd[0]);
/* Step 1 */
$ok = $cep->cadastra_protocolo($protocolo,'[]'.$proj->doc_1_titulo,$autor);
if ($ok == 1)
	{
	/* Step 2 */
	$protocolo_cep = $cep->recupera_protocolo_submissao($protocolo,'1');
	$cep->protocolo = $protocolo_cep;
	$cep->protocolo_submission = $protocolo;
	$cep->versao = 1;

	/* Step 3 */
	$cep->limpa_projetos_anteriores();

	/* Step 4 */
	$cep->create_pdf_submit_file();	
	
	/* Step 5 */
	$cep->transfere_autores();
	
	/* Step 6 */
	$cep->envia_arquivos_submissao_apreciacao();
	
	/* Step 7 */
	$cep->change_status_files_submited();
	
	/* Step 8 */
	$cep->cep_historic_append('SUB',msg('submitted_by_the_author'));
	
	/* Step 9 */
	$proj->protocolo_altera_status($protocolo,'@','A');
	
	/* Step 10 */
	$cep->confirm_notify_by_email();
	$cep->confirm_submission_by_email();
	
	echo '<div style="text-align: justify; width: 80%">';
	echo msg('submission_end_text');
	echo '</div>';
	}	
echo '</div>';
echo '<font class="lt0">'.msg('protocolo').' '.$protocolo.'</font>';
echo $hd->foot();
?>