<?php
require("cab.php");
require("_class/_class_cep_submit.php");
require("_class/_class_team.php");
require($include.'sisdoc_data.php');

require($include.'_class_email.php');

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
echo msg('protocolo').' '.$protocolo;
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
	$cep->confirm_submission_by_email();
	
	echo '<div style="text-align: justify; width: 80%">';
	echo msg('submission_end_text');
	echo '</div>';
	}	
?>
echo '</div>';
<script>
	
</script>
<?
echo $hd->foot();
?>



