<?
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


$sql = "select * from cep_submit_orca ";
$sql .= "where sorca_protocol='".$dd[0]."'and sorca_ativo = 1 ";
$sql .= " order by sorca_valor desc ";
$orlt = db_query($sql);

$orca_cab = false;
$tot1 = 0;
$tot2 = 0;
while ($oline = db_read($orlt))
	{
	if ($orca_cab == false)
		{
		$pdf->MultiCell(0,0,' ',1,'L');
		$pdf->Ln($ln);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(0,8,msg('budget'),0,'L');
		$orca_cab = true;
		$pdf->Ln(6);
/////////////////qqq cabe�alho orcamento
		$y = $pdf->GetY();
		$pdf->SetLineWidth(0.3);
		$pdf->Line(10,$y-2,200,$y-2);
		$pdf->Line(10,$y+2,200,$y+2);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(0,0,utf8_decode(msg('budget_desc')),0,'L');
		$pdf->SetX(80);
		$pdf->MultiCell(60,0,utf8_decode(msg('budget_qt')),0,'R');
		$pdf->SetX(120);
		$pdf->MultiCell(60,0,utf8_decode(msg('budget_vlr')),0,'R');
		$pdf->SetX(140);
		$pdf->MultiCell(60,0,utf8_decode(msg('budget_vlrt')),0,'R');
		$pdf->SetX(160);
		//$pdf->MultiCell(60,0,'custeado',0,'R');
		$pdf->ln(5);		
		}
		$vt = $oline['sorca_unid']*$oline['sorca_valor'];
		$cust = '('.$oline['cso_custo'].')';
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,0,utf8_decode($oline['sorca_descricao']),0,'L');
		$pdf->SetX(80);
		$pdf->MultiCell(60,0,number_format($oline['sorca_unid'],0),0,'R');
		$pdf->SetX(120);
		$pdf->MultiCell(60,0,number_format($oline['sorca_valor'],2),0,'R');
		$pdf->SetX(140);
		$pdf->MultiCell(60,0,number_format($vt,2),0,'R');
		$pdf->SetX(160);
		//$pdf->MultiCell(60,0,$cust,0,'R');
		$pdf->ln(5);
		$tot1++;
		$tot2 = $tot2 + $vt;
	}
	if ($tot1 > 0)
		{
//		$pdf->MultiCell(0,0,'',0,'L');
		//$pdf->MultiCell(0,0,'Custeado: (1) Pesquisador, (2) Universidade, (3) Outros ',0,'L');
		$pdf->SetX(80);
		$pdf->MultiCell(60,0,number_format($tot1,0),0,'R');
		$pdf->SetX(100);
		$pdf->MultiCell(60,0,'',0,'R');
		$pdf->SetX(120);
		$pdf->MultiCell(60,0,number_format($tot2,2),0,'R');
		//////////q Linha
		$y = $pdf->GetY();
		$pdf->Line(10,$y-2,200,$y-2);
		$pdf->ln(5);
		$pdf->SetFont('Times','',12);
		}
		$pdf->SetFont('Times','B',12);
		$pdf->SetLineWidth(0.2);
?>