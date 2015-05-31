<?php

	require_once '../maincore.php';
	$data = explode(":", $_POST['data']);
	if (!isset($_SESSION['user']) && $data[0] == "AuthStart")
	{
		$STH = $DBH->query("SELECT salt FROM user WHERE mail='".$data[1]."'");
		$STH->execute();
		if ($STH->rowCount() < 1)
		{
			//err
		}
		else
		{
			$s = $STH->fetch(PDO::FETCH_OBJ)->salt;
			$p = SHA1(md5($data[2]) + $s);
			$STH = $DBH->query("SELECT * FROM user WHERE mail='".$data[1]."' AND password='".$p."'");
			$STH->execute();
			if ($STH->rowCount() == 1)
			{
				$auth = $STH->fetch(PDO::FETCH_OBJ);
				$_SESSION['id'] = $auth->id;
				$_SESSION['name'] = $auth->nickname;
				$_SESSION['user'] = $auth->mail;
				$_SESSION['gmlevel'] = $auth->gmlevel;
				$_SESSION['p'] = $p;
			}
			else
			{
				//err
			}
		}
	}
?>