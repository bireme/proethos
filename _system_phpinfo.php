<?php
require ("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok == 0) { redirecina('main.php');
}

echo '<h1>System Information</h1>';

echo msg('post_max_size').' = '. ini_get('post_max_size') . "";
echo ' (<A HREF="http://php.net/manual/en/ini.core.php" target="new">'.mst('see_more').')</A>';

phpinfo();
echo '</DIV>';
echo $hd -> foot();
?>

