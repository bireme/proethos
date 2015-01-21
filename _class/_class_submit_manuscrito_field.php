<?php
 /**
  * fields
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.07
  * @package Class
  * @subpackage fields
 */
 
class fields
	{
	var $tabela = 'cep_submit_manuscrito_field';
	function cp()
		{
			$cp = array();
			array_push($cp,array('$H8','id_sub','',False,True));
			array_push($cp,array('$[1-99]','sub_pag',msg('pagina	'),True,True));
			array_push($cp,array('$[1-99]','sub_pos',msg('ordem'),True,True));
			array_push($cp,array('$[1-20]','sub_ordem',msg('sub_ordem'),False,True));
			array_push($cp,array('$S100','sub_descricao','descricao',False,True));
			array_push($cp,array('$T60:4','sub_field','field',False,True));
			array_push($cp,array('$S30','sub_css',msg('sub_css'),False,True));			
			array_push($cp,array('$O 1:#YES&0:NO','sub_ativo',msg('sub_ativo'),False,True));
			array_push($cp,array('$H8','sub_codigo','',False,True));
			array_push($cp,array('$O 1:#YES&0:NO','sub_obrigatorio',msg('sub_obrigatorio'),False,True));
			array_push($cp,array('$O 1:#YES&0:NO','sub_editavel',msg('sub_edit'),False,True));
			array_push($cp,array('$H8','sub_informacao','',False,True));
			array_push($cp,array('$HV','sub_projeto_tipo','00001',False,True));
			
			array_push($cp,array('$S100','sub_pdf_title','pdf_title',False,True));
			array_push($cp,array('$O 1:#yes&0:#no','sub_pdf_mostra','Mostra',False,True));
			array_push($cp,array('$O L:Left&J:Justify&R:Right','sub_pdf_align',msg('align'),False,True));
			array_push($cp,array('$O 12:12','sub_pdf_font_size','size',True,True));
			array_push($cp,array('$O 6:6px&8:8px&10:10px&12:12px','sub_pdf_space',msg('space'),True,True));
			array_push($cp,array('$I8','sub_limite',msg('limite_words'),True,True));
			array_push($cp,array('$S100','sub_caption',msg('sub_caption'),False,True));
			array_push($cp,array('$S7','sub_id',msg('sub_reference'),False,True));
			return($cp);
		}	
	function row() {
		global $cdf, $cdm, $masc;
		$cdf = array('id_sub', 'sub_descricao','sub_field', 'sub_pag', 'sub_pos','sub_ordem', 'sub_ativo', 'sub_codigo');
		$cdm = array('cod', msg('description'), msg('fields'),msg('pag'),msg('pos'),msg('order'), msg('ativo'), msg('codigo'));
		$masc = array('', '', '','','','','','','','SN');
		return (1);
		}
	
	function updatex() {
		global $base;
		$c = 'sub';
		$c1 = 'id_' . $c;
		$c2 = $c . '_codigo';
		$c3 = 5;
		$sql = "update " . $this -> tabela . " set $c2 = lpad($c1,$c3,0) where $c2='' ";
		if ($base == 'pgsql') { $sql = "update " . $this -> tabela . " set $c2 = trim(to_char(id_" . $c . ",'" . strzero(0, $c3) . "')) where $c2='' "; }
		$rlt = db_query($sql);
	}
	}
?> 
