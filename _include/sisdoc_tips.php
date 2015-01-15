<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
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
