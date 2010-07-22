<?php
session_start();

$randomstring = md5(microtime());
$realstring = substr($randomstring,0,7);
$useimage  = imagecreatefromjpeg("img.jpg");
$linecolor = imagecolorallocate($useimage, 233,239,239);
$textcolor = imagecolorallocate($useimage, 255, 255, 255);

imageline($useimage,1,1,40,40, $linecolor);
imageline($useimage,1,56,60,5, $linecolor);
imageline($useimage,12,5,78,5, $linecolor);
imageline($useimage,19,53,34,5, $linecolor);
imagestring($useimage, 5, 3, 10, $realstring, $textcolor);

header("Content-type: image/jpeg");

imagejpeg($useimage);

$_SESSION['key'] = $realstring;
?>
