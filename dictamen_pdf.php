<?php
require("db.php");

require("_class/_class_dictamen.php");
$dic = new dictamen;
$dic->le_parecer($dd[1]);

/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
$LANG = $lg->language_read();

if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

require($include.'sisdoc_data.php');
require("dictamen_pdf_projeto.php");
?>
