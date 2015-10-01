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
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Menssages
 */
require('cab.php');
require($include.'sisdoc_debug.php');

$sql = "select * from _messages 
  		limit 10000
";
$rlt = db_query($sql);

while ($line = db_read($rlt))
	{
		$msg1 = trim($line['msg_field']);
		$msg2 = trim($line['msg_content']);
		$en = trim($line['msg_language']);
		$id = $line['id_msg'];
		if ($msg2 == $msg1)
			{
				echo '<HR>';
				echo $msg1.'--'.$msg2;
				echo '---'.$en;
				echo '---'.$id;
			} else {
				//$sx .= $msg1.':'.msg2;
			}
	}

echo '</div>';
echo $hd->foot();
?>