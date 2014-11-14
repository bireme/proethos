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
require('db.php');
require('_class/_class_message.php');
$ln = new message;

	/* Mensagens */
	$link_msg = 'messages/msg_message_ed_pop.php';
	if (file_exists($link_msg)) { require($link_msg); }
?>
<head>
	<title>::CIP-Admin::</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="http://cip.pucpr.br/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../css/main.css" />
</head>
<?
$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require("form_css.php");
require($include.'sisdoc_debug.php');

	$cl = new message;
	$cps = $cl->message_name_all($dd[1],$dd[2]);
	$cpi = $cl->message_name_all($dd[1].'_inf',$dd[2]);
	$tabela = '';
	///********************** SALVAR **/
	if (strlen($acao) > 0)
		{		
		for ($r=0;$r < count($cps);$r++)
			{			
				if (round($cps[$r][0]) > 0)
				{
					$sql = "update ".$cl->tabela." set msg_content='".$dd[$r+10]."' ";
					$sql .= " where id_msg = ".$cps[$r][0];
					$rlt = db_query($sql);
				}
				if (round($cpi[$r][0]) > 0)
				{
					$sql = "update ".$cl->tabela." set msg_content='".$dd[$r+40]."' ";
					$sql .= " where id_msg = ".$cpi[$r][0];
					$rlt = db_query($sql);
				}
			}
		redirecina('message_create.php');
		exit;
		}
	
	$idm = $cl->idioma();
	?>
	<form method="post" action="<?php echo page();?>">
	<input type="hidden" name="dd1" value="<?php echo $dd[1];?>">
	<input type="hidden" name="dd2" value="<?php echo $dd[2];?>">
	<input type="hidden" name="dd3" value="<?php echo $dd[3];?>">
	<input type="hidden" name="dd4" value="<?php echo $dd[4];?>">
	<input type="submit" name="acao" value="<?php echo msg('save');?>">
	<TABLE width="<?php echo $tab_max;?>" align="center" bgcolor="<?php echo $tab_color;?>"><TR><TD><?
	for ($r=0;$r < count($cps);$r++)
	{
		$idi = trim($cps[$r][1]);
		echo '<TR>';
		echo '<TD>'.$idm[$idi];
		echo '<TR>';
		$dd[10+$r] = $cps[$r][2];
		echo sget('dd'.($r+10),'$T60:3',False,False);
		echo '<TR>';
		$dd[40+$r] = $cpi[$r][2];
		echo sget('dd'.($r+40),'$T60:3',False,False);
	}
	$tit = msg("titulo");
	?></TD></TR></TABLE>
	<input type="submit" name="acao" value="<?php echo msg('save');?>">
	</form><?	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('message.php');
		}
?>
<script>
	
</script>
