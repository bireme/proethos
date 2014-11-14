<?php
require("cab.php");
require($include.'sisdoc_menus.php');
require("_class/_class_resume.php");


require("_class/_class_cep.php");
$cep = new cep;
require("_class/_class_cep_reports.php");
$cep_r = new cep_reports;

$rs = new resume;

echo '<h2>'.msg("report_001").'</h2>';
echo '<P>'.msg("report_001_inf").'</P>';

echo '<h3>'.msg("report_001a").'</h3>';
echo $cep_r->report_001a();

echo '<h3>'.msg("report_001b").'</h3>';
echo $cep_r->report_001b();

echo '<h3>'.msg("report_001c").'</h3>';
echo $cep_r->report_001c();


echo '</div>';
?>
<script>
	
</script>
<?php 
require("foot.php");
?>
