<?php
    /**
     * Header
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.14.18
	 * @package Library
	 * @subpackage Form
    */

if(!isset($LANG) || $LANG == ''){ $LANG = 'pt_BR'; }

echo '
	<!--- Class Form -->
	
		<script type="text/javascript" src="'.$include.'js/jquery-ui.js"></script>
		<script type="text/javascript" src="'.$include.'js/jquery.dynatree.js"></script>
		<script type="text/javascript" src="'.$include.'js/jquery-calender_'.$LANG.'.js"></script>
		<script language="JavaScript" type="text/javascript" src="'.$include.'js/jquery.maskedit.js"></script>
		
		<link href="'.$include.'css/calender_data.css" rel="stylesheet" type="text/css" id="skinSheet"> 
		
		
		
	';
	
function gets($a1,$a2,$a3,$a4,$a5)
	{
		global $form;
		/*
		echo '<BR>a1='.$a1;
		echo '<BR>a2='.$a2;
		echo '<BR>a3='.$a3;
		echo '<BR>a4='.$a4;
		echo '<BR>a5='.$a5;	
		echo '<BR>a6='.$a6;
		echo '<BR>a7='.$a7;
		echo '<HR>';
		 */
		if ($a5 == 1) { $a5 = True; } else { $a5 = False; }		
		$cp = array($a3,'',$a4,$a5,True); 
		$form->name = $a1;
		$form->value = $a2;
		$sx = $form->process($cp);
		return($sx);
	}

