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
  * XML OMS
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage XML
 */
require("db.php");
header ("Content-Type:text/xml");

require("_class/_class_cep.php");
$cep = new cep;

$id = round($dd[0]);
$dx = $dd[90];

if (checkpost($id) == $dx)
	{
		$cep->le($id);
		require("_class/_class_oms.php");
		$oms = new oms;
		echo $oms->xml($cep);
	} else {
		echo 'post error';
	}
?>