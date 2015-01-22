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
		$sx = '<span tips="'.$cx2.'" 
				id="'.$id.'"
				
				>'.$cx1.'</span>';
		return($sx); 
	}
?>
