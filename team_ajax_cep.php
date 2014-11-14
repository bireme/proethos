<?
require("db.php");
require($include.'sisdoc_colunas.php');
require($include.'_class_email.php');
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';

if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }
$LANG = $lg->language_read();
$edit_mode = round($_SESSION['editmode']);

$tabela = 'cep_team';
$pag_id = $dd[11];

require("_class/_class_team.php");
$tm = new team;
$tm->protocol = $pag_id;

if ($dd[10]=='con')
	{
		$id = $dd[12];
		$tm->team_contact($id,$tm->protocol,'cep_team');
	}

if ($dd[10]=='del')
	{
		$id = $dd[12];
		$tm->team_delete_member($id,$tm->protocol,'cep_team');
	}

if ($dd[10]=='add')
	{
		$email = $dd[12];
		if (checaemail($email))
			{
				$author = $tm->author_exist($email);
				if (($author != -1) and (strlen($author)==7))
					{
						$et = $tm->team_insert_author($author,$tm->protocol,'cep_team',$type='N');
					} else {
						$err = '<div id="alert">';
						$err .= '<font color="red">';
						$err .= msg('author_not_found');
						$err .= '</div>';
						$tm->erro = $err;
					}				
			} else {
				$err = '<div id="alert">';
				$err .= '<font color="red">';
				$err .= msg('email_invalid');
				$err .= '</font>';
				$err .= '</div>';
				$tm->erro = $err;
			}
		
		
	}
echo '===>'.$tm->erro.'--'.$tabela;
echo $tm->team_list($tm->protocol,$tabela);
echo $tm->team_form_add();

?>
