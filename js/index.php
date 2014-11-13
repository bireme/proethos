<?php
 /**
  * Start Page
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
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
exit;
exit();
?>

?>
