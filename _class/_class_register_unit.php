<?
 /**
  * Register Unit
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.07
  * @package Class
  * @subpackage register_unit
 */
class register_unit
	{
	
	var $id ;
	var $codigo;
	var $name; 
	var $obs;
	var $ativo;
	
	var $tabela = "register_unit";
	var $tabela_dados = "cep_submit_register_unit";
	
	function cp()
		{
			global $messa,$dd;
			$cp = array();	
			$opa = ' : &P:'.msg('reg_unit_P').' ';
			$opa .= '&S:'.msg('reg_unit_S').' ';
			
			array_push($cp,array('$H8','id_ru','',False,True));
			array_push($cp,array('$H8','ru_codigo','',False,True));
			array_push($cp,array('$S80','ru_name',msg('name'),False,True));
			array_push($cp,array('$O '.$opa,'ru_type',msg('type'),False,True));
			array_push($cp,array('$T60:4','ru_obs',msg('obs'),False,True));
			array_push($cp,array('$O 1:#YES&0:#NO','ru_ativo',msg('ativo'),False,True));
			return($cp);
		}	
		
	function row()
			{
				global $cdf,$cdm,$masc,$messa;
				$cdf = array('id_ru','ru_name','ru_type','ru_codigo','ru_ativo');
				$cdm = array('cod',msg('nome'),msg('reg_type'),msg('codigo'),msg('ativo'));
				$masc = array('','','','SN','','','');
				return(1);				
			}	
	function dados_add($proto,$unit,$nr,$data='')
			{
				$sql = "select * from ".$this->tabela_dados."
					where csru_protocolo = '$proto' and csru_number = '$nr' and csru_ativo = 1 ";
				$rlt = db_query($sql);
				
				if (!($line = db_read($rlt)))
				{
					$sql = "insert into ".$this->tabela_dados." 
						(csru_protocolo, csru_unit, csru_number, csru_ativo, csru_data) values
						('$proto','$unit','$nr',1,'.$data.'); ";
					$rlt = db_query($sql);
					return(1);
				} else { return(0); }		
			}	
			
	function dados_del($proto,$nr)
			{
				$sql = "update ".$this->tabela_dados." 
					set csru_ativo = 0 where csru_protocolo = '$proto' and id_csru = ".round($nr);
				$rlt = db_query($sql);
				return(1);	
			}
						
	function dados_lista($proto,$tp='')
			{
				$tabela1 = $this->tabela;
				$tabela2 = $this->tabela_dados;
				
				$sql = "select * from $tabela2 
					inner join $tabela1 on csru_unit= ru_codigo
					where csru_protocolo = '$proto' and csru_ativo = 1 ";
				if (strlen(trim($tp)) > 0)
					{ $sql .= " and ru_type = '".$tp."'"; }
				
				$rlt = db_query($sql);
				$rst = array();
				while ($line = db_read($rlt))
					{
						array_push($rst,$line);
					}
				return($rst);
			}
			
	function lista($tp='')
		{
			$cp = array();
			$sql = "select * from ".$this->tabela;
			$sql .= " where ru_ativo = 1 ";
			if (strlen($tp) > 0)
				{ $sql .= " and ru_type = '".$tp."'"; }
			$sql .= " order by ru_name ";
			
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{
					array_push($cp,array(trim($line['ru_codigo']),trim($line['ru_name'])));
				}
			return($cp);
		}
	function updatex()
			{
				$c = 'ru';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
				$rlt = db_query($sql);
			}
	}
?>
