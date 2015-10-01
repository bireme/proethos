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


require ("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

echo '<h1>System check</h1>';

echo '<div class="border1 pad5">';
echo '<h2>Ajax</h2>';
echo '<div id="ajax_div">Ajax Error</div>';
echo '</div>';
echo '<BR>';

echo '
<script>
		$.ajax({
				url: "submit_ajax.php",
 				type: "POST",
 				data: { dd1: "", dd2: "", dd3: "" , dd10: "test" ,dd11: "" }
 		 }) 
		.fail(function() { alert("error"); })
 		.success(function(data) { $("#ajax_div").html(data); });

</script>
';

echo '<div class="border1 pad5">';
echo '<h2>Save File and Create Directory</h2>';
if (!(file_exists('repositorio/_temp'))) {
	echo 'Create directory';
	if (!is_dir('repositorio'))
		{
			mkdir('repositorio');		
		}
	
	mkdir('repositorio/_temp');
	echo ' <font color="green">ok!</font>';
}

/* Create File */
if (file_exists('repositorio/_temp/index.htm')) {
	echo '<BR>Delete file repositorio/_temp/index.htm';
	unlink('repositorio/_temp/index.htm');
	echo ' <font color="green">ok!</font>';
}

/* Create file */
echo '<BR>Create File';
$rlt = fopen('repositorio/_temp/index.htm', 'w+');
fwrite($rlt, '<title>System Teste</title>');
fclose($rlt);
echo ' <font color="green">ok!</font>';

/* Delete file */
echo '<BR>Delete file _temp/index.htm';
unlink('repositorio/_temp/index.htm');
echo ' <font color="green">ok!</font>';

/* Remove Directory */
echo '<BR>Remove directory';
rmdir('repositorio/_temp');
echo ' <font color="green">ok!</font>';
echo '</div>';

echo '</div>';

echo $hd -> foot();
?>