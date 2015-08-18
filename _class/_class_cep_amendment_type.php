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
				global $base;
				$c = 'amt';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);
			}	
	}
?>
