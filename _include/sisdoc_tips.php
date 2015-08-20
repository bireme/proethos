<?php
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
