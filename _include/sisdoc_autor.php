<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Autor
*/
function nbr_autor($xa,$tp)
	{
	if (strpos($xa,',') > 0)
		{ 
		$xb = trim(substr($xa,strpos($xa,',')+1,100)); 
		$xa = trim(substr($xa,0,strpos($xa,','))); 
		$xa = trim(trim($xb).' '.$xa);
		}
	$xa = $xa . ' ';
	$xp = array();
	$xx = "";
	for ($qk=0;$qk < strlen($xa);$qk ++)
		{
		if (substr($xa,$qk,1) ==' ')
			{
			if (strlen(trim($xx)) > 0)
				{
				array_push($xp,trim($xx));
				$xx='';
				}
			}
		else
			{
			$xx = $xx . substr($xa,$qk,1);
			}
		}
		
	$xa = "";
		
	/////////////////////////////
	$xp1 = "";
	$xp2 = "";
	$er1 = array("JUNIOR","JÚNIOR","JúNIOR","NETTO","NETO","SOBRINHO","FILHO","JR.");
	///////////////////////////// SEPARA NOMES
		{
		$xop = 0;
		for ($qk=count($xp)-1;$qk >= 0; $qk--)
			{
			
			$xa = trim($xa . ' - ' . $xp[$qk]);
			if ($xop==0)
				{ $xp1 = trim($xp[$qk] . ' ' . $xp1 ); $xop = -1; }
				else { $xp2 = trim($xp[$qk] . ' ' . $xp2); }
				
				if ($xop == -1)
					{
					$xop = 1;
					for ($kr=0;$kr < count($er1);$kr++)
						{
						if (trim(UpperCaseSQL($xp[$qk]))==trim($er1[$kr]))
							{
							$xop = 0;
							}
						}
					}
			}		
		}
		
	////////// 1 e 2
	$xp2a = strtolower($xp2);
	$xa = trim(trim($xp2).' '.trim($xp1));
	if (($tp == 1) or ($tp == 2))
			{
			if ($tp==1)
				{ $xp1 = UpperCase($xp1); }
				$xa = trim(trim($xp1).', '.trim($xp2));
			if ($tp==2)
				{ $xa = UpperCaseSQL(trim(trim($xp1).', '.trim($xp2))); }
			}
	if (($tp == 3) or ($tp == 4))
		{
			if ($tp==4)
				{ $xa = UpperCaseSQL($xa); }
		}

	if (($tp >= 5) or ($tp <= 6))
		{
			$xp2a = str_word_count(lowerCaseSQL($xp2),1);
			$xp2 = '';
			for ($k = 0;$k < count($xp2a);$k ++)
				{
				if ($xp2a[$k] == 'do') { $xp2a[$k] = ''; }
				if ($xp2a[$k] == 'da') { $xp2a[$k] = ''; }
				if ($xp2a[$k] == 'de') { $xp2a[$k] = ''; }
				if (strlen($xp2a[$k]) > 0)
					{ $xp2 = $xp2.substr($xp2a[$k],0,1).'. '; }
				}
			$xp2 = trim($xp2);
			if ($tp == 6) { $xa =  UpperCaseSQL(trim(trim($xp2).' '.trim($xp1))); }
			if ($tp == 5) { $xa =  UpperCaseSQL(trim(trim($xp1).', '.trim($xp2))); }
		}
		
////////////////////////////////////////////////////////////////////////////////////
	if (($tp == 7) or ($tp == 8))
		{
		$mai = 1;
		$xa = strtolower($xa);
		for ($r=0;$r < strlen($xa);$r++)
			{
			if ($mai == 1)
				{ $xa = substr($xa,0,$r).UpperCase(substr($xa,$r,1)).substr($xa,$r+1,strlen($xa)); $mai = 0; }
				else 
				{ if (substr($xa,$r,1) == ' ') { $mai = 1; } }
			}
			$xa = troca($xa,'De ','de ');
			$xa = troca($xa,'Da ','da ');
			$xa = troca($xa,'Do ','do ');
		}		
	return $xa;
	}

function qr_autor($autor)
		{
		$autor = $autor . chr(13);
		$aut = array();
		while (strpos($autor,chr(13)) > 0)
			{
			$wd = trim(substr($autor,0,strpos($autor,chr(13))));
			if (strlen(trim($wd)) > 0)
				{
				if (strpos($wd,';') > 0)
					{
					$wd = substr($wd,0,strpos($wd,';'));
					}
				$wd = troca($wd,'<BR>',chr(13).chr(10));
				array_push($aut,$wd);
				}
				$autor = substr($autor,strpos($autor,chr(13))+1,strlen($autor));
			}
	return($aut);
	}
