<?php
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

