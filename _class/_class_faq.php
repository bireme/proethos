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


    /**
     * FAQ
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage faq
    */
class faq
	{
		var $id_faq;
		var $faq_pergunta;
		var $faq_resposta;
		var $faq_ordem;
		var $faq_ativo;
		var $faq_seccao;
		
		var $tabela = 'faq';
		
		function cp()
			{
				global $lg;
				$op = $lg->idioma_form();
				$cp = array();
				array_push($cp,array('$H8','id_faq','id_faq',False,True));
				array_push($cp,array('$T80:4','faq_pergunta',msg('question'),True,True));
				array_push($cp,array('$T80:4','faq_resposta',msg('answer'),True,True));
				array_push($cp,array('$[1-120]','faq_ordem',msg('ord'),True,True));
				array_push($cp,array('$O 1:#YES&0:#NO','faq_ativo',msg('ativo'),True,True));
				//array_push($cp,array('$Q n_descricao:n_codigo:select * from nucleo where n_ativo=1','faq_seccao',msg('nucleo'),True,True));
				array_push($cp,array('$HV','faq_seccao','CEP',True,True));
				array_push($cp,array('$O '.$op,'faq_idioma',msg('idioma'),True,True));
				return($cp);
			}
		function row()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_faq','faq_pergunta','faq_ordem','faq_seccao','faq_idioma','faq_ativo');
				$cdm = array('cod',msg('question'),msg('ord'),msg('nucleo'),msg('language'),msg('ativo'));
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