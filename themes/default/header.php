<?php
	echo '<!DOCTYPE html><html>';
	echo '<head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	echo '<title>Booster Roll</title>';
	echo '<link rel="stylesheet" href="'.THEMES.'style.css">';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/jquery.min.js"></script>';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/jquery.textchange.min.js"></script>';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/site.js"></script>';
	echo '</head><body>';

	define("ADMIN_PANEL", false);

	require_once 'theme.php';
?>