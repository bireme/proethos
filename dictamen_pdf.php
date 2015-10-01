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


require("db.php");

require("_class/_class_dictamen.php");
$dic = new dictamen;

require("_class/_class_cep.php");
$cep = new cep;

$id = $dd[1];
$ps = $dd[90];
if (checkpost($id) != $ps)
	{
		echo 'Post Error!';
		exit;
	}
$dic->le_parecer_id($dd[1]);

/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
$LANG = $lg->language_read();

if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

require($include.'sisdoc_data.php');

require("dictamen_pdf_projeto.php");
?>