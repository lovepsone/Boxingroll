<?php
	echo '<!DOCTYPE html><html>';
	echo '<head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	echo '<title>Booster Roll</title>';
	echo '<link rel="stylesheet" href="themes/default/style.css">';
	echo '<script type="text/javascript" src="include/js/jquery.min.js"></script>';

	if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
	{
		echo '<script type="text/javascript" src="include/js/three.min.js"></script>';
		echo '<script type="text/javascript" src="include/js/renderers/Projector.js"></script>';
		echo '<script type="text/javascript" src="include/js/renderers/CanvasRenderer.js"></script>';
		echo '<script type="text/javascript" src="include/js/libs/tween.min.js"></script>';
		echo '<script type="text/javascript" src="include/js/fonts/helvetiker_regular.typeface.js"></script>';
		echo '<script type="text/javascript" src="include/js/game.js"></script>';
	}
	echo '<script type="text/javascript" src="include/js/site.js"></script>';
	echo '</head><body>';

	define("ADMIN_PANEL", false);

	require_once 'theme.php';
?>