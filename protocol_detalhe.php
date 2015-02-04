<?
/**
 * Protocol
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v.0.13.46
 * @package Proethos
 * @subpackage Protocol
 */
$breadcrumbs = array();
array_push($breadcrumbs, array('main.php', 'principal'));
array_push($breadcrumbs, array('', 'project'));

require ("cab.php");

require ($include . '_class_form.php');
$form = new form;
require ("form_css.php");

require ($include . "_class_email.php");
require ($include . "sisdoc_data.php");

require ($include . "sisdoc_debug.php");
//require($include."sisdoc_autor.php");

require ('_class/_class_oms.php');
require ('_class/_class_position.php');
require ('_class/_class_ic.php');
$ic = new ic;
require ('_class/_class_cep_email.php');
$comu = new comunication;
require ("_class/_class_cep.php");
$cep = new cep;

require ('_class/_class_cep_comment.php');

require ('_ged_config.php');
$comme = new cep_comment;

/* Project Identifier */
if (strlen($dd[0]) > 0) {
	if (!(checkpost($dd[0]) == $dd[90])) {
		echo 'erro de post';
		exit ;
	}
	$_SESSION['proto_cep'] = $dd[0];
	redirecina(page());
} else {
	$dd[0] = $_SESSION['proto_cep'];
	if (round($dd[0]) <= 0) { redirecina('main.php');
	}
}
$cep -> le($dd[0]);

$status = $cep -> line['cep_status'];
//$pcor = $cep->cep_cores();
//$scor = $cep->status_cor($status);

/* Pareceres temporarios */
require ('_class/_class_cep_parecer_avaliation.php');
$parav = new parecer_avaliation;
$parav -> protocolo = $cep -> protocolo;
$comu -> protocolo = $cep -> codigo;
$st = 'Detalhe do Protocolo';
$sh = '';
$sx = 'Projeto';

echo '<BR><BR>';

/* Paginacao Bread Crumb no TOP */
$pos = new position;
echo $pos -> show($status);

