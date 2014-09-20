<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage logo
 */
require("cab.php");

require($include.'cp2_gravar.php');

/*
 * Salva
 */	
 


if (strlen($dd[1]) > 0)
	{
		$filename = $_FILES['userfile']['name'];
		echo '====>'.$filename;
		print_r($_FILES['userfile']);
		$tmp = $_FILES['userfile']['tmp_name'];
		if ($dd[1] == 'logo1') { $dest = 'img/logo_dictamen.jpg'; }
		if ($dd[1] == 'logo2') { $dest = 'img/layout/logo_1.png'; }
		if ($dd[1] == 'logo3') { $dest = 'img/layout/logo_2.png'; }
		
		if ($dd[1] == 'logo4') { $dest = 'img/logo_institution.png'; }
		
		if (strlen($dest) > 0)
			{
				/* save */
				   if(move_uploaded_file($tmp,$dest))
				   	{ echo 'ok'; }
				   else {
					{ echo '--'; }
				   }
				 redirecina(page());
				 exit;
			}
	}



	echo '<TABLE width="704">';
	
	echo '<TR><TH>'.msg('logo_documents');
	echo '<TH>'.msg('logo_site');
	echo '<TR><TD align="center">';
	echo '<img src="img/logo_dictamen.jpg">';
	
	echo '<TD align="center">';
	echo '<img src="img/layout/logo_1.png">';
	//echo '<img src="img/layout/logo_2.png">';
	
	echo '<TR><TD>';
	echo '<form action="'.page().'" method="post" enctype="multipart/form-data">';
    echo '<label for="file">Select a file:</label>';
	echo '<input type="file" name="userfile" id="file"> <br />';
	echo '<input type="hidden" name="dd1" value="logo1"> <br />';
	echo '<input type="submit" valur="'.msg('submit_file').'">';
   	echo '</form>';
	
	echo '<TD>';
	echo '<form action="'.page().'" method="post" enctype="multipart/form-data">';
    echo '<label for="file">Select a file:</label>';
	echo '<input type="file" name="userfile" id="file"> <br />';
	echo '<select name="dd1">';
	echo '<option value=""></option>';
	echo '<option value="logo2">'.msg("cust_logo_1").'</option>';
	//echo '<option value="logo3">'.msg("cust_logo_2").'</option>';
	echo '<input type="submit" valur="'.msg('submit_file').'">';
   	echo '</form>';	
   	
   	echo '<TR><TH>'.msg('logo_login');
	echo '<TR><TD align="center">';
	echo '<img src="img/logo_institution.png">';
	echo '<TR><TD>';
	echo '<form action="'.page().'" method="post" enctype="multipart/form-data">';
    echo '<label for="file">Select a file:</label>';
	echo '<input type="file" name="userfile" id="file"> <br />';
	echo '<input type="hidden" name="dd1" value="logo4"> <br />';
	echo '<input type="submit" valur="'.msg('submit_file').'">';
   	echo '</form>';   	
	echo '</TABLE>';
	echo '</div>';

	echo $hd->foot(); ?>