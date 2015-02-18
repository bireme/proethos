<?
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