<?
$dsql = "select * from submit_manuscrito_field where sub_projeto_tipo ='".$prj_tp."'";
$dsql .= " and sub_id = 'DECLA'";
$dsql .= " and sub_ativo = 1 ";
$dsql .= " order by sub_ordem ";

$drlt = db_query($dsql);
while ($dline = db_read($drlt))
	{
	$caption = trim($dline['sub_pdf_title']);
	$information = trim($dline['sub_caption']);
	$mostrar = $dline['sub_pdf_mostra'];
	$content = $dline['spc_content'];
	$ft_size = $dline['sub_pdf_font_size'];
	$ft_field = trim($dline['sub_field']);
	$ft_id = trim($dline['sub_id']);


	if ($mostrar == 1)
		{	
		if (strlen($information) > 0)
			{
			$information .= chr(10).chr(13).chr(10).chr(13).'--------------------------------'.chr(13).chr(10).' assinatura do pesquisador';
			}
		$pdf->MultiCell(0,0,' ',1,$align);
		$pdf->Ln($ln);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(0,8,$caption,0,$align);
		$pdf->Ln($ln);
		$pdf->SetFont('Times','',$ft_size);
		$pdf->MultiCell(0,$space,$information,1,'J');
		$pdf->Ln($ln);
		$pdf->MultiCell(0,8,' ',0,$align);
		$pdf->Ln($ln);	
		}
	}
?>
