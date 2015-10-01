<?
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


session_start();
$codigoCaptcha = substr(md5(time()), 0, 8);
$_SESSION['form_captcha'] = $codigoCaptcha;
$imagemCaptcha = imagecreatefrompng("img/image_captch.png");
$fonteCaptcha = imageloadfont("img/anonymous.gdf");
$corCaptcha = imagecolorallocate($imagemCaptcha, 0, 128, 128);
imagestring($imagemCaptcha, $fonteCaptcha, 25, 5, $codigoCaptcha, $corCaptcha);
header("Content-type: image/png");
imagepng($imagemCaptcha);
imagedestroy($imagemCaptcha);
?>