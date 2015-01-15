<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Menus
*/
///////////////////////////////////////////
// Versão atual           //    data     //
//---------------------------------------//
// 0.0b                       21/12/2010 //
// 0.0a                       21/10/2009 //
///////////////////////////////////////////
$offset = 0;
if ($mostar_versao == True) { array_push($sis_versao,array("sisDOC (Menus)","0.0b",20101221)); }
if (strlen($include) == 0) { exit; }
//	array_push($menu,array('Edital','Edital Geral','pibic_edital_geral.php')); 
?>
<style>
.menu_tit {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	text-decoration: none;
}

.menu_li {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	color: #303030;
	line-height: 22px;
}

.menu_li a {
	text-decoration: none;
	color: Blue;
}

.menu_li a:hover { text-decoration: underline; color: Navy;  }
</style>
<?php

function menus($menu,$tipo)
	{
	global $acao,$dd,$tab_max,$uploaddir,$include;
	
///////////////////////////////////////////////////// redirecionamento
if ((isset($dd[1])) and (strlen($dd[1]) > 0))
	{
	$col=0;
	for ($k=0;$k <= count($menu);$k++)
		{
		 if ($dd[1]==CharE($menu[$k][1])) {	header("Location: ".$menu[$k][2]); } 
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	/////////////////////////////////// Tipo 1
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 	
	if ($tipo == '1')
		{
			?>
			<TABLE width="<?php echo $tab_max;?>" align="center" border="0">
			<TR><TD colspan="4">
				<FONT class="lt3">
				</FONT><FORM method="post" action="">
				</TD></TR>
			</TABLE>
			<TABLE width="<?php echo $tab_max;?>" align="center" border="0">
			<TR>
			<?php
				$xcol=0;
				$seto = "X";
				for ($x=0;$x <= count($menu); $x++)
					{
					if (isset($menu[$x][2]))
						{
							{
							$xseto = $menu[$x][0];
							if (!($seto == $xseto))
								{
								echo '<TR><TD colspan="10">';
								echo '<TABLE width="100%" cellpadding="0" cellspacing="0">';
								echo '<TR><TD class="lt3" width="1%"><BR><NOBR><B><font color="#0000a0">'.$xseto.'&nbsp;</TD>';
								echo '<TD><HR width="100%" size="2"></TD></TR>';
								echo '</TABLE>';
								echo '<TR class="lt3">';
								$seto = $xseto;
								$xcol=0;
								}
							}
						if ($xcol >= 3) { echo '<TR><TD><img src="'.$img_dir.'nada.gif" width="1" height="5" alt="" border="0"></TD><TR>'; $xcol=0; }
						echo '<TD align="center">';
						echo '<input type="submit" name="dd1" value="'.CharE($menu[$x][1]).'" '.$estilo_admin.'>';
						echo '</TD>';
						$xcol = $xcol + 1;
						}
					}
			?>
			</TABLE></FORM>		
			<?php
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	/////////////////////////////////// Tipo 2
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 	
	if ($tipo == '2')
		{
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	/////////////////////////////////// Tipo 3
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 	
	if ($tipo == '3')
		{
		$tps = 0;
		$seto = '';
		for ($x=0;$x <= count($menu); $x++)
			{
			$xseto = $menu[$x][0];
			if (!($seto == $xseto)) { $tps++; $seto = $xseto; }
			}
		/////////////////////////////////			
		$col = 0;
		$cola = 0;
		$mcol = intval($tps/2);
		$cm1 = '';
		$cm2 = '';
		$seto = 'x';
		for ($x=0;$x <= count($menu); $x++)
				{
				$xseto = $menu[$x][0];
				if (!($seto == $xseto))
					{
					$cola++;
					if ($cola > $mcol) { $col = 1; }
					$seto = lowercasesql($xseto);
					$seto = troca($seto,' ','_');
					$img_icone = 'img/icone_'.$seto.'.png';
					$updir = $_SERVER['SCRIPT_FILENAME'];
					$xx = strlen($updir);
					while ($xx > 0)
						{
						if (substr($updir,$xx,1) == '/') 
							{ $updir = substr($updir,0,$xx); $xx = 0; }
						$xx--;
						}
					$image = trim($updir) . '/'.$img_icone;

					if (!(file_exists($image)))
						{ 	$img_icone = $include.'img/icone_noimage.png'; 	}
						
					////////////////////////////////////////////
					$sc = '<TR><TD colspan="10">';
					$sc .= '<TABLE width="100%" cellpadding="0" cellspacing="2" border="0"  class="menu_tit">';
					$sc .= '<TR><TD rowspan="2" width="48"><img src="'.$img_icone.'" width="48" height="48" alt=""></TD>';
					$sc .= '<TD width="80%"><BR><NOBR><B>'.$xseto.'&nbsp;</TD>';
					$sc .= '<TR><TD><HR width="100%" size="2"></TD></TR>';
					$sc .= '</TABLE>';
					$sc .= '<TR class="lt1"><TD><UL>';
					$seto = $xseto;
					$xcol=0;
					} else  { $sc = ''; }
				if (isset($menu[$x][2]))		
					{ 
					$link = '<A href="'.$menu[$x][2].'" class="menu_item">';
					if (strlen(trim($menu[$x][2])) == 0) { $link = ''; }
					$pre = ''; $pos = '';
					
					//////////////////////////////////////////////////////////////////////////// Título Em BOld
					if ((substr($menu[$x][1],0,2) != '__') and (strlen($link) == 0))
						{ $menu[$x][1] = '<B>'.$menu[$x][1].'</B>'; }
					
					if (substr($menu[$x][1],0,2) == '__')
						{ $menu[$x][1] = substr($menu[$x][1],2,100); $pre = '<UL>'; $pos = '</UL>'; }
					if ($col == 0)
						{
							$cm1 .= $sc;
							$cm1 .= $pre.'<LI class="menu_li">'.$link.$menu[$x][1].'</A><BR>'.$pos; 
						} else {
							$cm2 .= $sc;
							$cm2 .= $pre.'<LI class="menu_li">'.$link.$menu[$x][1].'</A><BR>'.$pos; 
						}
					}
				}
		
		$sm = '<TABLE width="'.$tab_max.'" border=0 align="center">';
		$sm .= '<TR valign="top">';
		$sm .= '<TD width="48%"><table width="100%">'.$cm1.'</table></TD>';
		$sm .= '<TD width="4%"></TD>';
		$sm .= '<TD width="48%"><table width="100%">'.$cm2.'</table></TD>';
		$sm .= '</TR>';
		$sm .= '</TABLE>';
		echo $sm;
		}		
	}
?>
