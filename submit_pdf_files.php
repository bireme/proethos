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


		$pdf->MultiCell(0,0,' ',1,'L');
		$pdf->Ln($ln);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(0,8,utf8_decode(msg('file_list')),0,'L');
		$orca_cab = true;
		
		require_once('_ged_config.php');
		$ged->protocolo = $dd[0];
			
				$sql = "select * from ".$ged->tabela;
				$sql .= " left join ".$ged->tabela."_tipo on doc_tipo = doct_codigo ";
				$sql .= " where doc_dd0 = '".$ged->protocol."' and doc_ativo=1 ";
				$xrlt = db_query($sql);
				$tot = 0;
				
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(6,5,utf8_decode(msg('iten')),1,0,'C');
				$pdf->Cell(40,5,utf8_decode(msg('type')),1,0,'C');
				$pdf->Cell(88,5,utf8_decode(msg('file_filename')),1,0,'L');
				$pdf->Cell(18,5,utf8_decode(msg('file_size')),1,0,'L');
				$pdf->Cell(38,5,utf8_decode(msg('file_data')),1,0,'L');
				
				$id++;
				
				$pdf->SetFont('Arial','',9);
				
				while ($xline = db_read($xrlt))
					{
						$capt = trim($xline['doct_nome']);
						if (substr($capt,0,1)=='#') { $capt = msg(substr($capt,1,strlen($capt))); }
						//$link = 'ged_download.php?dd0='.$xline('id_doc').'&dd90='.checkpost($xline['id_doc'].$secu);
						$pdf->Ln();
						$pdf->Cell(6,5,$id,1,0,'C');
						$pdf->Cell(40,5,$capt,1,0,'L');
						$pdf->Cell(88,5,$xline['doc_filename'],1,0,'L');
						$pdf->Cell(18,5,$ged->size_mask($xline['doc_size']),1,0,'L');
						$pdf->Cell(38,5,stodbr($xline['doc_data']).' '.$xline['doc_hora'],1,0,'L');
						$tot++;
					}
			$pdf->Ln(6);
			$pdf->Ln(6);
?>