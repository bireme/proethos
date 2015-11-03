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

?>

<?php
require ("cab.php");

echo '<h1>E-mail system check</h1>';

$sql = "
INSERT INTO `cep_action_permission` (`actionp_action`, `actionp_perfil`, `actionp_ativa`) VALUES
('009', '#ADM', 1),
('003', '#ADM', 1),
('005', '#ADM', 1),
('002', '#ADM', 1),
('011', '#ADM', 1),
('012', '#ADM', 1),
('013', '#ADM', 1),
('014', '#ADM', 1),
('015', '#ADM', 1),
('016', '#ADM', 1),
('017', '#ADM', 1)
";
$rlt = db_query($sql);
exit;

$sql = "alter table _committee add column cm_admin_email_port char(10) NOT NULL ";
$rlt = db_query($sql);
$sql = "alter table _committee add column cm_admin_email_smtp char(100) NOT NULL ";
$rlt = db_query($sql);

echo '</div>';

echo $hd -> foot();
?>