/* Dados do projeto */
{
	echo '<BR><BR>';
	echo '<div class="border1 pad5">';
	$protocolo = $cep -> protocolo;
	$comme -> codigo = $cep -> codigo;

	echo '<div id="the_files">';
	echo '<table width="100%" border=0  class="lt1">';
	echo '<TR><TD>';
	echo $cep -> dados();
	echo '</table>';
	echo '</div>';
	echo '</div>';
	
	/* Bloqueio Etico */
	$bloqueio = $cep -> bloqueio_etico();

	if ($bloqueio) {
		echo '<table width="100%" class="lt1"><TR><TD align="left">';
		echo msg('conflict_of_interest');
		echo '</table>';
	} else {

		/* Files List */
		echo '<BR>';
		echo '<table width="100%" border=0 class="table_normal" >';
		echo '<TR class="hd"><TD>' . msg('files');
		echo '<TR><TD>';
		$ged -> protocol = $cep -> protocolo;
		echo $ged -> filelist();
		//echo $LANG;
		/* Enable UPload File to the Perfis */
		$fechado = 0;
		switch ($cep->status) {
			case 'P' :
				$fechado = 1;
				break;
		}
		if (($perfil -> valid('#SCR#MAS#COO#ADM')) and ($fechado == 0)) {
			echo $ged -> upload_botton_with_type($protocolo);
		}
		echo '</table>';

		/* Dictamen */
		if ($cep -> status == 'D') {
			require ("_class/_class_dictamen.php");
			$dict = new dictamen;
			$dict -> protocol = $cep -> protocolo;
			echo $dict -> mostra_pareceres_emitidos();
		}
		echo '<BR>';

		if (($perfil -> valid('#ADM')) or ($perfil -> valid('#MAS')) or ($perfil -> valid('#SCR'))) {
			/* Comunication with investigator */
			$email1 = trim($cep -> line['us_email']);
			$email2 = trim($cep -> line['us_email_alt']);
			$postnew = $comu -> post_new_message($email1, $email2);
			echo '<table width="100%" border=0 class="table_normal" >';
			echo '<TR class="hd"><TD>' . msg('messages_with_investigator');
			echo '</table>';

			echo '<div id="mail">';
			echo '<fieldset><legend>' . msg('messages_with_investigator') . '</legend>';
			echo '<table width="100%" cellpadding=0 cellspacing=8 border=0 class="lt1">';
			echo '<TR valign="top"><TD rowspan=6 width=25>';
			echo '<img src="images/icone_email.png" height="50">';
			echo '<TD>';
			echo '<div id="bhc" style="cursor: pointer;">' . $comu -> show_resume() . '</div>';
			echo '<div id="the_email_show" style="display:none;">';
			echo '<table width="100%" bgcolor="#F0F0F0">';
			echo '<TR valign="top"><TD>';
			echo '<font class="lt2">' . msg('comunication') . '</font>';
			echo '<TD><img src="images/icone_close.png" id="bhd" width="25"  style="cursor: pointer;">';
			echo '<TR><TD>';
			echo $comu -> display();
			echo '</table>';
			echo '</div><BR>';
			echo $postnew;
			echo '</table>';
			echo '</fieldset>';
			echo '</div>';
			echo '<BR>';
		}

		/* avaliable only status is up "C" */
		if (($perfil -> valid('#ADM')) or ($perfil -> valid('#MAS')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#MEM'))) {
			if (($status != '@') and ($status != 'A') and ($status != 'B') and ($status != 'H')) {
				/** Avaliations **/
				if (($perfil -> valid('#ADM')) or ($perfil -> valid('#MAS')) or ($perfil -> valid('#SCR'))) {
					$editar = 1;
				} else { $editar = 0;
				}
				echo '<div id="the_dictame">';
				echo '<table width="100%">';
				echo '<TR><TD width=50 >';
				echo '<Table class="lt1" border=1 width=50 cellpadding=0 cellspacing=0><TR><TD align="center">';
				echo $parav -> set_avaliables($cep -> id_cep, $cep -> cep_dictamen, $editar);
				echo '</table>';
				echo '<TD>';
				echo '<center><font class="lt4">' . msg("dictame") . '</font></center>';
				echo $parav -> resume();
				echo '</table>';
				echo '</div>';
			}
		}

		/** My Dictame **/
		$sm = $parav -> my_dictamen();
		if (strlen($sm) > 0) {
			echo '<BR>';
			echo '<table width="100%" cellspacing=0 cellpading=0 border=0">
					<TR><TD>';
			echo '<div id="the_dictame">';
			echo '<center><font class="lt4">' . msg("my_dictame") . '</font></center>';
			echo $sm;
			echo '</div>';
			echo '</table>';
			echo '<BR>';
		}

		if (($perfil -> valid('#ADM')) or ($perfil -> valid('#MAS')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#MEM'))) {
			/*
			 * Actions to project
			 */

			$bt = $cep -> action_options($cep -> status);

			if (count($bt) > 0) {

				echo '<table width="100%" border=0 class="table_normal" >';
				echo '<TR class="hd"><TD>' . msg('actions');
				echo '</table>';
				echo '<table width="100%" border=0 class="table_normal" >';
				echo '<TR><TD>';
				echo '<div id="action">';
				//echo $cep->cep_historic_append('001',msg('history_001'));
				echo '<BR>';

				/* executa acao se existir */
				if (strlen($dd[3]) > 0) { $ok = $cep -> action($dd[3], $cep);
				}

				echo $cep -> action_display($bt);
				echo '</div>';
				echo '<BR>';
				echo '</table>';
			}

			/* Historic */

			echo '<table width="100%" border=0 class="table_normal" >';
			echo '<TR class="hd"><TD>' . msg('historic');
			echo '</table>';

			/* Mostra Historico */
			echo '<div id="the_history">';
			echo '<div id="bha" style="text-align: left;">' . msg('show_historic') . '</div>';
			echo '<div id="the_history_show" style="display:none;">';
			echo '<table width="100%" bgcolor="#F0F0F0">';
			echo '<TR valign="top"><TD>';
			echo '<font class="lt3">' . msg('historic') . '</font>';
			echo $cep -> cep_historic();
			echo '<TD width="25"><img src="images/icone_close.png" id="bhe" width="25"  style="cursor: pointer;">';
			echo '</table>';
			echo '</div>';
			echo '</div>';
			echo '</fieldset>';

			echo '<script>' . chr(13);

			echo ' function clicar(vlr)' . chr(13);
			echo ' {
			 if (forma.dd2.checked)
			 	{
					forma.dd3.value = vlr;
					forma.submit();
			 	} else {
			 		alert("' . msg('erro_checked') . '");
			 	}
			}' . chr(13);
			echo '</script>' . chr(13);
			echo '<BR><BR>';
		}

		/* Comments */

		echo '<table width="100%" border=0 class="table_normal" >';
		echo '<TR class="hd"><TD>' . msg('comments');
		echo '</table>';

		echo '<div id="comments" >';

		echo $comme -> comment_display();
		//require("_protocolo_acoes.php");
		//		require("_historico.php");
		echo '</div>';
	}
}
echo '</div>';
echo $hd -> foot();
?>
<script>
	$("#bha").click(function() {
		$("#the_history_show").fadeIn("slow");
		$("#bha").fadeOut("slow");
	});
	$("#bhe").click(function() {
		$("#the_history_show").fadeOut("slow");
		$("#bha").fadeIn("slow");
	});
	$("#bhc").click(function() {
		$("#the_email_show").fadeIn("slow");
		$("#bhc").fadeOut("fast");
	});
	$("#bhd").click(function() {
		$("#the_email_show").fadeOut("slow");
		$("#bhc").fadeIn("slow");
	});

</script>
