<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage ghost user
 */
require("cab.php");

/* Valid Submit */
$chk = checkpost($dd[0]);
$ch2 = $dd[90];
if ($chk == $ch2)
	{
		
	/* Active Mode Ghost */		
	if (strlen($dd[1])==0)
		{
		/* Save original user */
		$ss->set_user_original();
		$ss->le($dd[0]);
	
		/* Active mode ghost */
		$ss->set_ghost();
		$ss->ghost_user();
	
		redirecina("main.php");
		}
	/* DesActive Mode Ghost */		
	if (strlen($dd[1]) > 0)
		{
			$ss->reset_user_original();
			$ss->reset_ghost();
			$ss->le($dd[0]);
			$ss->normal_user();
			redirecina("main.php");
		}
		
	} else {
		echo '<h1>'.msg('ghost_mode').'</h1>';
		echo '<div class="error">'.msg('access_error');'</div>';
	}
	
	echo '</div>';


echo $hd->foot(); 
?>