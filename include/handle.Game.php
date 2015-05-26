<?php

	require_once '../maincore.php';

	if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']) && isset($_POST['cmd']))
	{
		list($cmd, $value) = explode(":", $_POST['cmd']);
		if ($cmd == 'SelectSellBox')
		{
			$STH = $DBH->query("SELECT cSellBox FROM user WHERE id=".$_SESSION['id']." AND mail='".$_SESSION['user']."' AND password='".$_SESSION['p']."'");
			$STH->execute();
			$res = $STH->fetch(PDO::FETCH_ASSOC);
			echo $res['cSellBox'];
		}
	}
?>