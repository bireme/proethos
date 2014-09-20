<?php
class position
	{
		function show($status)
			{
				$sx = '<div class="proto_menu border1">';
				$cls = array('','prevStep','currentStep','','','','','','','','');
				$cls = array('','','','','','','','','','','');
				if ($status == 'A') { $ini = 1; }
				if ($status == 'B') { $ini = 2; }
				if ($status == 'C') { $ini = 3; }
				if ($status == 'D') { $ini = 4; }
				if ($status == 'E') { $ini = 5; }
				if ($status == 'P') { $ini = 6; }
				if ($status == 'H') { $ini = 1; }
				if ($status == '@') { $ini = -1; }

				for ($r=0;$r <= $ini;$r++) {$cls[$r] = 'prevStep'; }
				$cls[$ini] = 'currentStep';
				$sx .=  '<table width="100%" cellpadding=0 cellspacing=0 border=0 class="lt1">';
				for ($r=1;$r < 7;$r++)
					{
						//$edit_mode = True;
						$op = msg('proto_cab_'.$r);
						$name="item".$r;
						$class_name="topmenu_off";
						if ($ini == $r) { $class_name = 'topmenu_on'; }
						$sx .= '<TD align="center" class="'.$class_name.'" height=30>';
						$sx .= '<center><font class="'.$class_name.'">';
						$sx .= $op; 
						$sx .= '</A>';
						$sx .= '<TD class="'.$class_name.'" width="20">';
						$sx .=  '<img src="images/topmenu_sp.png">';
					}
				$sx .=  '</table>';
				$sx .= '</div>';
				return($sx);
				}
	}
?>