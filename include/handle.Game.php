<?php

	require_once '../maincore.php';

	if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']) && isset($_POST['data']))
	{
		list($cmd, $value) = explode(":", $_POST['data']);
		$result = '';
		switch ($cmd)
		{
		  case 'DBH_AddOpenChest':
		    DBH_AddOpenChest();
		    break;
		  case 'DBH_DeleteKey':
		    DBH_DeleteKey($value);
		    break;
		  case 'getCountKey':
		    $result = getCountKey();
		    break;
		}
		echo $result;
	}
?>