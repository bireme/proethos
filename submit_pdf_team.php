<?php
		
				$sql = "select count(*) as total from cep_submit_team ";
				$sql .= " where ct_protocol = '".$protocol."'  ";
				$xrlt = db_query($sql);		
				$xline = db_read($xrlt);
			
				if ($xline['total'] > 0)
				{		
					$pdf->MultiCell(0,0,' ',1,'L');
					$pdf->Ln($ln);
					$pdf->SetFont('Times','B',12);
					$pdf->MultiCell(0,8,msg('team'),0,'L');
					$orca_cab = true;

				$sql = "select * from cep_submit_team
						inner join usuario on ct_author = us_codigo
						left join ajax_pais on us_country = pais_codigo
						where ct_protocol = '$protocol'
						order by ct_type
				";		
				
				$xrlt = db_query($sql);
					$tot = 0;
						
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(70,5,utf8_decode(msg('name')),1,0,'L');
					$pdf->Cell(55,5,utf8_decode(msg('email')),1,0,'L');
					$pdf->Cell(45,5,utf8_decode(msg('country')),1,0,'L');
					$pdf->Cell(20,5,utf8_decode(msg('contact')),1,0,'L');
					
					$pdf->SetFont('Arial','',9);
					
					while ($xline = db_read($xrlt))
						{
							$pdf->Ln();
							$pdf->Cell(70,5,$xline['us_nome'],1,0,'L');
							$pdf->Cell(55,5,$xline['us_email'],1,0,'L');
							$pdf->Cell(45,5,$xline['pais_nome'],1,0,'L');
							if ($xline['ct_type']=='C')
								{ $pdf->Cell(20,5,'*',1,0,'C'); }
							else {$pdf->Cell(20,5,' ',1,0,'C'); }
							$tot++;
						}
				$pdf->Ln(6);
				$pdf->Ln(6);
				}
	?>