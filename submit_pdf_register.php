<?php
		
				$sql = "select count(*) as total from cep_submit_register_unit ";
				$sql .= " left join register_unit on ru_codigo = csru_unit ";
				$sql .= " where csru_protocolo = ".$protocol." and csru_ativo=1 ";
				$xrlt = db_query($sql);		
				$xline = db_read($xrlt);
				if ($xline['total'] > 0)
				{		
					$pdf->MultiCell(0,0,' ',1,'L');
					$pdf->Ln($ln);
					$pdf->SetFont('Times','B',12);
					$pdf->MultiCell(0,8,msg('primary_register'),0,'L');
					$orca_cab = true;

					$sql = "select * from cep_submit_register_unit ";
					$sql .= " left join register_unit on ru_codigo = csru_unit ";
					$sql .= " where csru_protocolo = ".$protocol." and csru_ativo=1 ";
					$xrlt = db_query($sql);
					$tot = 0;
						
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(114,5,msg('register_unit'),1,0,'L');
					$pdf->Cell(38,5,msg('register'),1,0,'L');
					$pdf->Cell(38,5,msg('date'),1,0,'L');
					
					$pdf->SetFont('Arial','',9);
					
					while ($xline = db_read($xrlt))
						{
							$capt = trim($xline['doct_nome']);
							if (substr($capt,0,1)=='#') { $capt = msg(substr($capt,1,strlen($capt))); }
							//$link = 'ged_download.php?dd0='.$xline('id_doc').'&dd90='.checkpost($xline['id_doc'].$secu);
							$data = $xline['csru_data'];
							if (strlen($data) > 1)
								{
									$data = $data;
								} else {
									$data = msg('not_informed');
								}
							$pdf->Ln();
							$pdf->Cell(114,5,$xline['ru_name'],1,0,'L');
							$pdf->Cell(38,5,$xline['csru_number'],1,0,'L');
							$pdf->Cell(38,5,$data,1,0,'L');
							$tot++;
						}
				$pdf->Ln(6);
				$pdf->Ln(6);
				}
	?>