<?php
require('fphp-170/fpdf.php');
$versao_pdf = '0.0.36a';
$ln=4;

require("_class/_class_register_unit.php");
$reg = new register_unit;

//$register = dados_lista
$protocol = $dd[0];
//Instanciation of inherited class
$sql = "select * from cep_submit_documento ";
$sql .= "where doc_protocolo = '".$dd[0]."' ";
$rlt = db_query($sql);
if ($line = db_read($rlt))
	{
	$prj_tp = trim($line['doc_tipo']);
	$titulo = utf8_decode(trim($line['doc_1_titulo']));
	$titp = utf8_decode(trim($line['doc_1_titulo_public']));
	$data_submit = stodbr($line['doc_dt_atualizado']);
	$subt   = '';
	}
require("_ged_config.php");
$ged->protocol = $dd[0];
$sql = "select * from cep_submit_manuscrito_field ";
$sql .= " left join cep_submit_documento_valor on sub_codigo = spc_codigo ";
$sql .= " where spc_projeto = '".$dd[0]."'";
$sql .= " and sub_ativo = 1 ";
$sql .= " order by sub_pag, sub_pos, sub_ordem ";
$rlt = db_query($sql);

/* Extensão da Classe */
class PDF extends FPDF
{
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
/* **/
$pdf=new FPDF();
$pdf->AliasNbPages();
$ln = 0;
$pdf->AddPage();

$pdf->SetFont('Times','B',20);
$pdf->Ln($ln);
$pdf->MultiCell(0,8,$titulo,0,'C');

///////////////////////////////// titulo do projeto
if (substr($prj_tp,0,1) == '0')
	{
		$pdf->Ln(6);
		$pdf->SetFont('Times','',18);
		$pdf->MultiCell(0,14,utf8_decode(msg('amendment_'.$prj_tp)),1,'C');
		$pdf->SetFont('Times','',12);
		$pdf->Ln($ln);
		$pdf->MultiCell(0,8,utf8_decode(msg('original_niec').' '.trim($line['doc_caae'])),1,'R');
			
	} 
$pdf->Ln(6);
$pdf->SetFont('Times','B',10);
$pdf->Ln($ln);
$pdf->MultiCell(0,4,utf8_decode(msg('doc_1_titulo_public')),0,'L');
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,8,$titp,0,'L');
$pdf->Ln($ln);
$pdf->MultiCell(0,8,chr(13).' '.chr(13).' '.chr(13).' '.chr(13),0,'C');
$pdf->Ln($ln);	
////////////////////////////// Variaveis iniciais
$declaracoes = False;
$pr_orca = False;

/////////////////////////////// Corpo do texto
$file_list = 0;
$pdf->SetFont('Times','',12);
while ($line = db_read($rlt))
	{
	$align = trim($line['sub_pdf_align']);
	if (strlen($align)==0) { $align = "J"; }

	$space = trim($line['sub_pdf_space']);	
	if (strlen($space)==0) { $space = "6"; }
	
	
	$caption = utf8_decode(msg(trim($line['sub_pdf_title'])));
	$information = trim($line['sub_descricao']);
	$mostrar = $line['sub_pdf_mostra'];
	$content = utf8_decode(trim($line['spc_content']));
	$ft_size = $line['sub_pdf_font_size'];
	$ft_field = trim($line['sub_field']);
	$ft_id = trim($line['sub_id']);
	$sub_pdf_title = trim($line['sub_pdf_title']);
	
	$ft_size=12;
	$space=6;
	
	if ($ft_id == 'DECLA') { $mostrar = 0; }
		
	IF ($ft_field == '$REGISTER_P') 
		{
			require("submit_pdf_register.php");
			$mostrar = 0; 
		}

	IF ($ft_field == '$COUNTRY') 
		{
			require("submit_pdf_country.php");
			$mostrar = 0; 
		}
	IF ($ft_field == '$TEAM') 
		{
			require("submit_pdf_team.php");
			$mostrar = 0; 
		}
		
	IF (substr($ft_field,0,2) == '$M') 
		{
			$mostrar = 2; 
			$content = '========================'.msg($sub_pdf_title);
		}		
		
	if (($ft_field == '$FILE') and ($file_list == 0)) 
		{
			$file_list = 1;
			require("submit_pdf_files.php");
			$mostrar = 0; 
		}

	if (($ft_id == 'REFER') or ($ft_id == 'ORCAPR'))
		{ 
		if ($pr_orca == False)
			{
			$pr_orca = True;
			require("submit_pdf_cronograma.php");
			require("submit_pdf_orcamento.php"); 
			}
		$mostrar = 1; 
		$declaracoes = true;
		$space=4;
		$align='J';
		}
		
	/* Mostrar com cabecalho */	
	if (($mostrar == 1) and (strlen($content) > 0))
		{
		$pdf->MultiCell(0,0,' ',1,$align);
		$pdf->Ln($ln);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(0,8,$caption,0,$align);
		$pdf->Ln($ln);
		$pdf->SetFont('Times','',$ft_size);
		$pdf->MultiCell(0,$space,$content,0,$align);
		$pdf->Ln($ln);
		$pdf->MultiCell(0,8,' ',0,$align);
		$pdf->Ln($ln);
		}
	/* Mostrar sem cabecalho */
	if (($mostrar == 2) and (strlen($content) > 0))
		{
		$pdf->SetFont('Times','',$ft_size);
		$pdf->MultiCell(0,$space,$content,0,$align);
		$pdf->Ln($ln);
		$pdf->MultiCell(0,8,' ',0,$align);
		$pdf->Ln($ln);
		}		
	if ($declaracoes == true)
		{
		require("submit_pdf_decalracao.php");
		$declaracoes = false;
		}		
	}
///////////////////////////////////////////////// IMPRIMIR CRONOGRAMA CASO NAO TENHA SIDO IMPRESSO
	if ($pr_orca == False)
		{
		$pr_orca = True;
		//require("submit_pdf_cronograma.php");
		//require("submit_pdf_orcamento.php"); 
		//require("submit_pdf_decalracao.php");
		}
			
$pdf->Ln($ln);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(0,8,msg('created_in').' '.date("d/m/Y H:i"),0,'R');	
////////////////////////////// DOCUMENTOS EM IMAGEM FINAL
for ($ko=0;$ko < count($img_fim);$ko++)
	{
	$pdf->AddPage();
	$pdf->MultiCell(0,8,'IMAGEM',0,'C');
	$pdf->Image($img_fim[$ko],0,0,210,280);
	$pdf->SetFont('Times','',16);
	}

if (strlen($destino) > 0)
	{
		$pdf->Output($destino);
	} else {
		$pdf->Output();
	}
?>
