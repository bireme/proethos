<?php
 /**
  * Sumissão de protocolo de pesquisa
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.22
  * @package Class
  * @subpackage UC0001 - Sumissão de protocolo de pesquisa
 */

 
 /* TIPS */
$CP5 = '<img src="img/icone_information.png" height="20px" tips="A">';
$CP5 = tips($CP5,msg('title_main_inf'),'id1');
$CP7 = tips($CP5,msg('title_public_inf'),'id2');
$CP8 = tips($CP5,msg('title_acronym_inf'),'id3');

$cp = array();
$tabela = $proj->tabela;
array_push($cp,array('$H8','id_doc','',False,False));
array_push($cp,array('$HV','doc_status','@',True,True));
//array_push($cp,array('$R 1:#yes&0:#no','doc_human',msg('q_human'),False,True));
array_push($cp,array('$HV','doc_human',1,False,True));


if ($commite_type != 'CEUA')
	{
		/* Use only Human Committee */
		array_push($cp,array('$A','',msg('q_clinic_study'),False,False));
		array_push($cp,array('$R 1:#yes&0:#no','doc_clinic',msg('q_clinic_study'),True,True));
	} else {
		/* Use only Aminals Committee */
		array_push($cp,array('$HV','doc_clinic',0,True,True));
	}

array_push($cp,array('$A','',msg('title'),False,False));
array_push($cp,array('$M2','',msg('title_main').$CP5,False,False));
array_push($cp,array('$T60:4','doc_1_titulo','',True,True,'','class="form_textarea_full"'));

array_push($cp,array('$M2','',msg('title_public').$CP7,False,False));
array_push($cp,array('$T70:4','doc_1_titulo_public','',True,True,'','class="form_textarea_full"'));

//array_push($cp,array('$M','',msg('main_research'),False,False));
//array_push($cp,array('$Q us_nome:us_codigo:select * from usuario where us_codigo = \''.$ss->user_codigo.'\'','doc_research_main','&nbsp;',True,True,'','class="form_textarea_full"'));
array_push($cp,array('$H8','',msg('main_research'),False,False));
array_push($cp,array('$HV','doc_research_main',trim($ss->user_codigo),True,True,'',''));

array_push($cp,array('$M','','<BR><BR>',False,False));
array_push($cp,array('$U8','doc_data','',True,True));
array_push($cp,array('$HV','doc_hora',date("H:i"),True,True));
array_push($cp,array('$U8','doc_dt_atualizado','',True,True));
array_push($cp,array('$H8','doc_protocolo','',False,True));

/* Anacronico */
array_push($cp,array('$S50','doc_acronym',msg('title_acronym').$CP8,False,True));

array_push($cp,array('$HV','doc_autor_principal',trim($ss->user_codigo),False,True));
array_push($cp,array('$B8','',msg('#save_next'),False,True));

array_push($cp,array('$HV','doc_tipo','PROJE',False,True));
array_push($cp,array('$H8','doc_type','',False,True));
array_push($cp,array('$H8','doc_xml','',False,True));
array_push($cp,array('$H8','doc_caae','',False,True));




$tela = $form->editar($cp,$tabela);

if ($form->saved > 0)
	{
		if (round($protocolo)==0)
			{
				$proj->updatex();
				$sql = "select * from ".$proj->tabela." where doc_autor_principal = '".trim($ss->user_codigo)."' 
					and doc_status = '@' order by id_doc desc ";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
						$_SESSION['proj_id'] = $line['id_doc'];
						$_SESSION['proj_page'] = 1;
					} else {
						echo msg('ERRO-SAVE_NEW_PROJET');
						exit;
					}				
			}
		$_SESSION['proj_page'] = 2;
		redirecina('submit.php?time'.date("dmYhis"));
	} else {
		echo $tela;
	}
	
$dd5=troca(msg('title_main_inf'),chr(13),'');
$dd5=troca($dd5,chr(10),'');

$dd7=troca(msg('title_public_inf'),chr(13),'');
$dd7=troca($dd7,chr(10),'');
?>


