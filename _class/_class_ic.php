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
     * IC
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage ic commucations
    */
class ic
	{
		var $titulo;
		var $texto;
		var $tabela = 'ic_noticia';
		
		function message()
			{
				
			}
		function cp()
			{
				global $journal_id;
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				array_push($cp,array('$H4','id_nw','id_nw',False,False,''));
				array_push($cp,array('$HV','nw_journal',round($journal_id),True,True,''));
				array_push($cp,array('$S20','nw_ref',msg('page_ref'),True,True,''));
				array_push($cp,array('$S200','nw_titulo',msg('title'),True,True,''));
				array_push($cp,array('$T60:8','nw_descricao',msg('content').' (HTML)',False,True,''));
				//dd5
				array_push($cp,array('$HV','nw_dt_de',19000101,True,True,''));
				array_push($cp,array('$HV','nw_dt_ate',19000101,True,True,''));
				array_push($cp,array('$HV','nw_fonte','',False,True,''));
				array_push($cp,array('$HV','nw_link','',False,True,''));
				array_push($cp,array('$HV','nw_secao',1,False,True,''));
				//dd10
				array_push($cp,array('$O pt_BR:Portugues&en_US:English&es:Español&fr:Français','nw_idioma','Idioma',True,True,''));
				array_push($cp,array('$U8','nw_dt_cadastro','data',False,True,''));
				return($cp);				
			}
		function row()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_nw','nw_ref','nw_titulo','nw_idioma');
				$cdm = array('cod',msg('ref'),msg('title'),msg('language'));
				$masc = array('','','','','');
				return(1);				
			}
		function ic($cod='')
			{
				global $jid,$LANG;
				$sql = "select * from ".$this->tabela." 
					where nw_ref = '".$cod."' ";
				$sql .= " and nw_idioma = '$LANG' ";
				if (strlen($jid) > 0) { $sql .= " and (journal_id = $jid)"; } 
				$sql .= " limit 1";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
					$title = trim($line['nw_titulo']);
					$txt = trim($line['nw_descricao']);
					} else {
						$title = $cod;
						$txt .= 'Message not found: '.$cod.' ('.$LANG.')';
					}
				$txt .= '<BR><BR><font style="font-size:8px">MSG_COD:'.$cod.'</font>';
				$txt = mst($txt);
				
				$rst = array('title'=>$title,
							 'text'=>$txt
							);
				return($rst);
			}
		
	}