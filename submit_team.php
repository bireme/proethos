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


echo '<TR>';
echo '<TD class="lt2" colspan=2>';
echo 'Registros';

$ref = 'register_'.$r;

$link = 'submit_team_ajax.php?dd1='.$protocolo.'&dd2=listar&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
?>
<div id="<?php echo $ref;?>">
</div>

<script>
	var $tela01 = $.ajax('<?php echo $link;?>')
		.done(function(data) { $("#<?php echo $ref;?>").html(data); })
		.always(function(data) { $("#<?php echo $ref;?>").html(data); });	 
</script>