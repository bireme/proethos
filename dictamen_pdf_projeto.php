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


global $institution_name,$LANG,$messa;
$line = $dic->line;

require('fphp-170/fpdf.php');
$versao_pdf = '0.0.38a';
$ln=4;
$caae = trim($line['cep_caae']);
$nrp = strzero($dic->line['id_pr'],5).'/'.substr($dic->line['pr_data_emissao'],0,4);

$pdf=new FPDF();
$pdf->AliasNbPages();
$ln = 0;
$pdf->AddPage();
/* Logo Novo */
$img = 'document/proegthos_logo_1.jpg';
if (!(file_exists($img)))
	{
		$img = 'img/logo_dictamen.jpg';
	}
$pdf->Image($img,20,10);

$pdf->SetFont('Times','B',16);
$pdf->MultiCell(0,10,$institution_name,0,'R');

/* Research Project Evaluation Form */
$pdf->SetFont('Times','',14);
$pdf->MultiCell(0,1,utf8_decode(msg('dictamen_title')),0,'R');
$pdf->MultiCell(0,22,utf8_decode(msg('caae').' '.$caae),0,'R');
$pdf->SetFont('Times','',13);
$pdf->Ln($ln);	
////////////////////////////// Variaveis iniciais
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(0,6,utf8_decode(msg('dictamen_number')).' '.$nrp,1,'C');

$pdf->Ln(6);

$pdf->SetFont('Arial','B',16);
$decision = msg('pm_'.trim($line['pr_situacao']));
$pdf->MultiCell(0,6,utf8_decode(msg('decision_oficial')).': '.$decision,0,'C');


$pdf->Ln(6);

/* titulo do projeto */
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,6,utf8_decode(msg('dictamen_project_title')),T,T,'R');
$pdf->SetFont('Arial','B',11);
$titulo = trim($line['cep_titulo']);
$titulo = troca($titulo,chr(13),' ');
$titulo = troca($titulo,chr(10),' ');
$titulo = troca($titulo,'  ',' ');
$pdf->MultiCell(0,5,utf8_decode($titulo),LT,'L');

/* Inverstigador */
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,6,utf8_decode(msg('dictamen_investigador')),T,T,'R');
$pdf->SetFont('Arial','B',11);
$nome = trim($line['us_nome']).chr(13).chr(10);
$nome .= trim($line['us_instituition']);
$pdf->MultiCell(0,6,utf8_decode($nome),TL,'L');

/* Pais do Estudo */
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,6,utf8_decode(msg('dictamen_country')),T,T,'R');
$pdf->SetFont('Arial','B',11);
$nome = trim($line['pais_nome']);
$pdf->MultiCell(0,6,utf8_decode($nome),TL,'L');

/* Tipo do Estudo */
$nome = trim($line['cep_study_type']);
if (strlen($nome) > 0)
	{
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(35,6,utf8_decode(msg('study_type')),T,T,'R');
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(0,6,utf8_decode($nome),TL,'L');
	}

/* pr_accompaniment */
$nome = trim($line['pr_situacao']);
if ($nome == 'APR')
	{
	$rela = round($line['pr_accompaniment']);
	/* cria objeto */
	$cep = new cep;
	$nome = $cep->monitoring($rela);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(35,6,utf8_decode(msg('accompaniment')),T,T,'R');
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(0,6,utf8_decode($nome),TL,'L');
	}
	
/* Objetivo do estudo */
$nome = trim($line['cep_goal']);
if (strlen($nome) > 0)
	{
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(35,6,utf8_decode(msg('primary goal')),T,T,'R');
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(0,6,utf8_decode($nome),TL,'L');
	}	

/* Data do parecer */
$nome = $line['pr_data_emissao'];
if ($nome > 19000101)
	{
	$nome = substr($nome,6,2).' / '.msg('month_'.substr($nome,4,2)).' / '.substr($nome,0,4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(35,6,utf8_decode(msg('date_dictamen')),TB,T,'R');
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(0,6,$nome,TLB,'L');
	}
$pdf->Ln(6);


$ar = array('1','2','3','4','5','6','7','8','9');
for ($st=0;$st < count($ar);$st++)
	{
		if ($line['pm_'.$st]==1)
		{
			$cap = msg('dictamen_'.$st);
			$pdf->SetFont('Arial','B',12);
			$pdf->Ln(1);
			//$pdf->Cell(35,6,utf8_decode($cap),T,0,'R');
			$pdf->MultiCell(0,5,utf8_decode($cap),B,'L');
			$pdf->SetFont('Arial','',10);
			$text = 'pr_texto_'.($st+1);
			$pdf->MultiCell(0,5,utf8_decode($line[$text].chr(13).chr(10).chr(13).chr(10)),0,'J');
		}
	}

$field = trim($line['pr_situacao']);
$texto = msg('dictamen_'.$field.'_1');
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,6,chr(13).chr(10).utf8_decode($texto),T,'L');	

$texto = msg('dictamen_'.$field.'_2');
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,6,chr(13).chr(10).utf8_decode($texto),T,'L');	

$declaracoes = False;
$pr_orca = False;
///////////////////////////////// titulo do projeto
			
$pdf->Ln($ln);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(0,8,msg('create_file').' '.date("d/m/Y H:i"),0,'R');	
////////////////////////////// DOCUMENTOS EM IMAGEM FINAL
if (strlen($destino) > 0)
	{
		$pdf->Output($destino);
	} else {
		$pdf->Output();
	}
?>