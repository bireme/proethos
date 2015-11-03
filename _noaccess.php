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
 /**
  * Start Page
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Start_page
 */
 
ob_start();
@header("HTTP/1.1 401 Unauthorized: Access is denied due to invalid credentials");
@header("Status: 401 Unauthorized: Access is denied due to invalid credentials");
@header("Retry-After: 120");
@header("Connection: Close");
?><!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>401 Unauthorized: Access is denied due to invalid credentials</title>
</head><body>
<h1>Access is denied due to invalid credentials</h1>
<p>Access is denied due to invalid credentials</p>
</body></html>
<?php
$g=ob_get_clean();
echo $g;
?>