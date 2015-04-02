<?php
$email_debug = 1;
$email_auth = 'MAIL';
$body = '<h1>Congratulations!</h1>This email was sent by Method #1';
enviaremail($email_to,'',$title_sample.' Method#1 '.date("d/m/Y H:m:s"),$body);
?>
