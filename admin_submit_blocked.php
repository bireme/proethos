<?php
/**
 * Admin Menu
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos-Admin
 * @subpackage Unit Register
 */
require ("cab.php");

echo '<h1>' . msg('blocked_form') . '</h1>';
/* mostra mensagem no formato texto */
echo mst(msg('blocked_form_text'));
echo '</div>';

echo $hd -> foot();
?>
