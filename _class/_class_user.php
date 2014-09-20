<?php
 /**
  * User
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v0.12.07
  * @package Class
  * @subpackage user
 */
class users
	{
		var $id;
		var $login;
		var $name;
		var $perfil;
		var $codigo;
		var $ghost_original;
		var $ghost_mode=0;
		
		var $usuario_tabela = 'usuario';
		var $usuario_tabela_login = 'us_login';
		var $usuario_tabela_pass = 'us_senha';
		var $usuario_tabela_nome = 'us_nome';
		var $usuario_tabela_nivel = 'us_nivel';
		var $usuario_tabela_id = 'id_us';
		var $usuario_tabela_email = 'us_email';
		var $usuario_tabela_codigo = 'us_codigo';
		var $senha_md5 = 1;
	
		var $tabela = 'usuario';
		
    /**
     * Liberar Usuario
     * @return Booblean
     */
     	function show_user_name()
			{
			/* Parametros default */
			global $hd;
			$msg = 'logout'; $page = 'logout.php';
			$link_usr = '';
					
			/* Modo Ghost */
			$ghost = $this->user_ghost;
			if (strlen($ghost) > 0) 
				{
				/* Ghost Mode */
					$link_usr = '<A HREF="admin_ghost_user_sel.php?dd1=1&dd0='.$ghost.'&dd90='.checkpost($ghost).'"
				 				class="user_ghost" 
				 				title="logout ghost mode"
				 				>';
					$sx .= '<TD width="*" align="right"><NOBR>'.$link_usr.$this->user_nome.'</A></TD>'.chr(13).chr(10);
					//$sx .= '<TD><nobr>&nbsp;&nbsp;</nobr></TD>'.chr(13).chr(10);								
				} else {
				/* Normal Mode */
					$sx .= '	<TD width="*" align="right"><NOBR>'.$this->shortname($this->user_nome).'</nobr></TD>'.chr(13).chr(10);
					$sx .= '	<TD><nobr>&nbsp;&nbsp;</nobr></TD>'.chr(13).chr(10);
					$sx .= '	'.$hd->mount_button(msg($msg), $page).chr(13).chr(10);
				}
				return($sx);			
			}
		function shortname($nome)
			{
				$nome_full = $nome.chr(13);
				$nome_full .= $this->user_email;
				$nome = substr($nome,0,20);
				$ok = 1;
				while ((strlen($nome) > 0) and ($ok == 1))
					{
						$ch = substr($nome,strlen($nome)-1,1);
						if ($ch==' ') { $ok = 0; }
						
						$nome = substr($nome,0,strlen($nome)-1);
					}
				$nome = '<span title="'.$nome_full.'");">'.$nome.'</span>';
				return($nome);
			}
     	function set_user_original()
		{
			$this->ghost_original = $this->user_id;		
		}
     	function reset_user_original()
		{
			$this->ghost_original = '';		
		}
		     
     	function set_ghost()
		{
			$this->ghost_mode = 1;		
		}
     	function reset_ghost()
		{
			$this->ghost_mode = '';
			$this->user_ghost = '';		
		}	
		
		function show_ativo($id)
			{
				$sx = $id;
				//us_ativo
				return($sx);
			}	
		
    	function le($id=0,$cracha='xxx')
		{
			$sql = "select * from ".$this->tabela." 
				where ".$this->usuario_tabela_id." = ".round($id)."
				or ".$this->usuario_tabela_codigo." = '".$cracha."' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->id = $line[$this->usuario_tabela_id];
					$this->login = trim($line[$this->usuario_tabela_login]);
					$this->name = trim($line[$this->usuario_tabela_nome]);
					$this->codigo = trim($line[$this->usuario_tabela_codigo]);
					$this->perfil = trim($line['us_perfil']);
					$this->line = $line;	
					if (strlen(trim($this->login))==0)
						{ $this->login = $this->codigo;	}
					
					return(1);
				}
			
			return(0);
		}
		
		function send_pass_email($email)
		{
			global $ic;
			$sql = "select * from usuario where us_email = '".$email."' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$ref = "send_email_text";
					$ttt = $ic->ic($ref);
					$email1 = trim($line['us_email']);
					$text = $ttt['text'];
					$subj = $ttt['title'];
					$text .= '<BR><BR>Password: <B>'.$line['us_senha'].'</B>';
					enviaremail($email1,'',$subj,$text);
					echo '<BR>Send mail to '.$email1;
					$ok = 'send_email_ok';
				} else {
					$ok = 'invalid_email';
				}
			return($ok);
		}
		function show_country($country)
			{
				$sql = "select * from ajax_pais where pais_codigo = '".$country."' ";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
						return(trim($line['pais_nome']));
					}
				return('');
			}
		function mostrar()
			{
				$sx = '<fieldset>';
				$sx .= '<legend>'.msg('investigator').'</legend>';
				$sx .= '<table width="100%" class="tabela00">';
				$sx .= '<TR><TD><B>'.$this->name.'</B></td>';
				$sx .= '<TR><TD>'.mst($this->line['us_endereco']);
				$sx .= '<TD>'.($this->line['us_email']);
				$sx .= '<BR>'.($this->line['us_email_alt']);
				$sx .= '<TR><TD>'.($this->line['us_instituition']);
				
				$sx .= '<TR><TD>'.$this->show_country($this->line['us_country']);				
				
				$sx .= '</table>';
				$sx .= '</fieldset>';
				return($sx);
			}
		function ghost_user()
			{
				$this->user_login = 'active';
				$this->user_nome = $this->name.' (Ghost)';
				$this->user_nivel = 0;
				$this->user_id = $this->id;
				$this->ghost = round($this->ghost);
				$this->user_perfil = $this->perfil; 
				$this->user_codigo = $this->login;
				$this->user_erro = 1;
				$this->LiberarUsuario();
				
				return(1);				
			}
		function normal_user()
			{
				$this->user_login = 'active';
				$this->user_nome = $this->name;
				$this->user_nivel = 0;
				$this->user_id = $this->id;
				$this->ghost = round($this->ghost);
				$this->user_perfil = $this->perfil; 
				$this->user_codigo = $this->login;
				$this->user_erro = 1;
				$this->LiberarUsuario();
				
				return(1);				
			}			
		function LiberarUsuario()
			{
			global $secu,$perfil;
			if ((strlen($this->user_login) > 0) and ($this->user_erro > 0))
				{
				$_SESSION["user_login"] = $this->user_login;
				$_SESSION["user_nome"] = $this->user_nome;
				$_SESSION["user_nivel"] = $this->user_nivel;
				$_SESSION["user_id"] = $this->user_id;
				$_SESSION["user_perfil"] = $this->user_perfil;
				$_SESSION["user_codigo"] = $this->user_codigo;
				$_SESSION["user_ghost"] = $this->ghost_original;
				$_SESSION["user_chk"] = md5($this->user_login.$this->user_nome.$this->user_nivel.$secu);
				$perfil->us_codigo = $this->user_codigo;
				}
			return(True);
			}	
	
	function row()
	{
		global $tabela,$http_edit,$http_edit_para,$cdf,$cdm,$masc,$offset,$order;
		$cdf = array('id_us','us_login','us_nome','us_codigo');
		$cdm = array('ID','login','nome','codigo');
		$masc = array('','','','','','','','','');
		return(True);
	}	
		
	function login($login,$pass)
		{
		global $messa;
		$login = uppercase($login);
		
		if ((strlen($login) == 0) or (strlen($pass) == 0))
			{
				$this->user_erro = -3;
				$this->user_msg = 'login_required';
				return(-3);
			} else {
				$login = troca($login,"'","´");
				$pass = troca($pass,"'","´");
				
				$sql = "select * from ".$this->usuario_tabela;
				$sql .= " where ".$this->usuario_tabela_email." = '".LowerCase($login)."' ";
				
				$resrlt = db_query($sql);
				if ($result = db_read($resrlt))
					{
						$user_senha = trim($result[$this->usuario_tabela_pass]);
						if ($result['senha_md5'] == 1) { $pass = md5($pass); }
						if ($user_senha == $pass)
							{
								$this->user_erro = 1;
								$this->user_msg = '';				
								$this->user_login = trim($result[$this->usuario_tabela_login]);
								$this->user_nome = trim($result[$this->usuario_tabela_nome]);
								$this->user_nivel = trim($result[$this->usuario_tabela_nivel]);
								$this->user_id = trim($result[$this->usuario_tabela_id]);
								$this->user_codigo = trim($result['us_codigo']);
								$this->user_perfil = trim($result['us_perfil']);
								if (strlen($this->user_login)==0)
									{ $this->user_login = $this->user_codigo; }
								$this->ghost = 0;
								$this->LiberarUsuario();
							} else {
								$this->user_erro = -2;
								$this->user_msg = 'password_incorrect';
							}
					} else {
							$this->user_erro = -1;
							$this->user_msg = 'login_invalid';
					}
			}
			if ($this->user_erro == 1) { $this->LiberarUsuario(); return(True); } else
			{ $this->user_msg = 'login_failed'; $this->user_erro = -1; return(False); }
		}		
    /**
     * Limpar dados do Usuario
     * @return Booblean
     */			
		function LimparUsuario()
			{
			global $secu;
			if ((strlen($this->user_login) > 0) and ($this->user_erro > 0))
				{
				$_SESSION["user_login"] = '';
				$_SESSION["user_nome"] = '';
				$_SESSION["user_nivel"] = '';
				$_SESSION["user_chk"] = '';
				$_SESSION["user_id"] = '';
				$_SESSION["user_ghost"] = '';
				}
			return(True);
			}		
		
		function security()
			{
			global $secu,$user_login,$user_nivel,$user_nome,$user_id;
			
			$md5 = trim($_SESSION["user_chk"]);
			$nm1 = trim($_SESSION['user_login']);
			$nm2 = trim($_SESSION['user_nome']);
			$nm3 = trim($_SESSION['user_nivel']);
			$nm6 = trim($_SESSION['user_id']);
			$nm7 = trim($_SESSION['user_perfil']);
			$nm8 = trim($_SESSION['user_codigo']);
			$nm9 = trim($_SESSION['user_ghost']);
			$mt1 = 10;
			$mm4 = md5($nm1.$nm2.$nm3.$secu);
			
			if ((strlen($nm1) > 0) and (strlen($nm8) > 0))
				{
				if (trim($mm4) == trim($md5))
					{
						$this->user_login = $nm1;
						$this->user_nome = $nm2;
						$this->user_nivel = $nm3;
						$this->user_id = $nm6;
						$this->user_erro = $mt1;
						$this->user_perfil = $nm7;
						$this->user_codigo = $nm8;
						$this->user_ghost = $nm9;
						$user_id = $nm6;
						$user_login = $nm1;
						$user_nivel = $nm3;
						$user_nome = $nm2;
						
					return(True);
					} else {
						$this->user_erro = -4;
						$this->user_msg = 'End section';
						return(False);
					}
				} else {
						$this->user_erro = -5;
						$this->user_msg = 'End section';
						return(False);
				}
			}		
		
		function cp()
			{
				global $messa,$dd;
				$cp = array();
				if (strlen($dd[1]) == 0) { $dd[1] = '#RES'; }
				array_push($cp,array('$H8','','',False,True));
				array_push($cp,array('$H8','','Validador',True,True));
				
				array_push($cp,array('$A','',msg('about_user'),False,True));
				
				array_push($cp,array('$S100','us_nome',msg('name'),True,True));
				array_push($cp,array('$H20','us_login',$logx,False,True));
				array_push($cp,array('$S100','us_email',msg('email'),True,True));
				array_push($cp,array('$M','','',False,False));
				array_push($cp,array('$S100','us_email_alt',msg('email_alt'),False,True));
				array_push($cp,array('$P20','us_senha',msg('senha'),True,True));
				//array_push($cp,array('$}','','',False,True));
				array_push($cp,array('$HV','us_ativo','-1',True,True));
				array_push($cp,array('$A','',msg('academic_information'),False,True));
				array_push($cp,array('$S100','us_instituition',msg('institution_affiliated'),True,True));
				//array_push($cp,array('$}','','',False,True));
				
				array_push($cp,array('$T60:5','us_endereco',msg('address'),False,True));
				array_push($cp,array('$Q pais_nome:pais_codigo:select * from ajax_pais order by pais_nome','us_country',msg('country'),True,True));				

				array_push($cp,array('$U8','us_cadastro','',False,True));

				array_push($cp,array('$HV','us_perfil','',False,True));
				
				array_push($cp,array('$B8','',msg('submit'),False,True));
								
				return($cp);
				
			}
		function cp_myaccount()
			{
				global $messa;
				$cp = array();				
				array_push($cp,array('$H8','id_us','',False,True));
				array_push($cp,array('$S100','us_nome',msg('name'),True,True));
				array_push($cp,array('$H20','us_login',msg('login'),True,True));
				array_push($cp,array('$S100','us_email',msg('email'),True,True));
				array_push($cp,array('$S100','us_email_alt',msg('email_alt'),False,True));
				array_push($cp,array('$P20','us_senha',msg('senha'),True,True));
				array_push($cp,array('$HV','us_ativo','1',True,True));
				array_push($cp,array('$T60:5','us_endereco',msg('address'),True,True));
				array_push($cp,array('$Q pais_nome:pais_codigo:select * from ajax_pais order by pais_nome','us_country',msg('country'),True,True));
				array_push($cp,array('$S100','us_instituition',msg('institution'),True,True));
				return($cp);
			}	
		function cp_admin()
			{
				global $messa;
				$cp = array();				
				$op = '&-1:'.msg('not_valided');
				$op .= '&0:'.msg('inative');
				$op .= '&1:'.msg('valided');
				array_push($cp,array('$H8','id_us','',False,True));
				array_push($cp,array('${','',msg('account'),False,True));
				array_push($cp,array('$S100','us_nome',msg('name'),True,True));
				array_push($cp,array('$H20','us_login',msg('login'),False,True));
				array_push($cp,array('$S100','us_email',msg('email'),True,True));
				array_push($cp,array('$S100','us_email_alt',msg('email_alt'),False,True));
				array_push($cp,array('$T60:5','us_endereco',msg('address'),False,True));
				array_push($cp,array('$S100','us_instituition',msg('institution'),True,True));
				
				array_push($cp,array('$O : '.$op,'us_ativo',msg('status'),'1',True,True));
				array_push($cp,array('$}','','',False,True));
								
				return($cp);
			}
			
		function user_valid()
			{
				$sql = "update ".$this->tabela." set  
					us_ativo = 1,
					us_email_ativo = 1,
					us_login = 'active'
					where id_us = ".$this->id;
				$rlt = db_query($sql);
				
			}
		
		function updatex()
			{
				global $base;
				$c = 'us';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 7;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) ,
						us_login =  lpad($c1,$c3,0) ,
						us_cracha =  lpad($c1,$c3,0) 
						where $c2='' or 1=1";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' or  $c2 isnull "; }
				$rlt = db_query($sql);				
			}
	}
?>

