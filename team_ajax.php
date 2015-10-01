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


require("db.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_email.php');
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }
$LANG = $lg->language_read();
$edit_mode = round($_SESSION['editmode']);

$pag_id = strzero(round($_SESSION['proj_id']),7);

require("_class/_class_team.php");
$tm = new team;
$tm->protocol = $pag_id;

if ($dd[10]=='con')
	{
		$id = $dd[12];
		$tm->team_contact($id,$tm->protocol);
	}

if ($dd[10]=='del')
	{
		$id = $dd[12];
		$tm->team_delete_member($id,$tm->protocol);
	}

if ($dd[10]=='add')
	{
		$email = $dd[12];
		if (checaemail($email))
			{
				$author = $tm->author_exist($email);
				if (($author != -1) and (strlen($author)==7))
					{
						$et = $tm->team_insert_author($author,$tm->protocol,'cep_submit_team',$type='N');
					} else {
						$err = '<div id="alert">';
						$err .= '<font color="red">';
						$err .= msg('author_not_found');
						$err .= '</div>';
					}				
			} else {
				$err = '<div id="alert">';
				$err .= '<font color="red">';
				$err .= msg('email_invalid');
				$err .= '</font>';
				$err .= '</div>';
			}
		
		
	}

echo $tm->team_list($tm->protocol);
echo $tm->team_form_add();
echo $err;
?>