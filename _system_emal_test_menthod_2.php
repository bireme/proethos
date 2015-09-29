<?php

print '<pre>';
$email_debug = 1;
$email_auth = 'AUTH';
$body = '<h1>Congratulations!</h1>This email was sent by Method #2';
enviaremail($email_to,'',$title_sample.' Method#2 '.date("d/m/Y H:m:s"),$body);
?>

