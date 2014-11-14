<?php
require ("cab.php");

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
