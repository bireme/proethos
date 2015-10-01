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
* @subpackage Tips
*/

function tips($cx1,$cx2,$id="")
	{
		$cxe = strpos($cx2,'<A href="javascript');
		$clx = '';
		if ($cxe > 0)
			{
				$ct = $cx2;
				$clx = substr($cx2,$cxe,strlen($cx2));
				$cx2 = substr($cx2,0,$cxe);
				$cxf = strpos($cxt,'</A>');
				$cx2 .= substr($cxt,$cxf,strlen($cx2)); 				
			}
		
		$sx = '<span tips="'.$cx2.'" 
				id="'.$id.'"
				>'.$cx1.$clx.'</span>';
		
		return($sx); 
	}
?>