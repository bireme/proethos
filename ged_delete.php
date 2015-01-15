<?
    /**
     * Ged - delete file
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
	 * @access public
     * @version v0.11.29
	 * @package Proethos
	 * @subpackage ged
    */
require("db.php");
require('_class/_class_message.php');

	$link_msg = 'messages/msg_ged_download.php';
	if (file_exists($link_msg)) { require($link_msg); } else { echo 'erro:msg';}

	/* Mensagens */
	$tabela = 'ged_upload';
	$link_msg = '../messages/msg_'.$tabela.'.php';
	if (file_exists($link_msg)) { require($link_msg); }
	
$id = $dd[0];
	
//if ($dd[90] == checkpost($id))
	{
		require("_ged_config.php");
		$ged->id_doc = $id;
		echo $ged->file_delete($id);
		require("close.php");
	}
?>
