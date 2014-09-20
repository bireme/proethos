<?
echo '<TR>';
echo '<TD class="lt2" colspan=2>';
echo 'Registros';

$ref = 'register_'.$r;

$link = 'submit_team_ajax.php?dd1='.$protocolo.'&dd2=listar&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
?>
<div id="<?=$ref;?>">
</div>

<script>
	var $tela01 = $.ajax('<?=$link;?>')
		.done(function(data) { $("#<?=$ref;?>").html(data); })
		.always(function(data) { $("#<?=$ref;?>").html(data); });	 
</script>
