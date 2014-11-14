<?php
require ("cab.php");

echo '<h1>E-mail system check</h1>';

$sql = "alter table _committee add column cm_admin_email_port char(10) NOT NULL ";
$rlt = db_query($sql);
$sql = "alter table _committee add column cm_admin_email_smtp char(100) NOT NULL ";
$rlt = db_query($sql);

echo '</div>';

echo $hd -> foot();
?>