function ext_autor($autor)
		{
		$aut = array();
		$autor = $autor . chr(13);
		while (strpos($autor,chr(13)) > 0)
				{
				$wd = trim(substr($autor,0,strpos($autor,chr(13))));
				if (strlen($wd) > 0)
					{ array_push($aut,$wd.';'); }
					$autor = substr($autor,strpos($autor,chr(13))+1,strlen($autor));
				}
			$autor = '';
			$q_autor = array();			
			
			for ($qk=0;$qk < count($aut);$qk++)
				{
				$autor = substr($aut[$qk],0,strpos($aut[$qk],';'));
				$quali = "";
				if (strpos($aut[$qk],';') > 0)
					{
					$quali = substr($aut[$qk],strpos($aut[$qk],';'),200);
					}
				array_push($q_autor,array($autor,$quali));
				}
			return $q_autor;
		}
function mst_autor($autor,$tp)
		{
		if (($tp==1) or ($tp==2))
			{
			$aut = array();
			$autor = $autor . chr(13);
			while (strpos($autor,chr(13)) > 0)
				{
				$wd = trim(substr($autor,0,strpos($autor,chr(13))));
				if (strlen($wd) > 0)
					{
					array_push($aut,trim($wd).';');
					}
					$autor = substr($autor,strpos($autor,chr(13))+1,strlen($autor));
				}
			$autor = '';
			for ($qk=0;$qk < count($aut);$qk++)
				{
				if (strlen($autor) > 0) 
					{ 
					if ($tp=='1') { $autor = $autor . ', '; }
					if ($tp=='2') { $autor = $autor . '<BR>'; }
					}
				$autor = $autor . substr($aut[$qk],0,strpos($aut[$qk],';'));
				if (strlen(substr($aut[$qk],strpos($aut[$qk],';')+1,100)) > 0)
					{
					/* Qualificação */
					if ($tp=='2') { 
						$nx = substr($aut[$qk],strpos($aut[$qk],';'),100);
						$nx = trim(troca($nx,';',''));
						if (strlen($nx) > 0) { $autor = $autor . '<sup>&nbsp;'.($qk+1).'</sup>'; }
						}
					}
				}
			if ((strlen($autor) > 0) and ($tp=='1')) { $autor = $autor . '. ';}
			}
			
		if ($tp==3)
			{
			$aut = array();
			$autor = $autor . chr(13);
			while (strpos($autor,chr(13)) > 0)
				{
				$wd = trim(substr($autor,0,strpos($autor,chr(13))));
				if (strlen($wd) > 0)
					{
					array_push($aut,$wd);
					}
					$autor = substr($autor,strpos($autor,chr(13))+1,strlen($autor));
				}
			$autor = '';
			for ($qk=0;$qk < count($aut);$qk++)
				{
					if (strlen($autor) > 0) { $autor = $autor . '<BR>'; }
					$mtautor = $aut[$qk];
					if (strpos($mtautor,';') > 0)
						{
						$ntautor = ' '.substr($mtautor,strpos($mtautor,';')+1,strlen($mtautor));
						if (strpos($ntautor,';') > 0)
							{
							$bmautor = "";
							$btautor = substr($ntautor,strpos($ntautor,';')+1,strlen($ntautor));
							if ($btautor == '[DIR]') { $bmautor = "Diretor"; }
							if ($btautor == '[POS]') { $bmautor = "Aluno da Pós-Graduação"; }
							if ($btautor == '[GRA]') { $bmautor = "Aluno da Graduação"; }
							if ($btautor == '[ORI]') { $bmautor = "Orientador"; }
							if ($btautor == '[COL]') { $bmautor = "Colaborador"; }
							if ($btautor == '[COO]') { $bmautor = "Co-orientador"; }
							if ($btautor == '[PUC]') { $bmautor = "Bolsista PUCPR"; }
							if ($btautor == '[CNPQ]') { $bmautor = "Bolsista CNPQ"; }
							if ($btautor == '[FA]') { $bmautor = "Bolsista Fundação Araucária"; }
							if ($btautor == '[ICV]') { $bmautor = "ICV"; }
							if (strlen($btautor.$bmautor) > 0)
								{
								$autor = $autor . ($qk+1).' '.substr($ntautor,0,strpos($ntautor,';')-1);
								$autor = $autor . $bmautor;
								}
							} else {
							$autor = $autor . ($qk+1).' '.substr($ntautor,strpos($ntautor,';')+1,strlen($ntautor));
							}
						}
				}
			}
		return($autor);
		}
?>
<?
Function AutorFormata($cc1,$cc2)
	{
	$cc = '';
	$nome1 = trim(trim($cc1['first_name']).' '.trim($cc1['middle_name']));
	$nome1 = strtolower($nome1);
	$nome3 = trim($cc1['last_name']);

	if ($cc2==1)
		{ $cc = ucwords(strtolower(trim(trim(trim($nome1).' '.$nome2).' '.$nome3))); }

	if ($cc2==2)
		{	$cc = strtoupper($nome3);
			$cc = $cc.', '.ucwords(strtolower(trim($nome1.' '.$nome2)));
		}
	return $cc;
	}
?>
