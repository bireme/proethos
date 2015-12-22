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

    /**
     * Ged - upload file
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package index
	 * @subpackage ged
    */
    
require("db.php");
require($include.'sisdoc_debug.php');

/* Check */
$id = $dd[0];
$chk = checkpost($id);

if ($chk != $dd[90])
	{
		echo 'Post error';
		exit;
	}

require("_ged_config.php");
$sql = "update ".$ged->tabela." set doc_ativo = 0 where id_doc = ".$dd[0];
$rlt = db_query($sql);

require("close.php");
?>