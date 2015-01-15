<?php
    /**
     * Meeting
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage meeting
    */
class meeting
	{
		var $date;
		
		function mostra_proximas($data=19000101)
			{
				$sql = "select cep_reuniao, count(*) as total 
						from cep_protocolos 
						where cep_reuniao > ".date("Ymd")." 
						group by cep_reuniao 							 			
					order by cep_reuniao";
				
				//where cal_date >= ".date("Ymd");
				$rlt = db_query($sql);
				$sx = '<table width="100%" class="tabela00">';
				$sx .= '<TR><TH width="10%">'.msg('date').'</th>';
				$sx .= '<TH width="80%">'.msg('descript').'</th>';
				$sx .= '<TH width="10%">'.msg('projects').'</th>';
				$id = 0;
				while ($line = db_read($rlt))
					{
						$link = '<A HREF="'.page().'?dd2=8&dd1='.stodbr($line['cep_reuniao']).'&acao=show" class="link">';
						$id++;
						$sx .= '<TR>';
						$sx .= '<TD class="tabela01" align="center">';
						$sx .= $link.stodbr($line['cep_reuniao']).'</A>';
						$sx .= '<TD class="tabela01" align="left">';
						$sx .= msg('scheduled_meeting');
						//$sx .= '<TD class="tabela01" align="center">';
						//$sx .= trim($line['cal_cod']);
						$sx .= '<TD class="tabela01" align="center">';
						$prj = round($line['total']);
						if ($prj > 0)
							{ $sx .= $prj;} else { $sx .= '-'; }
						//cal_time
						//cal_description
						//cal_cod
					}
				$sx .= '</table>';
				if ($id > 0)
					{
						$sx = '<h3>'.msg('meeting').'</h3>'.$sx;
					}
				return($sx);
			}
		function show_line($line)
			{
				
			}
		function mostra($data=0,$page=6)
			{
				global $institution_name, $institution_site;
				$data = round($data);
				
				$sql = "select * from cep_protocolos
					left join usuario on cep_pesquisador = us_codigo
					where cep_reuniao = $data
					order by cep_caae , cep_data
				";
				$rlt = db_query($sql);
				
				$link = '<A href="javascript:newxy2(\'meeting_schediled_popup.php?dd1='.$data.'&dd2='.$page.'\',800,600);">';
				
				$sh = '<table bgcolor="white" class="tabela00" 
						cellpadding=0 cellspacing=0 width="100%" 
						border=0>';
				$sh .= '<TR valign="top">
						<TD colspan=1 rowspan=2 width="10%">';
				$sh .= '<img src="img/logo_dictamen.jpg" height="100">';
				$sh .= '<TD colspan=2><center><B>'.$institution_name.'</B>';
				$sh .= '<BR>'.$institution_site;
				$sh .= '</center>';
				$sh .= '<div id="icone_pr">'.$link.'<img src="img/icone_print.png" width="48" border=0></A></div>';
				$sh .= '<TR><TD>';
				$sh .= '<div class="lt0" style="text-align: right">page</div>';
				$sh .= '</table>';
				/* Dados da pauta */
				$sh .= '<table class="table_proj tabela00" width="100%" border=0>';
				$sh .= '<TR><TD colspan=4><h2><center>'.msg("scheduled_meeting").' - '.stodbr($data).'</center></h2>';
				$sh .= '<TR>
						<TH width="10%">'.msg('protocol');
				$sh .= '<TH width="80%" colspan=2>'.msg('project_title');
				$sh .= '<TH width="10%">'.msg('results');
				$sx = '';

				$tot = 99;
				$totr = 0;
				$pag = 1;
				
				while ($line = db_read($rlt))
					{
						if (($tot+1) > $page)
							{
								$tot = 0;
								if ($pag > 1)
									{
										$sx .= '</table>';
										$sx .= '<p style="page-break-before: always;"></p>';
									}
								$sx .= troca($sh,'page','p. '.$pag);
								$pag++;
							}
						$tot++;
						$totr++;
						$sx .= '<TR valign="top" class="tabela01">';
						/* NR caae */
						$sx .= '<TD rowspan=2>
								<font class="lt1"><B>'
								.$line['cep_caae'].'</B>'
								.'</font>';
						$sx .= '<BR>'.msg('version').' '.$line['cep_versao'];
						$sx .= '<BR><center><font class="lt0">'.stodbr($line['cep_data']).'</font></center>';
						/* Project title */
						$sx .= '<TD colspan=2><B>'.$line['cep_titulo'].'</B>';
						/* Decision */
						$sx .= '<TD rowspan=2 width="60"><center>'.msg('decision');
							$sx .= '<table border=1 width=80%>
									<TR><TD height="30">&nbsp;</table>';

													$sx .= '<TR>';
						$sx .= '<TD colspan=2>'.msg('investigador').': <B>'.$line['us_nome'];
						$sx .= '</B> - '.$line['us_instituition'];
						$sx .= '<BR>&nbsp;';
						
					}
				$sx .= '<TR><TD colspan=3>'.msg('found').' '.$totr.' '.msg('register');
				$sx .= '</table>';
				
				$sx .= show_logo();
				return($sx);
			}
	}
?>
