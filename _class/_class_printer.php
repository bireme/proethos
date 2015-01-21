<?php
 /**
  * Printer
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.07
  * @package Class
  * @subpackage printer
 */
class printer
	{
	function break_page()
		{
			$sx .= '<p style="page-break-before: always;"></p>';
			return($sx);
		}
	function view($sr)
		{
			$sx .= '<table width="100%" cellpadding=0 cellpadding=0 class="hidden_print">';
			$sx .= '<TR><TD>
						<input type="button" value="'.msg("print_this_page").'" onclick="window.print();">
						<TD>
						<input type="text" size=20 maxsize=100 name="dd10">
						<input type="button" value="'.msg("send_to_email").'">
						';
			$sx .= '</table>';
			$sx .= $sr;
			return($sx);
		}
	}
?>
