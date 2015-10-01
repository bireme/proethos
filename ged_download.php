<?
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
     * Ged - Download file
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package index
	 * @subpackage ged
    */
$include = '../';
require("db.php");
require('_class/_class_message.php');

	/* Mensagens */
	$tabela = 'ged_upload';
	$link_msg = '../messages/msg_'.$tabela.'.php';
	if (file_exists($link_msg)) { require($link_msg); }

$id = $dd[0];
$secu = uppercase($secu);
$chk1 = checkpost($id.$secu);
$secu = '';
$chk2 = checkpost($id);

$secu = $dd[91];
$chk1 = checkpost($id.$secu);

if (($dd[90] == $chk1) or ($dd[90] == $chk2))
	{
	require("_ged_config.php");
	if (strlen($dd[50]) > 0)
		{ $ged->tabela = $dd[50]; }
		echo $ged->download($id);
	} else {
		echo msg('erro_post');
	}
?>