class form
	{
		/* Standard Fields */
		var $size=10;
		var $maxlength = 10;
		var $name='';
		var $caption='';
		var $caption_original='';
		var $required=0;
		var $rq = '';
		var $readonly=0;	
		var $fieldset='';
		
		var $form_name = "formulario";
		
		/* Valores */
		var $value='';
		var $line;
		var $par;
		var $js = '';
		var $cols=80;
		var $rows=5;
		var $js_valida = '';
		var $key;
		var $ajax = '';
		var $total_cps=0;
		
		var $required_message = 1;
		var $required_message_post = 1;		
		var $saved = 0;

		/* Stlye */
		var $class_string='';
		var $class_password='';
		var $class_textbox = '';
		var $class_button_submit = '';
		var $class_memo = '';
		var $class_select = '';
		var $class_select_option = '';

	/* AJAX */
	function ajax($id,$protocolo)
		{
		return($this->ajax_refresh($id, $protocolo));	
		}
	function ajax_refresh($id,$protocolo)
		{
			global $http;
			$js = '
			var page = \''.$http.'_ajax/ajax_form.php\';
			$.ajax({
				type: "POST",
				url: page,
				data: { dd1: "'.$protocolo.'", dd91: "'.$id.'", dd2: "REFRESH" }
			}).fail(function() {
   					alert( "error - " + page );
			}).done(function( data ) {
				$("#'.$id.'_main").html(data);
			});			
			';
			$sx .= '<script>
					'.$js.'
					</script>';
			return($sx);			
		}
	
	function active($id,$protocolo,$verbo)
		{
			global $http;
			$js = '
			$("#'.$id.'").click(function() {
				var page = \''.$http.'_ajax/ajax_form.php\';
				$.ajax({
					type: "POST",
					url: page,
					data: { dd1: "'.$protocolo.'", dd91: "'.$id.'", dd2: "'.$verbo.'" }
				}).fail(function() {
    					alert( "error" );
				}).done(function( data ) {
					$("#'.$id.'_field").html(data);
				});			
			});
			';
			
			$sx .= '<script>
					'.$js.'
					</script>';
			return($sx);
		}
		/* Gerador de Token de Session */
		function keyid()
			{
				global $secu;
				$key = md5(microtime() . $secu . rand());
				$keysid = trim($_SESSION['token_field']);
				$keys = trim($_SESSION['token']);
				if (strlen($keys) > 0)
					{
						$key = $keys;
					} else {
						/* New KeyId*/
					}
				$_SESSION['token'] = $key;
				$this->key = $key;
				return(md5($key));				
			}
		/* Gerador de Token de Formulario */
		function keyid_form()
			{
				global $secu;
				$size = 10;
				$key = troca(microtime() + rand(),'.','');
				$key = substr($key,strlen($key)-$size,$size);

				$this->key_form = $key;
				$this->key_form_check = strzero(3*$key,$size);
				return($key);				
			}			
		
		/* Editar */
		function editar($cp,$tabela,$post='')
			{
				global $dd,$acao,$path,$http;
				
				/* AJAX */
				if ($this->ajax==1)
					{
						if (strlen($this->frame) == 0) { echo 'FRAME NAME NOT FOUND'; exit; }
						
						/* Mostra campos para o ajax */
						$vars = ''; $data = ''; $ks = '';
						for ($r=0;$r < (count($cp)+3); $r++)
							{
								
								/* Novo */
								$op = substr($cp[$r][0],0,2);
								if ($op != '$O' and $op != '$Q')
									{
										$vars .= 'var ddv'.$r.' = $("#dd'.$r.'").val();'.chr(13).chr(10);		
									} else {
										$vars .= 'var ddv'.$r.' = $(\'#dd'.$r.' option:selected\').val();'.chr(13).chr(10);
									}
								if (strlen($data) > 0) { $data .= ', '; }
								$data .= 'dd'.$r.': ddv'.$r.' ';								
							}
						$data .= ', dd91: \''.$this->frame.'\', dd89: \''.$this->frame.'\', acao: \'gravar\' ';
						
						/* Inicia construcao do formulario */
						
						$sx = '';
						$page = $http.'_ajax/ajax_form.php';
						$sx .= '
						<script>
						var dd91 = \''.$this->frame.'\';
						function enviar_formulario(id)
							{
								'.$vars.'
								/* alert("POST "+id + "'.$data.' - '.$this->frame.'"); */
								var tela01 = $.ajax({
										type: "POST",
										url: \''.$page.'\',
										data: { '.$data.'}
										}) 
										.done(function(data) { $("#'.$this->frame.'_main").html(data); })
										.fail(function() { alert("error"); });
							}
						</script>
						';
					}
				
				$this->total_cps = count($cp);
							
				/* Local de salvamento dos dados */
				if (strpos($tabela,':') > 0)
					{
						/* Salva em arquivos */
						$file = 1;
					} else {
						/* Salvar em tabela de base de dados */
						$file = 0;
					}
					
				/* Campos */
				$bto = 0;
				for ($r=0;$r < count($cp);$r++)
					{
						if (substr($cp[$r][0],0,2)=='$B') { $bto = 1; }
					}
				if ($bto == 0)
					{ array_push($cp,array('$B8','',msg('save'),false,false)); }
				$this->keyid();
				array_push($cp,array('$TOKEN','','',True,False));
				
				/**
				 * Recupera informacoes da tabela do banco de dados
				 */
				$recupera = 0;
				if ((strlen($tabela) > 0) and
						($file == 0) and 
						(strlen($acao)==0) and 
						(strlen($dd[0]) > 0) and 
						(strlen($cp[0][1]) > 0))
							{
								$sql = "select * from ".$tabela." where ".$cp[0][1]." = '".$dd[0]."'";
								$rrr = db_query($sql);
								if ($line = db_read($rrr)) { $this->line = $line; }
								$recupera = 1;							
							}

				/**
				 * Recupera informacoes do arquivo
				 */
				
				if ((strlen($filename) > 0) and
						($file == 1) and 
						(strlen($acao)==0))
							{
								echo '#1#'; exit;
								require($filename);
								$recupera = 1;							
							}

				/**
				 * Processa
				 */
	 
				$this->js_submit = '<script>';
				if (strlen($post)==0) { $post = page(); }
				$this->saved = 1;
				$this->rq = '';
				//echo '<BR>'.date("Y-m-d H:i:s");	
				$sx .= '<form id="'.$this->form_name.'" method="post" action="'.$post.'">'.chr(13);
				$sh .= '<table class="'.$this->class_form_standard.'" width="100%" border=0 >'.chr(13);
				
				for ($r=0;$r < count($cp);$r++)
					{
						if ($recupera == 1) 
							{
								$fld = $cp[$r][1]; 
								$dd[$r] = trim($this->line[$fld]);
								if (substr($cp[$r][0],0,2)=='$D')
									{
										$dd[$r] = stodbr($this->line[$fld]);		
									} 
							}
						$this->name = 'dd'.$r;
						if (!(is_array($dd))) { $dd = array(); }
						
						$this->value = trim($dd[$r]);

						$sx .= $this->process($cp[$r]);
 
						if (($cp[$r][0]=='$TOKEN') and (strlen($acao) > 0))
							{
								$keyc = md5($this->key);
								if ($keyc != $this->value)
									{
									//if ($this->required_message_post == 1)
										{ $sx .= '<TR><TD colspan=2><font color="red">Try CSRF (ingected)</font><BR>'; }
									$this->saved = 0;
									}
							}

						if (($cp[$r][0]=='$TOKEN') and (strlen($acao) > 0))
							{
								
								$array = $_POST;
								if (is_array($array))
									{
										$fld = array_keys($_POST);
									} else {
										$fld = array();
									}
								
								$fldk_value = '1';
								$fldk_vlr = '2';
								
								$sz = round(count($fld));
								$fldk = '';
								
								if ($sz > 0) 
									{
										for ($ry=0;$ry < count($fld);$ry++)
										{
										$flda = $fld[$ry];
										if (!(is_array($flda)))
											{
											if (substr($fld[$ry],0,2)=='tk')
												{ $fldk = $fld[$ry]; }
											}								
										}
										//echo '<BR>FIM2-'.$sz.'-'.date("Y-m-d H:i:s"); 
										if (strlen($fldk) > 0)
										{
											$fldk_value = substr($fldk,2,strlen($fldk));
											$fldk_vlr = (round($_POST[$fldk]/3));
										} else {
											$fldk_value = '1'; $fldk_vlr = '2';
										}
									}
								
								if (($fldk_value != $fldk_vlr) and ($this->ajax==0))
									{
										$sx .= '<TR><TD colspan=2><font color="red">Try CSRF ingected (2)</font><BR>';
										$this->saved = 0;
									}								
							}	
													
						if (($this->required == '1') and (strlen($this->value) == 0) )
							{
								if ($this->required_message_post==1)
									{
									$this->rq .= msg('field').' '.$this->caption.' '.msg('is_requered').'(dd'.$r.')<BR>';
									}
								$this->saved = 0; 
							}
					}
				$sx .= '<input type="hidden" name="dd99" id="dd99" value="'.$dd[99].'">'.chr(13);
				$sx .= chr(13).'</table>';
				$sx .= '</form>';
				$this->js_submit .= chr(13).'</script>';

				$sx .= $this->js;
				$sx .= $this->js_submit;
				
				if ((strlen($this->rq) > 0) and (strlen($acao) > 0))
					{
						$sa = '<TR><TD colspan=2 bgcolor="#FFC0C0">';
						$sa .= '<img src="'.$http.'img/icone_alert.png" height="50" align="left">';
						$sa .= '<font class="lt1">';
						$sa .= $this->rq;
						$sa .= '</font>';
						$sa .= $sx; 
						$sx = $sa;
					}
				if (($this->saved > 0) and (strlen($acao) > 0))
					{
						if (strlen($tabela) > 0)
							{
								if ($file == 0)
									{ $this->save_post($cp,$tabela); }
								else 
									{ $this->save_file_post($cp,$tabela); }
							}
						//$sx = 'SAVED TABLE '.$tabela.' id = '.$dd[0];
					} else {
						$this->saved = 0;
					}
				return($sh.$sx);
			}

		function save_file_post($cp,$tabela)
			{
				global $dd,$acao,$path;
				$type = UpperCaseSql(substr($tabela,0,strpos($tabela,':')));
				$filename = substr($tabela,strpos($tabela,':')+1,strlen($tabela));
				
				switch ($type)
					{
					case 'PHP':
							$file_pre = '<?php'.chr(13).chr(10);
							$file_pos = '?>';
							break;
					default:
							$file_pre = '';
							$file_pos = '';
							break;
					}

					$sx = '';
					for ($k=1;$k<100;$k++)
						{
							if ((strlen($cp[$k][1])>0) and ($cp[$k][4]==True))
							{
								
								$field = trim($cp[$k][1]);
								$vlr = trim($dd[$k]);
								if (strlen($field) > 0)
									{
										switch ($type)
										{
											case 'PHP':
												$sx .= $field."='".$vlr."';".chr(13).chr(10);
												break;
											case 'CVS':
												break;
											default:
												$sx .= $field."='".$vlr."'".chr(13).chr(10);
												break;
										}
									}	
							}
						}
					$sx = $file_pre . $sx . $file_pos;
					if (strlen($filename) > 0)
						{
							$rlt = fopen($filename,'w+');
							fwrite($rlt,$sx);
							fclose($rlt);
						}
					$acao=null;
					$saved=1;
				return(1);				
			}

		function save_post($cp,$tabela)
			{
				global $dd,$acao,$path;
				if (isset($dd[0]) and (strlen($dd[0]) > 0) and (strlen($cp[0][1]) > 0)) 
					{
					$sql = "update ".$tabela." set ";
					$cz=0;
					for ($k=1;$k<100;$k++)
						{
							if ((strlen($cp[$k][1])>0) and ($cp[$k][4]==True))
							{
								if (($cz++)>0) {$sql = $sql . ', ';}
								if (substr($cp[$k][0],0,2) == '$D') 
									{
								 		$dd[$k] = brtos($dd[$k]); 
									}
								$sql = $sql . $cp[$k][1].'='.chr(39).$dd[$k].chr(39).' ';
							}
						}
						$sql = $sql .' where '.$cp[0][1]."='".$dd[0]."'";
					if (strlen($tabela) >0)
						{ $result = db_query($sql) or die("<P><FONT COLOR=RED>ERR 002:Query failed<HR>".$sql); }
					$acao=null;
					$saved=1;
					}
				else
					{
					$sql = "insert into ".$tabela." (";
					$sql2= "";
					$tt=0;
					for ($k=1;$k<100;$k++)
						{
							if (strlen(trim(($cp[$k][1]))))
							{
								if ($tt++ > 0) { $sql = $sql . ', '; $sql1 = $sql1 .', ';}
								$sql = $sql . $cp[$k][1];
								if (substr($cp[$k][0],0,2) == '$D') { $dd[$k] = brtos($dd[$k]); }
								$sql1= $sql1. chr(39).$dd[$k].chr(39);
							}
						}
					$sql = $sql . ') values ('.$sql1.')';
			//		echo $sql;
					$sqlc = $sql;
		
					if (strlen($tabela) > 0)
						{ $result = db_query($sql); }
		//				$dd[1] = null;
						$acao=null;
						$saved=2;
					}
				return($saved);
				
			}
		
		function process($cp)
			{
				global $dd,$acao,$ged,$http;
				
				/* Caixa Alta */
				$i = UpperCaseSql(substr($cp[0],1,5));
				if (strpos($i,' ') > 0) { $i = substr($i,0,strpos($i,' ')); }
				
				/* Transfere parametros */
				$this->required = $cp[3];
				$this->caption = $cp[2];
				$this->caption_original = $cp[2];
				$this->caption_placeholder = troca($cp[2],'"','');
				$this->fieldset = $cp[1];
				$size = sonumero($cp[0]);
				$this->maxlength = $size;
				$this->caption = $cp[2];
				$ro = UpperCaseSql($cp[4]);
				
				/* Read Only */
				if (($ro=='FALSE') or ($ro == '0')  or (strlen($ro) == '0'))
					{
						$this->readonly = ' READONLY ';		
					} else {
						$this->readonly = '';
					}
				
				
				if ((strlen(trim($acao)) > 0) 
						and ($this->required==1) 
						and (strlen(trim($this->value))==0))
					{ $this->caption = '<font color="red">'.$this->caption.'</font>'; }
					
				if ($size > 80) { $size = 80; }
				$this->size = $size;
				$i = troca($i,'&','');
				$i = troca($i,':','');
				$sn = sonumero($i);
				$i = troca($i,$sn,'');
				//echo '['.$i.']';
				if ((substr($i,0,1)=='T') and ($i != 'TOKEN')) { $i = 'T'; }
				if (substr($i,0,1)=='[') { $i = '['; }
				
				$sx .= chr(13).'<TR valign="top">';
							
				$sh = '<TD align="right">'.$this->caption.'<TD>';
				if (strlen(trim($this->caption_original)) == 0)
					{ $sh = '<TD colspan=2 align="left">'; }
				if (substr($i,0,1)=='T')
					{
						$sh = '<TD colspan=2 align="left">';
						$sh .= $this->caption; 
					}

				switch ($i) 
				{
					/* Field Sets */
					case '{':  $sx .= $this->type_open_field(); break;	
					case '}':  $sx .= $this->type_close_field(); break;	
										
					/* Sequencial */
					case '[':
						$this->par = substr($cp[0],2,strlen($cp[0]));  
						$sx .= $sh. $this->type_seq(); break;	
					case 'AJAX':  $sx .= '<TR><TD colspan=2>'.$this->type_ajax(); break;
					
					case 'AUTOR':  $sx .= '<TR><TD colspan=2>'.$this->type_Autor(); break;	
					/* Caption */
					case 'A':  $sx .= '<TR><TD colspan=2>'.$this->type_A(); break;	
					/* Alert */
					case 'ALERT':  $sx .= '<TR><TD><TD colspan=1>'.$this->type_ALERT(); break;
					/* Button */	
					case 'B':  $sx .= '<TD colspan=2 >'.$this->type_B(); break;	
					/* City, State, Country */
					case 'CITY':  $sx .= $sh. $this->type_City(); break;
					
					/* Declaracao */
					case 'DECLA':  $sx .= $this->type_DECLA(); break;
					
					/* Checkbox */
					case 'C':  $sx .= '<TR><TD colspan=2>'.$this->type_C() . $this->caption; break;					
										
					/* Date */
					case 'D':  $sx .= $sh. $this->type_D(); break;
					/* EAN13 */
					case 'EAN':  $sx .= $sh. $this->type_EAN(0); break;
										
					/* EMAIL */
					case 'EMAIL':  $sx .= $sh. $this->type_EMAIL(0); break;					
					case 'EMAIL_UNIQUE':  $sx .= $sh. $this->type_EMAIL(1); break;
					/* Funcoes adicionais */
					case 'FC':				
						$this->par = substr($cp[0],3,strlen($cp[0])); 
						
						if ($this->par == '001') { $sx .= function_001(); } 
						if ($this->par == '002') { $sx .= function_002(); }
						if ($this->par == '003') { $sx .= function_003(); }
						if ($this->par == '004') { $sx .= function_004(); }
						if ($this->par == '005') { $sx .= function_005(); }
						if ($this->par == '006') { $sx .= function_006(); }
						if ($this->par == '007') { $sx .= function_007(); }
						if ($this->par == '008') { $sx .= function_008(); }
						if ($this->par == '009') { $sx .= function_009(); }
						if ($this->par == '010') { $sx .= function_010(); }
						if ($this->par == '011') { $sx .= function_011(); } 
						
						break;		
					/* Files */
					case 'FILES':
						
						$sx .= '<TD>';
						$sx .= $ged->file_list();
						$sx .= $ged->upload_botton_with_type($ged->protocolo,'','');
						break;
					/* KeyWord */
					case 'KEYWO':  $sx .= $sh. $this->type_KEYWORDS(); break;						
					/* Hidden */
					case 'H':  $sx .= $this->type_H(); break;
					/* Hidden with value */
					case 'HV':  $sx .= $this->type_HV(); break;					
					/* Inteiro */
					case 'I':  $sx .= $sh. $this->type_I(); break;	
					/* MEnsagens */
					case 'M':  $sx .= $this->type_M(); break;
					/* Valor com dias casas */
					case 'N':  $sx .= $this->type_N(); break;
					/* Options */
					case 'O':  
						$this->par = substr($cp[0],2,strlen($cp[0]));
						$sx .= $sh . $this->type_O(); break;					
					/* String Simple */
					case 'P':  $sx .= $sh. $this->type_P(); break;					
					/* Query */
					case 'Q':
						$this->par = splitx(':',substr($cp[0],2,strlen($cp[0])));  
						$sx .= $sh. $this->type_Q(); 
						break;										
					/* Radio box */
					case 'R': 
							$this->par = substr($cp[0],2,strlen($cp[0]));
							$sx .= '<TD colspan=2 >' . $this->caption.': '. $this->type_R(); break;

					/* String Simple */
					case 'S':  $sx .= $sh. $this->type_S(); break;
					/* Text area */
					case 'T':
						$this->cols = sonumero(substr($cp[0],0,strpos($cp[0],':')));
						$this->rows = sonumero(substr($cp[0],strpos($cp[0],':'),100));
						$sx .= $sh. '<TR><TD colspan=2>'. $this->type_T(); 
						break;
					/* String Simple */
					case 'TOKEN':
						$sx .= $this->type_TOKEN(); 
						break;
					/* String Ajax */
					case 'SA': $sx .= $sh. $this->type_SA(); break;
					/* Update */
					case 'U':  $sx .= $sh. $this->type_U(); break;
					/* Estados */
					case 'UF': $sx .= $sh. $this->type_UF(); break;
					
					case 'RT': /* Editor de texto rico (Rich Text) */
					case 'ARV': /* Arvore com checkboxes */
					case 'ATAGS': /* Textarea com autocomplete de tags */
						$params  = $this->_cp_get_params($cp);
						$sx .= $sh.call_user_func_array(array(&$this, 'type_'.$i), $params);
						break;		
				}
				return($sx);
			}

		/**
		 * {
		 */
		 function type_open_field()
		 	{
				$sx = "";
				if (strlen($this->caption) > 0) 
					{ 
					$vcol = 0;
					$sx .= '<TR><TD colspan="2">';
					$sx .= '<fieldset '.$this->class.'>';
					$sx .= '<legend><font class="lt1"><b>'.$this->caption.'</b></legend>';
					$sx .= '<table cellpadding="0" cellspacing="0" class="lt2" width="100%">';
					$sx .= '<TR valign="top">';
					}
				return($sx);
		 	}
		/**
		 * AJAX
		 */
		 function type_ajax()
		 	{
		 		global $dd;
		 		$sx = '';
				$s = $this->ajax;
				$sp = strpos($s,':');
				if ($sp > 0)
					{
					$page = trim(substr($s,$sp+1,strlen($s)).'.php');
						
		 			$sx .= '<div id="'.$this->name.'">loading...</div>'.chr(13).chr(10);
		 			$sx .='<script>
		 				var id = "'.$dd[0].'";
						var name = "'.$this->name.'";
						var acao = "ver";
												
		 				$.ajax({
						type: "POST",
						url: "'.$page.'",
						data: { dd0:id, dd1: acao, dd2: name }
						}).done(function( data ) {$("#'.$this->name.'").html( data ); })
						.fail(function() { alert("ERRO LOAD PAGE '.$page.'"); });
					  </script>
					';
					} else {
						$sx .= 'Erro Ajax: page not found';
					}
				
				return($sx);
		 	}
		/**
		 * {
		 */
		 function type_close_field()
		 	{
				$sx = "";
				$sx .= '</fieldset>';
				$sx = '</table>';
				return($sx);
		 	}
		/**
		 * Function Sequencial
		 */	
		 function type_seq()
		 	{
		 		global $line;
		 		$par = $this->par;
				$dec = strpos($par,']D');
				if ($dec > 0) { $dec = 1; }
				$par = substr($par,0,strpos($par,']'));
				$par = splitx('-',$par);
				$txt = round($this->value);
				$sx = '
				<select name="'.$this->name.'" id="'.$this->name.'" size="1" class="'.$this->class_select.'">
					'.$this->class.' 
					id="'.$this->name.'" >';
				$sx .= '<option value="">'.msg('select_option').'</option>';
				if ($dec==0)
					{									
						for ($nnk=round($par[0]);$nnk <= round($par[1]);$nnk++)
						{
							$sel = '';
							if ($nnk==$txt) {$sel="selected";}
							$sx= $sx . "<option value=\"".$nnk."\" ".$sel.' class="'.$this->class_select_option.'">'.$nnk."</OPTION>";
						}
					} else {
						for ($nnk=round($par[1]);$nnk >= round($par[0]);$nnk--)
						{
							$sel = '';
							if ($nnk==$txt) {$sel="selected";}
							$sx= $sx . "<option value=\"".$nnk."\" ".$sel.' class="'.$this->class_select_option.'">'.$nnk."</OPTION>";
						} 
					}
				$sx = $sx . "</select>" ;
				return($sx);	
			}
					
		/***
		 * type_Autor
		 */
		function type_Autor()
			{
				global $dd,$ged,$http;
				$sx = '<div id="autores">
				carregando.... aguarde...
				</div>';
				
				$link = $http.'pb/ajax_autores.php?dd1='.$ged->protocolo;
				echo $link;
				$sx .= '
				<script>
					$.post(\''.$link.'\', function(data) {
					$("#autores").html(data);
					alert("load...");
					});
				</script>
				';
				return($sx);
			}
		/**
		 * Header
		 */	
		function type_A()
			{
				$sx = '
				<h2>'.$this->caption.'</h2>				
				';
				return($sx);
			}
		/**
		 * Hidden
		 */	
		function type_ALERT()
			{
				global $http;
				if (strlen($this->caption) > 0)
				{
					$sx = '<img src="'.$http.'/img/icone_alert.png" height=40 align="left">';
					$sx .= $this->caption;
				}
				return($sx);
			}			
		/***
		 * Hidden
		 */	
		function type_B()
			{
				global $dd, $cp;
				if ($this->ajax == 0)
				{
				$sx = '
				<input 
					type="submit" name="acao" value="'.strip_tags($this->caption_original).'" 
					id="'.$this->name.'" class="'.$this->class_button_submit.'" />
					';
				} else {
					$sx = '
					<input type="button"
						value="'.$this->caption_original.'" 
						name="acao"
						class="'.$this->class_button_submit.'"
						id="acao" onclick="enviar_formulario(\''.$this->total_cps.'\')" />';
				} 
				return($sx);				
			}
		/***
		 * City
		 */
		function type_City()
			{
				global $LANG;

				$sql = "Select * from ajax_pais where pais_ativo > 0 order by pais_prefe desc, pais_ativo desc, pais_nome ";
				$rrr = db_query($sql); 
				$opt = '<option value="">'.msg('select_your_country').'</option>';
				while ($line = db_read($rrr))
				{
					$check = '';
					$opv = trim($line['pais_codigo']);
					$opd = trim($line['pais_nome']);
					if (trim($this->value)==$opv) { $check = 'selected'; }
					$opt .= chr(13);
					$opt .= '			<option value="'.$opv.'" '.$check.' class="'.$this->class_select_option.'">';
					$opt .= $opd;
					$opt .= '</option>';
				}
				/* Script dos estados */
				$js = '';
				$sx = '
				<select name="'.$this->name.'" id="'.$this->name.'" size="1" 
					'.$this->class.' 
					id="'.$this->name.'" >';
				$sx .= $opt.chr(13);
				$sx .= '</select>';
				return($sx);

			}
		/*********************************
		 * Checkbox
		 */
		function type_C()
			{
				global $include,$acao,$http;
				$sx = '
				<input 
					type="checkbox" name="'.$this->name.'" 
					value = "1"
					maxlength="10"  
					id="'.$this->name.'"
					'.$checked.' />&nbsp;';
				$sx .= '&nbsp;';
				
				return($sx);				
			}
			
			
		/*********************************
		 * Data
		 */
		function type_D()
			{
				global $include,$acao,$http;
				$sx = '
				<input 
					type="text" name="'.$this->name.'" size="13"
					value = "'.$this->value.'"
					maxlength="10" class="'.$this->class_textbox.'" 
					id="'.$this->name.'"
					'.$msk.' />&nbsp;';
				$sx .= $this->requerido();

				/* SCRIPT */
				$gets = '
				<script>
					$("#'.$this->name.'").mask("99/99/9999");
					$("#'.$this->name.'").datepicker({
							showOn: "button",
							buttonImage: "'.$include.'img/icone_calender.gif",
							buttonImageOnly: true,
							showAnim: "slideDown"	 
					});
				</script>
				';
				$this->js .= $gets;
				return($sx);				
			}

		/* Declaracao */
		function type_DECLA()
			{
				global $include,$acao;
				$sx ='<TR><TD colspan=2>';
				$sx .= $this->caption;
				$sx .= '<BR><BR>';
				$sx .= '
				<select name="'.$this->name.'" >
					<option value="" class="'.$this->class_select_option.'"></option>
					<option value="SIM" class="'.$this->class_select_option.'">SIM</option>
				</select>
				, concordo.
				';
				$sx .= $this->requerido();
				return($sx);				
			}
		/***
		 * EAN13
		 */			
		function type_EAN()
			{
				$style = ' size="13" ';
				$sx = '
				<input 
					type="text" name="'.$this->name.'" 
					value = ""
					maxlength="'.$this->maxlength.'" 
					class="'.$this->class_string.'" 
					id="'.$this->name.'"
					placeholder="'.$this->caption_placeholder.'"
					'.$this->readonly.' '.$style.'
					 /> (CODE)'.chr(13);
				$sx .= $this->requerido();
				$sx .= '
				<script>
					$(\'#'.$this->name.'\').focus();
					$(\'#'.$this->name.'\').keyup(function(e) {
    				var enterKey = 13;
    				if (e.which == enterKey){
        				enviar_formulario(\''.$this->total_cps.'\');
     				}
 					});
				</script>				
				';
				
				return($sx);
			}
		/***
		 * String
		 */			
		function type_EMAIL($unique=0)
			{
				$style = ' size="60" style="width: 90%;';
				$sx = '
				<input 
					type="text" name="'.$this->name.'" 
					value = "'.$this->value.'"
					maxlength="'.$this->maxlength.'" '.$this->class.' '.$style.' 
					id="'.$this->name.'" />'.chr(13);
				$sx .= $this->requerido();
				return($sx);
			}

		/***
		 * Hidden
		 */	
		function type_H()
			{
				$sx = '
				<input 
					type="hidden" name="'.$this->name.'" 
					value="'.$this->value.'" id="'.$this->name.'" />';
				return($sx);
			}
		/***
		 * Hidden with value
		 */	
		function type_HV()
			{ 
				$sx = '
				<input 
					type="hidden" name="'.$this->name.'" 
					value="'.$this->caption_original.'" id="'.$this->name.'" />';
				return($sx);
			}

		/**
		 * KEYWORD
		 */
		function type_KEYWORDS()
			{
			$sx = '
				<input 
					type="text" name="'.$this->name.'" value="'.$this->value.'" 
					id="'.$this->name.'" '.$this->class.' />';
				$this->js .= '
				<script>
					$(function() {
						$("#'.$this->name.'").tagsInput({width:\'auto\'});
					});
				</script>
				';
				/* $('#target').submit();*/ 
				return($sx);
			}
		/***
		 * Valores Interiors
		 */
		function type_I()
			{
				global $include;
				$sx = '
				<input 
					type="text" name="'.$this->name.'" size="18"
					value = "'.$this->value.'"
					maxlength="15" '.$this->class.' 
					id="'.$this->name.'"
					'.$msk.' />&nbsp;';
				
				/* SCRIPT */
				$gets = '
				<script>
					$(document).ready(function(){
						$("#'.$this->name.'").maskMoney({precision:0, thousands:""});
					});
				</script>
				';
				$this->js .= $gets;
				return($sx);				
			}
		/* Mensagem */
		function type_M()
			{
				global $include,$acao;
				$sx ='<TR><TD colspan=2 class="'.$this->class_memo.'">';
				$sx .= $this->caption;
				return($sx);				
			}			
			
		/***
		 * Valor com duas casa decimais
		 */
		function type_N()
			{
				global $include;
				$sx = '
				<input 
					type="text" name="'.$this->name.'" size="18"
					value = "'.$this->value.'"
					maxlength="15" '.$this->class.' 
					id="'.$this->name.'"
					'.$msk.' />&nbsp;';
				
				/* SCRIPT */
				$gets = '
				<script>
					$("#'.$this->name.'").maskMoney();
				</script>
				';
				$this->js .= $gets;
				return($sx);				
			}


		/***
		 * String
		 */			
		function type_Q()
			{
				$sql = $this->par[2];
				$rrr = db_query($sql);
				$opt = '<option value="" class="'.$this->class_select_option.'">'.msg('select_an_option').'</option>';
				while ($line = db_read($rrr))
				{
					$check = '';
					$opd = trim($line[$this->par[0]]);
					$opv = trim($line[$this->par[1]]);
					if ($this->value==$opv) { $check = 'selected'; }
					$opt .= chr(13);
					$opt .= '			<option value="'.$opv.'" '.$check.' class="'.$this->class_select_option.'">';
					$opt .= $opd;
					$opt .= '</option>';
				}
				$sx = '
				<select id="'.$this->name.'" name="'.$this->name.'" size="1" 
					class="'.$this->class_select.'">';
				$sx .= $opt.chr(13);
				$sx .= '</select>';
				return($sx);
			}
		
		
			

		/***
		 * String
		 */			
		function type_S()
			{
				if ($this->size > 70) { $style = ' size="70" style="width: 90%;" ';}
				else { $style = 'size="'.$this->size.'" '; }
				$sx = '
				<input 
					type="text" name="'.$this->name.'" 
					value = "'.$this->value.'"
					maxlength="'.$this->maxlength.'" 
					class="'.$this->class_string.'" 
					id="'.$this->name.'"
					placeholder="'.$this->caption_placeholder.'"
					'.$this->readonly.' '.$style.'
					 />'.chr(13);
				$sx .= $this->requerido();
				return($sx);
			}
		/***
		 * Options
		 */			
		function type_O()
			{
				$ops = splitx('&',$this->par);
				
				$sx = '
				<select name="'.$this->name.'" 
					class="'.$this->class_select.'"
					id="'.$this->name.'" >'.chr(13);
				for ($r=0;$r < count($ops);$r++)
					{
						$so = $ops[$r];
						$check = '';
						
						$vl = substr($so,0,strpos($so,':'));
						if ($this->value==$vl) { $check = 'selected'; }
						$sx .= '<option value="'.$vl.'" '.$check.' ';
						if (strlen(trim($this->class_select_option)) > 0) 
							{ $sx .= ' class="'.$this->class_select_option.'"'; }
						$sx .= '>';
						$sx .= trim(substr($so,strpos($so,':')+1,strlen($so)));
						$sx .= '</option>'.chr(13);
					}
				$sx .= '</select>';
				return($sx);
			}
		/***
		 * String
		 */			
		function type_P()
			{
				if ($this->size > 70) { $style = ' size="70" style="width: 90%;" ';}
				else { $style = 'size="'.$this->size.'" '; }
				$sx = '
				<input 
					type="password" name="'.$this->name.'" 
					value = "'.$this->value.'"
					maxlength="'.$this->maxlength.'" class="'.$this->class_password.'" '.$style.'
					placeholder="'.$this->caption_placeholder.'" 
					autocomplete="off"
					id="'.$this->name.'" />'.chr(13);
				$sx .= $this->requerido();
				return($sx);
			}
			
		/**
		 * String Ajax
		 */	
		function type_SA()
			{
				if ($this->size > 70) { $style = ' size="70" style="width: 90%;" ';}
				else { $style = 'size="'.$this->size.'" '; }				
				$sx = '
				<input 
					type="text" name="'.$this->name.'" 
					value = "'.$this->value.'"
					maxlength="'.$this->maxlength.'" '.$this->class.' '.$style.' 
					id="'.$this->name.'" />';
				
				$gets = '
				<script>
					$("#'.$this->name.'").autocomplete({
						source: "_form_ajax.php",
   						minLength: 1,
   						matchContains: true,
        				selectFirst: false
					});				
				</script>';
				$this->js .= $gets;
				return($sx);
			}
		/***
		 * String
		 */			
		function type_T()
			{
				if (round($this->cols)==0) { $this->cols = 80; }
				if (round($this->rows)==0) { $this->rows = 5; }
				$sx = '
				<TEXTAREA 
					type="text" name="'.$this->name.'" size="'.$this->size.'"
					cols="'.$this->cols.'"
					rows="'.$this->rows.'" class="'.$this->class_textarea.'" 
					id="'.$this->name.'" />';
				$sx .= $this->value;
				$sx .= '</textarea>';
				$sx .= $this->requerido();
				return($sx);
			}

		/***
		 * TOKEN
		 */	
		function type_TOKEN()
			{
				$this->keyid_form();
				$sx = '
				<input 
					type="hidden" name="'.$this->name.'" 
					value="'.$this->keyid().'" id="'.$this->name.'" />
				';
				
				$sx .= '
				<input 
					type="hidden" name="tk'.$this->key_form.'" 
					value="'.$this->key_form_check.'" />
				';				
				return($sx);
			}
		/***
		 * Hidden
		 */	
		function type_U()
			{
				$sx = '
				<input 
					type="hidden" name="'.$this->name.'" 
					value="'.date("Ymd").'" id="'.$this->name.'" />';
				return($sx);
			}			
		/***
		 * Estado
		 */
		function type_UF()
			{
				global $LANG;

				$estados = array("99"=>"Outside Brazil","AC"=>"Acre","AL"=>"Alagoas","AM"=>"Amazonas","AP"=>"Amapï¿½",
					"BA"=>"Bahia","CE"=>"Ceara","DF"=>"Distrito Federal","ES"=>"Espirito Santo",
					"GO"=>"Goias","MA"=>"Maranhï¿½o","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul",
					"MG"=>"Minas Gerais","PA"=>"Parï¿½","PB"=>"Paraiba","PR"=>"Parana",
					"PE"=>"Pernambuco","PI"=>"Piaui","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte",
					"RO"=>"Rondonia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina",
					"SE"=>"Sergipe","SP"=>"Sao Paulo","TO"=>"Tocantins");

				$opt = '<option value="">'.msg('select_state').'</option>';
				foreach (array_keys($estados) as $key=>$value) {
					$check = '';
					$opv = $value;
					$opd = $estados[$opv];
					if ($this->value == $opv) { $check = 'selected'; }
					$opt .= chr(13);
					$opt .= '			<option value="'.$opv.'" '.$check.'>';
					$opt .= $opd;
					$opt .= '</option>';
					}				
				$sx = '
				<select name="'.$this->name.'" id="'.$this->name.'" size="1" '.$this->class.'>
					'.$this->class.' 
					id="'.$this->name.'" >';
				$sx .= $opt.chr(13);
				$sx .= '</select>';
				
				return($sx);

			}
		function requerido()
			{
				$sx = '';
				if (($this->required == 1) and ($this->required_message == 1))
					{
						if (strlen($this->value) == 0 )
						{ 
							$sx .= '<div style="color: red">'.msg('field_requered').'</div>'.chr(13);
						}
						
					}
				return($sx);
			}

		function _cp_get_params($cp)
			{
				return isset($cp[$this->indiceParams]) ? $cp[$this->indiceParams] : array();
			}

		/**
		 * PRIVADO: Helper para type_ARV
		 * @param  array   $arvore       	   uma ï¿½rvore no formato ($chv, $nome, $filhos)
		 * @param  array   $chavesSelecionadas Chaves que serï¿½o selecionadas na inicializaï¿½ï¿½o
		 * @param  boolean $expandirRaiz 	   Expande a visualizaï¿½ï¿½o da raiz por padrï¿½o
		 * @return string                	   a ï¿½rvore expandida no formato esperado pelo dynatree
		 */
		function _type_ARV_expande_arvore($arvore, $tokenSepFormArvore, $expandirRaiz=true)
			{
				if(!$arvore) { return ''; }
				list($chv, $nome, $filhos) = $arvore;
				if(strpos($chv, $tokenSepFormArvore) !== false){
					die("ERRO: Chave invalida por contem separador de chaves: $chv");
				}
				if(!is_array($filhos) && !$filhos) { $filhos = array(); }
				$strFilhos = "children: [";
				foreach($filhos as $filho){
					$strFilhos .= "\t".$this->_type_ARV_expande_arvore($filho, $tokenSepFormArvore, false)."\n";
				}
				$strFilhos .= "]";
				$strExpandir = $expandirRaiz ? 'true' : 'false';
				$saida = "{title: '$nome', key: '$chv', expand: $strExpandir, isFolder: ".($filhos ? "true, $strFilhos" : "false")."},\n";
				return $saida;
			}
		/**
		 * arvore com checkboxes para seleção
		 * Aqui usando o dynatree: http://code.google.com/p/dynatree/
		 * @param  array $arvore uma arvore no formato ($chv, $nome, $filhos)
		 * @return string  html/js de uma ï¿½rvore com checkboxes selecionï¿½veis
		 */
		function type_ARV($arvore, $tokenSepFormArvore='%%')
			{
				assert($arvore);
				$arvoreExemplo = array('chaveRaiz', 'Natureza', array(
									array(0,'Aranha',false),
									array(1,'Mamíferos', array(
											array(0, 'Coala', false),
											array(1, 'Leão', false),
										)),
								));
			    $sel = '
			  	  	<!-- Add code to initialize the tree when the document is loaded: -->
					<link href="css/dynatree/ui.dynatree.css" rel="stylesheet" type="text/css" id="skinSheet">

				    <script type="text/javascript">
				    $(function(){
				        // Attach the dynatree widget to an existing <div id="tree"> element
				        // and pass the tree options as an argument to the dynatree() function:
				        $("#'.$this->name.'-tree").dynatree({
				        	checkbox: true,
				        	selectMode: 3,
				            onActivate: function(node) {
				                // A DynaTreeNode object is passed to the activation handler
				                // Note: we also get this event, if persistence is on, and the page is reloaded.
				                // alert("You activated " + node.data.title);
				            },
				            persist: false,
				            children: [ // Pass an array of nodes.
								'.$this->_type_ARV_expande_arvore($arvore, $tokenSepFormArvore).'
				            ]
				       });
				';

				// Persistï¿½ncia de seleï¿½ï¿½o (entre POSTs, etc.)
				$sel .= "
						preSelecionar = {}; ";
				if($this->value){
					$chavesSelecionadas = 'preSelecionar[\''.implode('\'] = preSelecionar[\'', explode($tokenSepFormArvore, $this->value)).'\'] = true;'."\n";
					$sel .= $chavesSelecionadas;
				}

				$sel .='
						$("#'.$this->name.'-tree").dynatree("getRoot").visit(function(node){
					        if(preSelecionar[node.data.key]) { node.select(true); }
					    });
				    });
				    </script>
				    <div id="'.$this->name.'-tree" style="width: 93%;"> </div>
				    <input type="hidden" id="'.$this->name.'" name="'.$this->name.'" />
    			';

    			$this->jsOnSubmit .= '
	    			var tree = $("#'.$this->name.'-tree").dynatree("getTree");
	      			selRootNodes = tree.getSelectedNodes(true);
	      			var selRootKeys = $.map(selRootNodes, function(node){
			          return node.data.key;
			        });

    				$("#'.$this->name.'").val(selRootKeys.join("'.$tokenSepFormArvore.'"));    				
    			'; 

				return $sel;
			}

		/**
		 * Campo de Rich Text
		 * TinyMCE: http://www.tinymce.com
		 * @return string html/js de um campo com controles de texto rico
		 */
		function type_R()
			{
				$ops = splitx('&',$this->par);
				for ($r=0;$r < count($ops);$r++)
					{
						$so = $ops[$r];
						$check = '';
						
						$vl = substr($so,0,strpos($so,':'));
						if (trim($this->value)==trim($vl) ) { $check = 'checked'; }
						$sx .= '<input type="radio" value="'.$vl.'" '.$check.' ';
						$sx .= ' id="'.$this->name.'" name="'.$this->name.'" ';
						if (strlen(trim($this->class_select_option)) > 0) 
							{ $sx .= ' class="'.$this->class_select_option.'"'; }
						$sx .= '>';
						//$sx .= $ops[$r];
						$txt = trim(substr($so,strpos($so,':')+1,strlen($so)));
						if (substr($txt,0,1) == '#')
							{ $txt = msg($txt); }
						$sx .= $txt;
					}
				return($sx);
				
			}


		/**
		 * Campo de Rich Text
		 * TinyMCE: http://www.tinymce.com
		 * @return string html/js de um campo com controles de texto rico
		 */
		function type_RT()
			{
				$conteudo = $this->value;

				if($this->geradorCampoRichText === 'tinymce'){
					$conteudo = htmlspecialchars($this->value, ENT_QUOTES);
					$height = 400;
					return '
						<script type="text/javascript">
						tinymce.init({
						    selector: "textarea.tinymce_'.$this->name.'",
						    language: "pt_BR",
						    menubar: false,
						    statusbar: false,
						    plugins: "textcolor paste link",
						    height: '.$height.',
						    toolbar: "bold italic underline | alignleft aligncenter alignright | bullist | forecolor | link | formatselect fontsizeselect | removeformat",
						    
						    paste_text_sticky_default: true,
						    paste_text_sticky: true,

						    valid_elements: "a[href],p[style],b[style],i[style],u[style],del[style],h1[style],h2[style],h3[style],h4[style],h5[style],h6[style],ul,li,br,span[style]",

						    formats: {
						        bold : {inline : "b" },  
						        italic : {inline : "i" },
						        underline : {inline : "u"},
						        strikethrough: {inline: "del"},
						        
						    },
						 });
						</script>

						<div style="width: 93%;">
							<textarea name="'.$this->name.'" id="'.$this->name.'" class="tinymce_'.$this->name.'" style="height:'.($height+35).'px; min-width:700px">'.$conteudo.'</textarea>
						</div>
					';
				}

				die('Tipo de gerador de campo nao suportado: '.$this->geradorCampoRichText);
			}

		/**
		 * Campo de seleï¿½ï¿½o de tags com autocomplete
		 * http://jqueryui.com/autocomplete/#multiple-remote
		 * @param  string $fonteDados    -Se for uma string, ï¿½ tradada como uma URL que retorna uma lista de dados
		 *                                 no formato JSON (objetos com atributos 'label' e 'value')
		 *                               -Se for um array, ï¿½ tratada como uma lista de tags 
		 * @return string                Um campo com autocomplete
		 */
		function type_ATAGS($fonteDados)
			{
				if(is_array($fonteDados)){
					foreach($fonteDados as $tag){
						if(!preg_match('/^[#_a-z][_a-z0-9]*$/', $tag)){
							die('ERRO type_ATAGS(): Apenas tags alfanumï¿½ricas minï¿½sculas (sem acentos) comeï¿½adas com uma letra ou cerquilha (#) sï¿½o suportadas.');
						}
					}
					if(count($fonteDados) == 0){ $jsTags = '[]'; }
					else{ $jsTags = '["'.implode('", "', $fonteDados).'"]'; }

					$jsAutocompleteSource = '
						function( request, response ) {
							var availableTags = '.$jsTags.';
							// delegate back to autocomplete, but extract the last term
							response( $.ui.autocomplete.filter(
								availableTags, extractLast( request.term ) ) );
						}
					';
				}
				elseif(is_string($fonteDados) && preg_match('/^[^ ]+$/', strtolower($fonteDados))){
					//XXX nï¿½o testado!
					$jsAutocompleteSource = '
						function( request, response ) {
							$.getJSON( "'.$fonteDados.'", {
								term: extractLast( request.term )
							}, response );
						}
					';
				}
				else{
					var_dump($fonteDados);	
					die('ERRO type_ATAGS(): Fonte de dados invï¿½lida, vazia ou nï¿½o suportada.');
				}

				return '
					  <script>

						$(function() {
							function split( val ) {
								return val.split( /,\s*/ );
							}
							function extractLast( term ) {
								return split( term ).pop();
							}

							$( "#'.$this->name.'" )
								// don\'t navigate away from the field on tab when selecting an item
								.bind( "keydown", function( event ) {
									if ( event.keyCode === $.ui.keyCode.TAB &&
											$( this ).data( "ui-autocomplete" ).menu.active ) {
										event.preventDefault();
									}
								})
								.autocomplete({
									source: '.$jsAutocompleteSource.'
									,
									search: function() {
										// custom minLength
										var term = extractLast( this.value );
										if ( term.length < 2 ) {
											return false;
										}
									},
									focus: function() {
										// prevent value inserted on focus
										return false;
									},
									select: function( event, ui ) {
										var terms = split( this.value );
										// remove the current input
										terms.pop();
										// add the selected item
										terms.push( ui.item.value );
										// add placeholder to get the comma-and-space at the end
										terms.push( "" );
										this.value = terms.join( ", " );
										return false;
									}
								});
						});	
					  </script>
					<input 
						id="'.$this->name.'" 
						name="'.$this->name.'" 
						value="'.$this->value.'" 
						size="'.$this->size.'"
						'.($this->size > 70 ? 'style="width: 90%;"' : '').'
					>
				';
				//return '<input id="'.$this->name.'" type="text" style="width: 90%;" size="70" maxlength="120" value="'.$this->value.'" name="'.$this->name.'"></input>';
			}	
	}
?>