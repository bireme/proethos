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


	$link = '<A HREF="javascript:newxy2(\'login_password_send.php?dd1='.$dd[1].'\',400,200)">';
	$msg_erro .= '<div id="div_forgot">';
	$msg_erro .= msg('password_forgot');
	$msg_erro .= $link;
	$msg_erro .= '<BR>'.msg('here');
	$msg_erro .= '</A>';
	$msg_erro .= '</div>';
?>