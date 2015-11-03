<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt

?>

<?php
		
				$sql = "select count(*) as total from cep_submit_country ";
				$sql .= " where ctr_protocol = ".$protocol." and ctr_ativo=1 ";
				$xrlt = db_query($sql);		
				$xline = db_read($xrlt);
			
				if ($xline['total'] > 0)
				{		
					$pdf->MultiCell(0,0,' ',1,'L');
					$pdf->Ln($ln);
					$pdf->SetFont('Times','B',12);
					$pdf->MultiCell(0,8,msg('country_enrollment'),0,'L');
					$orca_cab = true;

				$sql = "select * from cep_submit_country 
					inner join ajax_pais on ctr_country = pais_codigo
					where ctr_protocol = '".$protocol."' and ctr_ativo = 1
					order by pais_nome";
					$xrlt = db_query($sql);
					$tot = 0;
						
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(100,5,utf8_decode(msg('country_desc')),1,0,'L');
					$pdf->Cell(85,5,utf8_decode(msg('country_sample_size')),1,0,'C');
					
					$pdf->SetFont('Arial','',9);
					
					while ($xline = db_read($xrlt))
						{
							$pdf->Ln();
							$pdf->Cell(100,5,msg($xline['pais_nome']),1,0,'L');
							$pdf->Cell(85,5,$xline['ctr_target'],1,0,'C');
							$tot++;
						}
				$pdf->Ln(6);
				$pdf->Ln(6);
				}
	?>