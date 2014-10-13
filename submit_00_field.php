<?php
/**
 * ********************************************
 * */

$ztabela = 'cep_submit_manuscrito_field';
$sql = "select * from ".$ztabela."
		left join cep_submit_documento_valor on spc_codigo = sub_codigo and spc_projeto = '$protocolo' 
		where sub_projeto_tipo = '00001' 
		and sub_pag='$pag' and sub_ativo=1 
		order by sub_pag, sub_pos, sub_ordem ";
$rlt = db_query($sql);

echo '<TABLE align="center" width="'.$tab_max.'">';
echo '<TR><TD colspan=2>'; 
$dx=0;
$ok = 1;
$cops = array();
$js = ''; //* Comandos Java Script */
$botton_submit = 0;
$xcdo = "X";
$se = '';
while ($line = db_read($rlt))
	{
	/* Dados do campos de edicao */
	$name_id = $line['sub_codigo'];
	$s .= '<A NAME="'.$name_id.'"></A>';
	if ($xcod != $name_id)
	{
		$xcod = $name_id;	
	/* Recupera dados gravados se n�o tem a��o */
	if (strlen($acao) == 0) 
		{
			$value = trim($line['spc_content']); 
		} else {
			$value = trim($_POST['dd'.$name_id]);
		}
		$value = troca($value,"'","´");

	
	/* Dados do campos de edicao */
	$CP1 = trim($line['sub_field']);
	$CP2 = msg(trim($line['sub_descricao']));
	$CP2a = $CP2;
	$mmm = (trim(trim($line['sub_descricao']).'_inf'));
	$mmm = msg($mmm);
	/* Se for botão anula mensagem de informação */
	if (substr($CP1,0,2) == '$B') { $mmm = ''; }
	if (strpos($mmm,'_inf') > 0) { $mmm = ''; }
	$CP3 = '';
	
	/* Armazena para gravacao dados ja inseridos */
	if (!(substr($CP1,0,2) == '$B'))
		{ array_push($cops,array($line['sub_codigo'],$value)); }
	else { $botton_submit = 1; }

	/* Se existir coment�rios */
	if (strlen($mmm) > 0)
		{
		$CP3 = '<div id="dv'.$line['id_sub'].'" style="display: none;" class="lt_info">'.$mmm.'</div>';
		$CP3 .= '<span id="dv'.$line['id_sub'].'a"><img src="img/icone_information.png" height="20px"></span>';
		$js .= chr(13).
				'$("#dv'.$line['id_sub'].'a").click( function() {';
		$js .= '$("#dv'.$line['id_sub'].'").fadeIn("slow"); '; 
		$js .= '$("#dv'.$line['id_sub'].'a").fadeOut("fast"); ';
		$js .= '}); '.chr(13);
		}
	$ref = trim($line['sub_id']);
	$class = trim($line['sub_css']);
	
	if (strlen($class)==0) { $class="form_textarea_full"; }
	if (strlen($class) > 0) { $class=' class="'.$class.'" '; }
	
	/* informaivo com HR */
	if ((substr($CP1,0,2) != '$A') and (substr($CP1,0,2) != '$B'))
		{ $CP2 = '<font class="lt2">'.$CP2; } else
		{ $CP2 = '<font class="lt0">'.$CP2; }
	if (strlen($CP3) > 0)
		{
		$CP2 .= '<br><FONT CLASS="lt0"><FONT color="#ff8888">'.$CP3;
		}
		
	/* Outras Informacoes */
	$obriga = trim($line['sub_obrigatorio']);
	$tips = trim($line['sub_informacao']);
	if ((strlen($tips) > 0) and (substr($CP1,0,2) != '$F'))
		{ $CP2 .= '<BR>'.tips('<img src="img/icone_information_mini.png" alt="" border="0">',$tips); }
	if (substr($CP1,0,2) == '$F')
		{ $CP2 = '<B>'.$CP2.'</B><BR><BR>'.mst($tips); }	
	///////////////////////////////////////////////////
	$ed = false;
	if (($ref=='CLINIC'))
		{
		if ($clinic == 1)
			{
				if ($CP1=='$REGISTER_P') {require("register_unit.php"); $edx = true; $ed = true;  }
				if ($CP1=='$REGISTER_S') {require("register_unit_secundary.php"); $edx = true; $ed = true;  }
			} else {
				$ed = True;
			}
		}
	/* Gerar Opcao para PDF */
	//if ($CP1=='$PDF') 
	//	{ require("submit_phase_pdf.php"); $ed = true; }
		
	/* Gerar Opcao para PDF */
	if ($CP1=='$TEAM') 
		{
			/* Cronograma */
			$s .= '<TR><TD colspan=2>';
			$s .= '<fieldset><legend>'.msg('team').'</legend>';
			$s .= '<div id="team">';
			$s .= '</div>';
			$s .= '</fieldset>';
			
			$s .= chr(13).'<script type="text/javascript">';
			$s .= chr(13).'var $tela = $.ajax({ url: "team_ajax.php", type: "POST", ';
			$s .= chr(13).'data: { dd11: "'.$protocolo.'", dd10: "crono" ,dd12: "'.$bud->protocolo.'" }';
			$s .= chr(13).'})';
			$s .= chr(13).'.fail(function() { alert("error"); })';
 			$s .= chr(13).'.success(function(data) { $("#team").html(data); }); ';
			$s .= chr(13).'</script>';
						
			$ed = true; 
		}

	/* Cronograma */
	if ($CP1=='$CRONO') ///////////////// Pagina para autoreso
		{
			/* Cronograma */
			$s .= '<TR><TD colspan=2>';
			$s .= '<fieldset><legend>'.msg('crono').'</legend>';
			$s .= '<div id="crono">';
			$s .= '</div>';
			$s .= $bud->form_crono();
			$s .= '</fieldset>';
			
			$s .= chr(13).'<script type="text/javascript">';
			$s .= chr(13).'var $tela = $.ajax({ url: "submit_ajax.php", type: "POST", ';
			$s .= chr(13).'data: { dd11: "'.$protocolo.'", dd10: "crono" ,dd12: "'.$bud->protocolo.'" }';
			$s .= chr(13).'})';
			$s .= chr(13).'.fail(function() { alert("error"); })';
 			$s .= chr(13).'.success(function(data) { $("#crono").html(data); }); ';
			$s .= chr(13).'</script>';
						
			$ed = true; 
		}
		
	if ($CP1=='$COUNTRY') ///////////////// P�gina para autoreso
		{
			/* Budget */
			$s .= '<TR><TD colspan=2>';
			$s .= '<fieldset><legend>'.msg('countries_recruitment').'</legend>';
			$s .= '<div id="country">';
			$s .= '</div>';
			$s .= $country->form_country();
			$s .= '</fieldset>';
		
			$s .= chr(13).'<script type="text/javascript">';
			$s .= chr(13).'var $tela = $.ajax({ url: "submit_ajax.php", type: "POST", ';
			$s .= chr(13).'data: { dd11: "'.$protocolo.'", dd10: "country" ,dd12: "'.$bud->protocolo.'" }';
			$s .= chr(13).'})';
			$s .= chr(13).'.fail(function() { alert("error"); })';
			$s .= chr(13).'.success(function(data) { $("#country").html(data); });';
			$s .= chr(13).'</script>';		
			$ed = true; 
		}
		
	if ($CP1=='$BUDGET') ///////////////// P�gina para autoreso
		{
			/* Budget */
			$s .= '<TR><TD colspan=2>';
			$s .= '<fieldset><legend>'.msg('budget').'</legend>';
			$s .= '<div id="budget">';
			$s .= '</div>';
			$s .= $bud->form_budget();
			$s .= '</fieldset>';
		
			$s .= chr(13).'<script type="text/javascript">';
			$s .= chr(13).'var $tela = $.ajax({ url: "submit_ajax.php", type: "POST", ';
			$s .= chr(13).'data: { dd11: "'.$protocolo.'", dd10: "budget" ,dd12: "'.$bud->protocolo.'" }';
			$s .= chr(13).'})';
			$s .= chr(13).'.fail(function() { alert("error"); })';
			$s .= chr(13).'.success(function(data) { $("#budget").html(data); });';
			$s .= chr(13).'</script>';		
			$ed = true; 
		}
	if (substr($CP1,0,5)=='$FILE') ///////////////// Or�amento
		{
			$s .= '<TR><TD colspan=2>';
			$s .= '<fieldset><legend>'.msg('file_submission').'</legend>';
			$s .= msg('file_submission_info');
			$s .= '<div>';
			$ged->protocol = $protocolo;
			$s .= $ged->file_list();
			$s .= $ged->upload_botton_with_type($protocolo);
			$s .= '</div>';
			$s .= '</fieldset>';
			$edx = true; }	

	if (substr($CP1,0,5)=='$TERM') ///////////////// Termo	
	{
	/* Termo */
		$s .= '<form action="submit.php" method="post">';
		$s .= '<BR>';
		$s .= '<input type="submit" name="acao" value="'.msg('save_next').'" class="big_botton">';
		$s .= '</form>';
		$ok = 1;
		if (($ok > 0) and (strlen($acao) > 0))
			{
				$_SESSION['proj_page'] = 6;
				redirecina('submit.php?time'.date("dmYhis"));
			}
	}	
	if ($ed == false)
		{
		$s .= '<TR>';
		$s .= gets('dd'.$name_id,$value,$CP1,$CP2,$obriga,1,'',$class);
		}

	
	/** Rtoina de conferencia **/
	if (strlen($acao) > 0) 
		{
		$op1 = round(($obriga == 1) and ($ref=='CLINIC') and ($clinic == 1));
		$op2 = round(($obriga == 1) and ($ref!='CLINIC'));
		
		if (($op1 or $op2) and (strlen($value)==0)) 
			{
				$link = page().'#'.$name_id;
				$link = '<A HREF="'.$link.'">';
				$ok = -1; 
				$se .= '<TR><TD>'.$link.'<font class="lt1">'.msg('the_field').' <B>'.$CP2a.'</B> '.msg('requered').'</A>'; 
			}
		}
	$dx++;
	}
	}
$s .= '<script>'.chr(13).$js.'</script>'.chr(13);
//$s .= '<HR>2<HR>';

if (strlen($se) > 0)
	{
		$sq = '<table width="100%" class="lt2" border=0>';
		$sq .= '<TR valign="top" ><TD rowspan=80 width="50" >';
		$sq .= '<img src="img/icone_alerta.png">';
		$sq .= '<TH>'.msg('submission_problems');
		$sq .= $se;
		$sq .= '</table>';
		
		$s = $sq.$s;
	}
?>