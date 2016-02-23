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


/* Header */

/* mark active page to cabmenu */
$active_page = 'research';

/* Add Styles */
$style_add = array('proethos_form.css');

require("cab.php");
require($include.'sisdoc_tips.php');

/* Load Class */
require("_class/_class_cep_submit.php");

/* Load Includes */
require($include.'sisdoc_data.php');

require($include.'sisdoc_debug.php');

/* Load Formulario Class */
require($include.'_class_form.php');
$form = new form;
require("form_css.php");

$proj = new submit;
$proj->doc_autor_principal = $ss->user_codigo;

/** Sessao da Submissao **/
if (strlen($dd[91]) > 0)
	{
		$_SESSION['proj_page'] = $dd[91];
		redirecina('submit.php?time'.date("dmYhis"));				
	}

/* Recupera página */	
if (strlen($dd[90]) > 0)
	{
		$pag_id = 1; 
		$_SESSION['proj_id'] = $dd[0];
		$_SESSION['proj_page'] = 1;
		redirecina('submit.php?time'.date("dmYhis"));		
	} else {
		$pag_id = round($_SESSION['proj_id']);
		$pag_page = round($_SESSION['proj_page']);
	}
	
	
//if ($pag_id == 0) { $pag_page = 1; }
//if ($pag_page == 0) { $pag_page = 1; }

/* Recupera pagina da Sessao */
$pag_id = $_SESSION['proj_id'];
$pag = $_SESSION['proj_page'];

$dd[0] = $pag_id;
$protocolo = strzero($dd[0],7);

$proj->le($protocolo);
$prj= $proj->line;

/* Protocolo */
$proto_original = $protocolo;

if ($proj->doc_type == '010')
	{
		$proto_original = $proj->doc_research_main;
	}
/* Classe de Budget */
require("_class/_class_budget.php");
$bud = new budget;
$bud->protocol = $proto_original;

/* Classe de Country */
require("_class/_class_ajax_pais.php");
$country = new country;
$country->protocol = $proto_original;

/* Documents */
require("_ged_config.php");
$ged->protocol = $protocolo;
$popup=1;


	{
		/* Total de paginas do header */
		$tot_paginas = 7;
		$pag_max = 7;
		
		$doc_tipo  = trim($proj->doc_tipo);
		
		/* Regras */
		/* Se vazio troca por Projeto */
		if (strlen($doc_tipo) == 0) { $doc_tipo = 'PROJE'; }
		
		/* Se não for projeto define total de paginas como 3 */
		if ($doc_tipo != 'PROJE')
			{
					$tot_paginas = 3;		
			}
		/*****/		
		
		/** Mostra Header ***/		
		require("submit_cab.php");		
		echo '<form method="post" action="'.page().'"><BR>';		

		switch ($doc_tipo)
			{
			/* EMENDA - logica antiga */
			case 'AMEND':
				$pag_max = 3;
				$tot_paginas = 3;	
				if ($pag_page == 1) { require("submit_11.php"); }
				if ($pag_page == 2) { require("submit_12.php"); }
				if ($pag_page == 3) { require("submit_13.php"); }
				break;
			/* Projeto */
			case '':
				$pag_max = 7;
				$tot_paginas = 7;			
				if ($pag_page == 1) { require("submit_01.php"); }
				if ($pag_page == 2) { require("submit_02.php"); }
				if ($pag_page == 3) { require("submit_03.php"); }
				if ($pag_page == 4) { require("submit_04.php"); }
				if ($pag_page == 5) { require("submit_05.php"); }
				if ($pag_page == 6) { require("submit_06.php"); }
				break;
			case 'PROJE':
				$pag_max = 7;
				$tot_paginas = 7;				
				if ($pag_page == 1) { require("submit_01.php"); }
				if ($pag_page == 2) { require("submit_02.php"); }
				if ($pag_page == 3) { require("submit_03.php"); }
				if ($pag_page == 4) { require("submit_04.php"); }
				if ($pag_page == 5) { require("submit_05.php"); }
				if ($pag_page == 6) { require("submit_06.php"); }
				if ($pag_page == 7) { require("submit_07.php"); }
				break;
				
			/* Evento adverso */
			case '001':
				$pag_max = 3;
				$tot_paginas = 3;	
				if ($pag_page == 1) { require("submit_11.php"); }
				if ($pag_page == 2) { require("submit_12.php"); }
				if ($pag_page == 3) { require("submit_13.php"); }
				break;						

			/*  Monitoreo 008 */
			case '008':
				$pag_max = 1;
				$tot_paginas = 1;
				if ($pag_page == 1) { require("submit_81.php"); }
				break;
				
			/*  Monitoreo 007 */
			default:
				$pag_max = 3;
				$tot_paginas = 3;	
				if ($pag_page == 1) { require("submit_11.php"); }
				if ($pag_page == 2) { require("submit_12.php"); }
				if ($pag_page == 3) { require("submit_13.php"); }
				break;
			case '010':
				$pag_max = 7;
				$tot_paginas = 7;	
				$protocolo = $proto_original;			
				if ($pag_page == 1) { require("submit_01.php"); }
				if ($pag_page == 2) { require("submit_02.php"); }
				if ($pag_page == 3) { require("submit_03.php"); }
				if ($pag_page == 4) { require("submit_04.php"); }
				if ($pag_page == 5) { require("submit_05.php"); }
				if ($pag_page == 6) { require("submit_06.php"); }
				if ($pag_page == 7) { require("submit_07.php"); }
				break;
			}
		//echo '</table>';
		//echo '</fieldset>';
		echo '</form>';
	}
echo '</div>';
echo '<font class="lt0">'.$doc_tipo.'</font>';
echo '</div>';
echo $hd->foot();	
?>