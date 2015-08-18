<?
$sql = "select * from cep_submit_crono ";
$sql .= "where scrono_protocol='".$dd[0]."' ";
$sql .= " order by scrono_date_start ";
$orlt = db_query($sql);

$crono_cab = false;
$tot1 = 0;
$tot2 = 0;


$crono = array();

$dini = 99999999;
$dfim = 0;
while ($oline = db_read($orlt))
	{
	$txt = utf8_decode(trim($oline['scrono_descricao']));
	array_push($crono,array($txt,$oline['scrono_date_start'],$oline['scrono_date_end'],'',''));
	$dda = round("0".$oline['cso_dt_ini']);
	if ($dda < $dini) { $dini = $dda; }
	$dda = round("0".$oline['cso_dt_fim']);
	if ($dda > $dfim) { $dfim = $dda; }	
	}
	
$meses = calcmeses($dini,$dfim);	
if ($meses > 0)
{
$wt = intval(80 / $meses);
$wi = 120;
for ($kr=0;$kr < count($crono);$kr++)
{
////////// nomear datas
		$mm1 = strzero($crono[$kr][1],6);
		$mm2 = strzero($crono[$kr][2],6);
		$mn = nomemes_short(intval(substr($mm1,0,2))).'/'.substr($mm1,2,4);
		$crono[$kr][3] = $mn;
		$mn = nomemes_short(intval(substr($mm2,0,2))).'/'.substr($mm2,2,4);
		$crono[$kr][4] = $mn;

	if ($crono_cab == false)
		{
		$crono_cab = true;
		$pdf->MultiCell(0,0,' ',1,'L');
		$pdf->Ln($ln);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(0,8,msg('crono'),0,'L');
		$orca_cab = true;
		$pdf->Ln(6);
/////////////////qqq cabecalho orcamento
		$y = $pdf->GetY();
		$pdf->SetLineWidth(0.3);
		$pdf->Line(10,$y-2,200,$y-2);
		$pdf->Line(10,$y+2,200,$y+2);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(0,0,utf8_decode(msg('crono_desc')),0,'L');
		$pdf->SetX(100);
		$pdf->MultiCell(60,0,utf8_decode(msg('crono_dtini')),0,'R');
		$pdf->SetX(140);
		$pdf->MultiCell(60,0,utf8_decode(msg('crono_dtfim')),0,'R');
		$pdf->ln(5);		
		}
		$m1a = calcmeses($dini,$mm1)-1;		
		$m1 = $wt * $m1a;

		$mi = 0;
		
		$m2a = calcmeses($dini,$mm2);			
		$m2 = $wt * $m2a;
// .'('.$m1a.'x'.$m2a.'='.$crono[$kr][2].')'
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,0,trim($crono[$kr][0]),0,'L');
		$pdf->SetX(135);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(60,0,substr($mm1,4,2).'/'.substr($mm1,0,4),'R');
		$pdf->SetX(165);
		$pdf->MultiCell(60,0,substr($mm2,4,2).'/'.substr($mm2,0,4),'R');
		
		/////////////////////////////// grafico
		$y = $pdf->GetY();
		$pdf->SetLineWidth(2);
		$pdf->Line($wi+$m1,$y,$wi+$m2,$y);
		
		$pdf->ln(5);
		$tot1++;
}	
	if ($tot1 > 0)
		{
		/*
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(0,0,'',0,'L');
		$pdf->SetX(10);
		$pdf->MultiCell(140,0,msg('Total_of_the').' '.number_format($tot1,0).' '.msg('in_taks').' '.$meses.msg('months'),0,'L');
		//////////q Linha
	
		$pdf->ln(5);
		$pdf->SetFont('Times','',12);
		 */
		}
		$pdf->SetLineWidth(0.2);
		
		/*
		$txt1 = msg('crono_inf_pdf');
		$pdf->SetFont('Arial','B',8);
		$pdf->MultiCell(0,4,$txt1,0,'L');
		$pdf->ln(5);
		$pdf->SetFont('Times','',12);
		 */
		
}
?>
