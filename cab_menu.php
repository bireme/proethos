<?
$menuc = array();
array_push($menuc,array('main.php',msg('home'),'home'));
if (strlen($ss->user_codigo) > 0)
	{ array_push($menuc,array('research.php',msg('research_summary'),'research')); }
	
/* Members Committee */
if ($perfil->valid('#MEM'))
 	{ array_push($menuc,array('committee.php',msg('member_committee'),'committee')); }
	
if (strlen($ss->user_codigo) > 0)
	{ array_push($menuc,array('my_account.php',msg('my_account'),'my')); }
	
array_push($menuc,array('faq.php',msg('menu_faq'),'faq'));
array_push($menuc,array('documents.php',msg('menu_documents'),'docs'));
if (($perfil->valid('#ADM')) or ($perfil->valid('#MAS')))
	{ array_push($menuc,array('admin.php',msg('menu_admin'),'admin')); }
	
array_push($menuc,array('contact.php',msg('contact'),'contact'));

/* Mount top Menu */
$sx = '<div id="cabmenu" style="width: 99%;"><nav><ul>'.chr(13);

/* Login and user name */
$sx .= '<div class="right lpad5 rmarg5">';
/* Logado */
				if (strlen($ss->user_codigo) > 0) 
				{
					$sx .= $ss->show_user_name();	
				} else {
					$sx .= '<TD width="*"></td>';
				}
$sx .= $hd->change_language();				
$sx .= '</div>';
if (empty($active_page)) { $active_page = ''; }
/* Proethos Image */
for ($r=0;$r < count($menuc);$r++)
	{
		/* marca página ativa */
		$style = '';
		if ($active_page == $menuc[$r][2]) 
				{
					$style = ' style="background-color: red;" ';
					$style = ' class="active_menu" '; 
				}
		$sx .= '<li '.$style.'><a href="'.$menuc[$r][0].'">'.$menuc[$r][1].''.'</a>'.chr(13);
	}
$sx .= '</ul>';
$sx .= '</nav></div>'.chr(13);

$sx .= '<div id="cab2" class="pad5">';
$sx .= '<div class="left rpad5"><img src="images/logo_proethos.png" height="30"></div>';
$sx .= '	<div class="right lpad5">';
$sx .= '	</div>';
$sx .= '</div>';

/* Show result */
echo $sx;

?>				



