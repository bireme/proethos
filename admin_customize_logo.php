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
 * Admin Menu
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos-Admin
 * @subpackage logo
 */
require ("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok == 0) {
	redirecina('main.php');
}

/* Borrar arquivo */
if (($dd[5] == 'DEL') and ($dd[7] == '1')){
	if ($dd[6] == 'logo1') {
		$dest = 'document/proethos_logo_1.jpg';
		if (file_exists($dest)) {
			unlink($dest);
		}
	}
	if ($dd[6] == 'logo2') {
		$dest = 'document/proethos_logo_1.png';
		if (file_exists($dest)) {
			unlink($dest);
		}
	}
	if ($dd[6] == 'logo3') {
		$dest = 'document/proethos_logo_2.png';
		if (file_exists($dest)) {
			unlink($dest);
		}
	}
}

/*
 * Salva
 */

if (strlen($dd[1]) > 0) {
	$filename = $_FILES['userfile']['name'];
	$tmp = $_FILES['userfile']['tmp_name'];
	$type = $_FILES['userfile']['type'];
	$dd[1] = trim($dd[1]);

	if ($dd[1] == 'logo1') {
		$dest = 'document/proethos_logo_1.jpg';
		if ($type != 'image/jpeg') {
			$dest = '';
			$erro1 = '<font color="red">' . msg('only') . ' JPG ' . msg('format') . '</font>';
		}
	}
	if ($dd[1] == 'logo2') { $dest = 'document/proethos_logo_1.png';
	}
	if ($dd[1] == 'logo3') { $dest = 'document/proethos_logo_2.png';
	}
	if ($dd[1] == 'logo4') { $dest = 'document/proethos_logo_3.png';
	}

	if (strlen($dest) > 0) {
		/* save */
		if (move_uploaded_file($tmp, $dest)) { echo 'ok';
		} else { echo '--';
		}
	}
	echo $dest;
	redirecina(page());
	exit ;
}

/* Imagens */
$img1 = logo(1);
$img2 = logo(2);
$img3 = logo(3);

echo '<TABLE width="100%" border=0 >';

echo '<TR><TD align="left">';
echo '<h1>' . msg('logo_documents') . '</h1>';
echo '<fieldset><legend>' . msg('logo_documents') . '</legend>';

echo '<img src="' . $img1 . '">';

echo '<form action="' . page() . '" method="post" enctype="multipart/form-data">';
echo '<label for="file">Select a file:</label>';
echo '<input type="file" name="userfile" id="file"> <br />';
echo '<input type="hidden" name="dd1" value="logo1"> <br />';
echo '<input type="submit" value="' . strip_tags(msg('submit_file')) . '">';
echo '</form>';

/* Borrar arquivo */
$dest = 'document/proethos_logo_1.jpg';
if (file_exists($dest)) {
	echo '<form action="' . page() . '" method="post">';
	echo '<input type="hidden" name="dd6" value="logo1"> <br />';
	echo '<input type="hidden" name="dd5" value="DEL"> <br />';
	echo '<input type="checkbox" name="dd7" value="1"> '.msg('confirm_del_file').'<br />';	
	echo '<input type="submit" value="' . strip_tags(msg('borrar_file')) . '">';
	echo '</form>';
}

echo $erro1;
echo '</fieldset>';
echo '</TD></tr>';

/* LOGO 2 */
echo '<TR><TD align="left">';
echo '<h1>' . msg('logo_site') . '</h1>';
echo '<fieldset><legend>' . msg('logo_site') . '</legend>';
echo '<img src="' . $img2 . '">';

echo '<form action="' . page() . '" method="post" enctype="multipart/form-data">';
echo '<label for="file">Select a file:</label>';
echo '<input type="file" name="userfile" id="file"> <br />';
echo '<input type="hidden" name="dd1" value="logo2"> <br />';
echo '<input type="submit" value="' . strip_tags(msg('submit_file')) . '">';
echo '</form>';

/* Borrar arquivo */
$dest = 'document/proethos_logo_1.png';
if (file_exists($dest)) {
	echo '<form action="' . page() . '" method="post">';
	echo '<input type="hidden" name="dd6" value="logo2"> <br />';
	echo '<input type="hidden" name="dd5" value="DEL"> <br />';
	echo '<input type="checkbox" name="dd7" value="1"> '.msg('confirm_del_file').'<br />';	
	echo '<input type="submit" value="' . strip_tags(msg('borrar_file')) . '">';
	echo '</form>';
}

echo '</fieldset>';
echo '</TD></tr>';

echo '<TR><TD align="left">';
echo '<h1>' . msg('logo_login') . '</h1>';
echo '<fieldset><legend>' . msg('logo_login') . '</legend>';

echo '<img src="' . $img3 . '">';
echo '<form action="' . page() . '" method="post" enctype="multipart/form-data">';
echo '<label for="file">Select a file:</label>';
echo '<input type="file" name="userfile" id="file"> <br />';
echo '<input type="hidden" name="dd1" value="logo3"> <br />';
echo '<input type="submit" value="' . strip_tags(msg('submit_file')) . '">';
echo '</form>';

/* Borrar arquivo */
$dest = 'document/proethos_logo_2.png';
if (file_exists($dest)) {
	echo '<form action="' . page() . '" method="post">';
	echo '<input type="hidden" name="dd6" value="logo3"> <br />';
	echo '<input type="hidden" name="dd5" value="DEL"> <br />';
	echo '<input type="checkbox" name="dd7" value="1"> '.msg('confirm_del_file').'<br />';
	echo '<input type="submit" value="' . strip_tags(msg('del_file')) . '">';
	echo '</form>';
}

echo '</fieldset>';
echo '</TD></tr>';
echo '</TABLE>';
echo '</div>';

echo $hd -> foot();
?>