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

echo '<h1>' . msg('admin_update_system') . '</h1>';
/* mostra mensagem no formato texto */

require("_class/_class_update.php");
$pb = new update_system;

echo $pb->lista_arquivos();

echo '</div>';

echo $hd -> foot();
?>
