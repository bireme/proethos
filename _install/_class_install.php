<?php
    /**
     * Install DB
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.14.38
	 * @package Systema	
	 * @subpackage Install DB
    */
class install
	{
		function install_sql()
			{
				/* Verificar se existe tabela */
				$sql = "SELECT table_name FROM information_schema.tables WHERE table_name = 'apoio_titulacao'";
				$rlt = db_query($sql);
				
				/* Consulta */
				if ($line = db_read($rlt))
					{
						/* Tabelas já instaladas */
						echo 'Database already exist.';
					} else {
						$file_sql = "../proethos.sql";
						/* Le arquivo com estrutura do banco */
						$flt = fopen($file_sql,"r");
						$sql = "";
						while (!(feof($flt)))
							{
								$sql .= fread($flt,1024);
							}
						fclose($flt);
						
						$ln = splitx(';',$sql.';');
						/* Executa criacao das tabelas */
						for ($r=0;$r < count($ln);$r++)
							{
								echo '<BR>'.substr($ln[$r],0,strpos('(',$ln[$r]));
								$sql = trim($ln[$r]);
								if (strlen($sql) > 10)
									{
										$rlt = db_query($sql);
									}
							}
						echo '<BR>Database install!!';
					}
			}
		function createfile_db($file,$base,$base_host,$base_name,$base_user,$base_pass)
			{
				$cr = chr(13);

				$sx = '<?php' . $cr;
				$sx .= '/* Data Base - Config */'.$cr;
				$sx .= '$base=\''.$base.'\';'.$cr;
				$sx .= '$base_host=\''.$base_host.'\';'.$cr;
				$sx .= '$base_name=\''.$base_name.'\';'.$cr;
				$sx .= '$base_user=\''.$base_user.'\';'.$cr;
				$sx .= '$base_pass=\''.$base_pass.'\';'.$cr;
				$sx .= ''.$cr;
				$sx .= '$ok = db_connect();'.$cr;
				$sx .= '?>'.$cr;
				echo '<script>'.$cr;
				echo ' $("#config_file").fadeIn( "slow" );'.$cr;
				
				$sxs = troca($sx,'<','&lt;');
				$sxs = troca($sxs,chr(13),'<BR>');
				
				echo ' $("#config_file").html("<TT>'.$sxs.'</TT>");'.$cr;
				//echo ' $("#config_file").html("TESTE");'.$cr;
				echo 'alert("Config Finish!");';
				echo '</script>'.$cr;

				$fl = fopen($file,'w');
				fwrite($fl, $sx . $cr);
				fclose($fl);
				
				echo 'file created!';
			}
		function config_file()
			{
				$ip = $_SERVER['HTTP_HOST'];
				$ip = troca($ip,'.','_');
				$ip = troca($ip,':','_');
				$file = 'db_'.$ip.'.php';
				return($file);
			}
		function check_directory_privileges($pathname)
			{
				/* verifica e criar o diretorio se não existir */
				if (!(is_dir($pathname))) { mkdir($pathname,777);	}
				
				/* verifica se o diretorio existe */
				if (!(is_dir($pathname))) { return("ERRO #02# - Can not create a directory"); }
				chmod ($pathname, 0777);
				
				/* delete arquivo se existir */
				$file = $pathname.'/_temp.txt';
				if (file_exists($file)) { unlink($file); }
				
				/* criar arquivo */
				$flt = fopen($file,'w+');
				fwrite($flt,'**TEST**');
				fclose($flt);
				
				if (!(file_exists($file))) { return("ERRO #03# - Can not create a temp file ".$file); }
				
				/* return ok */
				return(1);
			}
	}
?>