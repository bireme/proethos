<?
    /**
     * FAQ
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage faq
    */
class cep_amendment_type
	{
		var $id_faq;
		var $faq_pergunta;
		var $faq_resposta;
		var $faq_ordem;
		var $faq_ativo;
		var $faq_seccao;
		
		var $tabela = 'cep_amendment_type';
		
		function cp()
			{
				global $lg;
				$op = $lg->idioma_form();
				$cp = array();
				array_push($cp,array('$H8','id_amt','id_amt',False,True));
				array_push($cp,array('$H3','amt_codigo',msg('codigo'),True,True));
				array_push($cp,array('$S100','amt_descrip',msg('descript'),True,True));
				array_push($cp,array('$O 1:#YES&0:#NO','amt_ativo',msg('active'),True,True));
				array_push($cp,array('$S3','amt_form',msg('form_amend'),True,True));
				//array_push($cp,array('$Q n_descricao:n_codigo:select * from nucleo where n_ativo=1','faq_seccao',msg('nucleo'),True,True));
				return($cp);
			}
		function row()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_amt','amt_descrip','amt_ativo');
				$cdm = array('cod',msg('descrip'),msg('active'));
				$masc = array('','','','','','SN');
				return(1);				
			}	
		function updatex()
			{
				return(1);
			}	
		function faq()
			{
				global $LANG;
				$sql = "select * from ".$this->tabela;
				$sql .= " where faq_seccao = '".$this->faq_seccao."' ";
				$sql .= " and faq_idioma = '".$LANG."' ";
				$sql .= " and faq_ativo = 1";
				$sql .= " order by faq_idioma, faq_ordem ";
				$rlt = db_query($sql);
				$sx = '';
				$per = 0;
				while ($line = db_read($rlt))
					{
						$per++;
						$sx .= '<BR>'.$per.'&nbsp;<B>';
						$sx .= '<A TAG="#fq'.$line['id_faq'].'"></A>';
						$sx .= '<A HREF="#fq'.$line['id_faq'].'" style="lt2" onclick="mostra_answer('.$line['id_faq'].');">';
						$sx .= trim($line['faq_pergunta']);
						$sx .= '</A>';
						$sx .= '</B>';
						$sx .= '<div id="faq'.$line['id_faq'].'" style="display: none;" >'.chr(13);
						$sx .= mst(trim($line['faq_resposta'])).chr(13);
						$sx .= '</div>'.chr(13);
					}
					$sx .= '<script>'.chr(13);
					$sx .= 'function mostra_answer(id) {'.chr(13);
					$sx .= " var local = '#faq'+id; ".chr(13);			
					$sx .= ' var tela01 = $(local).toggle("slow"); '.chr(13);			
					$sx .= '}'.chr(13);			
					$sx .= '</script>'.chr(13);
				return($sx);
				
			}	
	}
?>
