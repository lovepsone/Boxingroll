<?php
	session_start();
	$string = "";
	for ($i = 0; $i < 7; $i++)
		$string .= chr(rand(97, 122));
	
	$_SESSION['rand_code'] = $string;

	$dir = "fonts/";

	$image = imagecreatetruecolor(170, 22);
	$black = imagecolorallocate($image, 0, 0, 0);
	$color = imagecolorallocate($image, 200, 100, 90);
	$white = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));

	imagefilledrectangle($image,0,0, 399, 99, $white);
	imagettftext($image, 15, 0, 40, 17, $color, $dir."verdana.ttf", $_SESSION['rand_code']);

	header("Content-type: image/png");
	imagepng($image);
?>