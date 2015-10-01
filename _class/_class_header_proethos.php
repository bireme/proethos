<?php
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
 * Header Fz
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v.0.14.21
 * @package _class
 * @subpackage _class_header_proethos.php
 */

class header {
	var $charcod = "UTF-8";
	/* var $charcod = "ISO-8859-1"; */

	/* Google Ids */
	var $google_id = '';
	/* Ex: UA-12712904-10 */
	var $login_api = '';

	/* About this site */
	var $title = ':: ProEthos ::';
	var $description = '';
	var $http = '';
	var $path = '';
	
	var $email = '';
	var $email_type = '';
	var $email_name = '';
	var $email_smtp = '';
	var $email_replay = '';
	
	var $prefix='';
	
	function load_committe()
		{
			$sql = "select * from _committee";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->email = trim($line['cm_admin_email']);
					$this->email_user = trim($line['cm_admin_email']);
					$this->email_type = trim($line['cm_admin_email_tipo']);
					$this->email_pass = trim($line['cm_admin_email_pass']);
					$this->email_smtp = trim($line['cm_admin_email_smtp']);
					$this->email_name = $line['cm_name'];
					$this->email_replay = $line['cm_email_replay'];
					$this->site = $line['cm_site'];
					$this->prefix = trim($line['cm_committe']);
				}
		}

	function change_language() {
		global $LANG;
		//$sel = 'selected';
		$lang_name = array('English', 'Espa&ntilde;ol', 'Fran&ccedil;ais', 'Português');
		$lang_code = array('en_US', 'es', 'fr', 'pt_BR');
		$sx = '
			<!-- begin language switcher -->
    			<div id="LanguageSwitcher">
					<form action="#">
					<select id="LanguageSwitcher">';
		for ($r = 0; $r < count($lang_name); $r++) {
			if ($LANG == $lang_code[$r]) { $sel = 'selected'; } else { $sel = ''; }
			$sx .= '<option value="' . $lang_code[$r] . '" ' . $sel . '>' . $lang_name[$r] . '</option>';
		}
		$sx .= '</select></form>
			</div>
			<script type="text/javascript" src="js/proethos-select-language.js"></script>
			<!-- end language switcher -->
			';
		return ($sx);
	}

	function mount_button($name, $link) {
		$cr = chr(13) . chr(10);
		$link = '<A HREF="' . $link . '"  class="topmenu"><nobr>';
		$sx = '';
		$sx .= '<TD width="5" class="topcab_cell" >' . $link . $name . '</A></td>';
		$sx .= $cr;
		return ($sx);
	}

	function foot() {
		global $LANG;
		
		//$sx = msg('copyright');

		switch ($LANG)
			{
			case 'en_US':
				$sx = '&copy; Pan American Health Organization, 2013. All rights reserved.';
				break;
			case 'es':
				$sx = '&copy; Organización Panamericana de la Salud, 2013. Todos los derechos reservados.';
				break;
			case 'pt_BR':
				$sx = '&copy; Pan American Health Organization, 2013. All rights reserved.';
				break;
			case 'fr':
				$sx = '&copy; Pan American Health Organization, 2013. All rights reserved.';
				break;
			default:
				$sx = '&copy; Pan American Health Organization, 2013. All rights reserved.';
				break;
			}
			$sx = '<I>'.$sx.'</I>';		
		return ($sx.$sh);
	}

	function head() {
		global $LANG, $http, $style_add, $js_add,$include;
		$cr = chr(13) . chr(10);
		$pth = $this -> path;

		$sx = '<head>' . $cr;
		$sx .= '<META HTTP-EQUIV=Refresh CONTENT="3600; URL=' . $http . 'logout.php">' . $cr;

		/* Cache Control */
		$sx .= '<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">'.$cr;
		$sx .= '<meta http-equiv="expires" content="date">'.$cr;
		
		/* Charset */
		header('Content-type: text/html; charset=' . $this -> charcod);
		$sx .= '<meta http-equiv="Content-Type" content="text/html; charset=' . $this -> charcod . '" />';

		/* Meta Information */
		$sx .= '<meta name="description" content="' . $this -> description . '">' . $cr;
		$sx .= '<link rel="shortcut icon" type="image/x-icon" href="' . $http . 'favicon.ico" />' . $cr;

		/* Add Style File */
		$style = array('proethos_form.css', 'proethos_style.css', 'proethos_cabmenu_styles.css', 'proethos_style.css', 'proethos_main.css', 'font_roboto.css', 'google_css.css','proethos_print.css');
		for ($r = 0; $r < count($style); $r++) { $sx .= '<link rel="STYLESHEET" type="text/css" href="' . $http . 'css/' . $style[$r] . '">' . $cr;
		}

		/* Style Additional */
		if (is_array($style_add)) {
			for ($r = 0; $r < count($style_add); $r++) { $sx .= '<link rel="STYLESHEET" type="text/css" href="' . $http . 'css/' . $style_add[$r] . '">' . $cr;
			}
		}

		/* Add Java script */
		$js = array('jquery.js','jquery.maskmoney.js','windows.js');
		for ($r = 0; $r < count($js); $r++) 
			{ $sx .= '<script type="text/javascript" src="' . $http . 'js/' . $js[$r] . '"></script>' . $cr;
		}

		/* Style Additional */
		if (is_array($js_add)) {
			for ($r = 0; $r < count($js_add); $r++) { $sx .= '<script type="text/javascript" src="' . $http . 'js/' . $js_add[$r] . '"></script>' . $cr;
			}
		}

		$sx .= '<title>' . $this -> title . '</title>' . $cr;
		$sx .= '</head>';

		return ($sx);
	}

	function cab_extend() {
		$sx .= '<div>';
		$sx .= '</div>';
		return ($sx);
	}

	function cab() {
		$sx = $this -> head();
		$sx .= $this -> api_google;
		return ($sx);
	}

	/* Necessita de um site que gere RSS (ex. Flick)
	 * */
	function banner($url_rss = '', $width = 200, $height = 200) {
		$sx = '
		<script src="//www.google.com/jsapi" type="text/javascript"></script>
    	<script src="//www.google.com/uds/solutions/slideshow/gfslideshow.js"
            type="text/javascript"></script>
		
		<script>
		
		 google.load("feeds", "1");
	    
		    function OnLoad() {
		      var feed  = "' . $url_rss . '";
		      var options = {
		        displayTime:500,
		        transistionTime:200,
		        scaleImages:true,
		        fullControlPanel : true
		      };
		      var ss = new GFslideShow(feed, "picasaSlideshow", options);
		    }
		    
		    google.setOnLoadCallback(OnLoad);
			</script>
	';
		$sx .= '<div id="picasaSlideshow" class="gslideshow" style=" width:  ' . $width . 'px;
        height: ' . $height . 'px;"><div class="feed-loading">Loading...</div></div>';
		return ($sx);
	}

	function retornar_para_pagina_principal() {
		global $cr;
		$sx = '<script>';
		$sx .= 'opener.location.reload();';
		$sx .= 'window.close();';
		$sx .= '</script>';
		echo $sx;
		return (true);
	}

	function cab_banner($conteudo = '') {
		$sx = '<div class="cab_banner"><table><tr><td width="15%">' . $this -> short() . '</td><td  width="85%">' . $conteudo . '</td><td>' . $this -> home() . '</td></tr></table></div>';
		return ($sx);
	}

	function home() {
		global $http;
		$sx = '<a href="' . $http . 'pre_cadastro/pre_cadA.php" ><img src="' . $http . 'img/home.png" height="75"></a>';
		return ($sx);
	}

	function show($tela = '') {
		$sx = '';
		$sx .= '<div class="balloon" id="onkey" style="z-index:1000;">';
		$sx .= '<div class="arrow"></div>';
		$sx .= $tela;
		$sx .= '</div>';
		return ($sx);
	}

	function short() {
		global $user, $perfil, $http;

		$sx .= '<div id="shortkey" class="left">';
		$sx .= '<img src="' . $http . 'img/icone_shortcut.png" height="75" border=0 align="left" alt="atalho de acesso" title="atalho de acesso">';
		$sx .= '</div>' . chr(13);

		$basic = $this -> menus_basic();
		$basic = 'Sistemas<BR>' . $basic . '<BR>';

		$cab = '<table width="99%" border=0><TR valign="top">';
		$foot = '</table>';

		$sx .= $this -> show($cab . '<td align="left">' . $basic . '</td></tr></table>');
		$sx .= '
			<script language="JavaScript" src="../js/shortcut.js"></script>
			<script>
					$("#shortkey").click(function() {
						var lf = $("#onkey").offset().left;
						if (lf > 0) 
							{ lp = "-900px"; } 
							else 
							{ lp = "50px"; }			
						$("#onkey").animate({ left: lp });
					});
					</script>
			';
		$sx .= '<script>
					shortcut.add("CTRL+0", function() {
						var lf = $("#onkey").offset().left;
						if (lf > 0) 
							{ lp = "-900px"; } 
							else 
							{ lp = "50px"; }			
						$("#onkey").animate({ left: lp });
					});
					</script>';
		return ($sx);
	}

	function menus_basic() {
		global $http;
		$link = array('', '', '', '', '', '', '', '', '', '');
		$title = array('teste1', 'teste2', 'teste3', 'teste4');
		$link = array($http . 'pre_cadastro/pre_cadA.php', $http . 'pre_cadastro/pre_cadB.php', $http . 'pre_cadastro/pre_cadC.php', $http . 'pre_cadastro/pre_cadD.php');
		for ($r = 0; $r < count($title); $r++) {
			$xlink = trim($link[$r]);
			$xlinka = '';
			if (strlen($xlink) > 0) {
				$xlink = '<A HREF="' . $link[$r] . '">';
				$xlinka = '</A>';
			}
			$sx .= $xlink;
			$sx .= ' <img src="' . $http . 'img/icone_fz_basic' . $r . 'a.png" height="45" border=0 
							onmouseover="$(this).attr(\'src\',\'' . $http . 'img/icone_fz_basic' . $r . '.png\');" 
							onmouseout="$(this).attr(\'src\',\'' . $http . 'img/icone_fz_basic' . $r . 'a.png\');"
							title = "' . $title[$r] . '"
							>';
			$sx .= $xlinka;
		}

		return ($sx);

	}

}
?>