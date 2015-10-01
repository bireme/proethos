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
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @copyright © Pan American Health Organization, 2013. All rights reserved.
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Coluns
*/

if (strlen($sisdoc_colunas) == 0)
{
$sisdoc_colunas = True;

if ($mostar_versao == True) { array_push($sis_versao,array("sisDOC (Colunas)","0.0a",20080520)); }

global $vcol, $est_col;
$vcol = 0;
$est_col = "onMouseOver=\"this.style.backgroundColor='#e4f7fa'\" onMouseOut=\"this.style.backgroundColor=''\"";

function Coluna()
	{
	global $vcol, $est_col;	
	if ($vcol ==0)
		{
		$xvcol = "";
		$vcol=1;
		}
	else
		{
		$xvol = ' bgcolor="#F0F0F0" ';
		$vcol=0;
		}
		$xvol = $xvol . $est_col;
		return($xvol  );
	}
}
?>