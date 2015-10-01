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