<?php
$pgi = 1;
$pgf = 6;
$sql = "SELECT * FROM cep_submit_manuscrito_field
	left join (select * from cep_submit_documento_valor where (spc_projeto = '".$protocolo."' and spc_ativo = 1)) as tabela on spc_codigo = sub_codigo 
	where (sub_pag >= $pgi and sub_pag < $pgf) and sub_ativo = 1
	order by sub_pag, sub_pos, sub_ordem ";
	
$amendment_type = $proj->amendment_type;
if (round($amendment_type) > 0)
	{
		$sql = "SELECT * FROM cep_submit_manuscrito_field
			left join (select * from cep_submit_documento_valor where (spc_projeto = '".$protocolo."' and spc_ativo = 1)) as tabela on spc_codigo = sub_codigo 
			where ((sub_pag = 1) or (sub_pag = ".(2+10*round($amendment_type))." ))
			and sub_ativo = 1 
			order by sub_pag, sub_pos, sub_ordem ";
	}
$rlt = db_query($sql);

$xok = 1;
echo '<table width="100%" cellpadding=3 cellspacing=0 border=1 class="lt1">';
echo '<TR><TH>'.msg('fieldset').'<TH align="center">'.msg('check');
while ($line = db_read($rlt))
	{
		$obrig = round($line['sub_obrigatorio']);
		$cont = trim($line['spc_content']);
		$ativo = trim($line['spc_ativo']);
		$ref = trim($line['sub_id']);
		
		if (($clinic==0) and ($ref=='CLINIC')) { $cont = 'ok'; }
		
		if (($obrig == 1) and (($ativo==1) or (strlen($ativo) == 0)))
			{
			$link = '<A HREF="submit.php?dd91='.$line['sub_pag'].'#'.$line['sub_codigo'].'">';
			echo '<TR>';
			echo '<TD>';
			echo msg($line['sub_descricao']);
			
			echo '<TD align="center">';
			if (strlen($cont) > 0)
				{
					echo '<font color="green">OK</font>';
				} else {
					echo $link;
					echo '<font color="red">ERROR</font>';
					echo '</A>';
					$xok = 0;
				}
			}
			
			
	}
echo '</table>';
?>