<?
$prj_nr = $protocolo;
if (strlen($prj_nr) == 0)
	{
	$sql = "select * from cep_submit_documento where doc_id = '".$prj_nr."' ";
	$rlt = db_query($sql);
	if (!($line = db_read($rlt)))
		{ $novo = true; } 
	}
	
	/* SAVE */
	$sql = "delete from cep_submit_documento_valor ";
	$sql .= " where spc_pagina = '".strzero($pag,3)."' ";
	$sql .= " and spc_projeto = '".$protocolo."' ";
	$sql .= " and spc_autor = '".$proj->doc_autor_principal."' ";
	$rlt = db_query($sql);
	
	$xsql = '';
	for ($k=0;$k < count($cops);$k++)
		{
		$xsql = "insert into cep_submit_documento_valor ";
		$xsql .= "(spc_codigo,spc_projeto,spc_content,";
		$xsql .= "spc_pagina,spc_autor,spc_ativo) ";
		$xsql .= " values ";
		$xsql .= "('".$cops[$k][0]."','".$protocolo."','".$cops[$k][1]."',";
		$xsql .= "'".strzero($pag,3)."','".$proj->doc_autor_principal."','1') ";
		$rlt = db_query($xsql);
		}
	$sql = "update cep_submit_documento set doc_status = '@', doc_dt_atualizado = ".date("Ymd")."
				where doc_protocolo = '$protocolo' ";
	$rlt = db_query($sql);
	$sql .= '';
?>