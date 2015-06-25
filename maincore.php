<?
	session_start();
	error_reporting(E_ALL);

	function Redirect($location, $script = false)
	{
		if (!$script)
		{
			header("Location: ".str_replace("&amp;", "&", $location));
			exit;
		}
		else
		{
			echo "<script type='text/javascript'>document.location.href='".str_replace("&amp;", "&", $location)."'</script>\n";
			exit;
		}
	}

	function RedirectTime($location, $time = 30)
	{
		echo"<script type='text/javascript'> <!--
		function exec_refresh()
		{
  			window.status = 'reloading...' + myvar;
  			myvar = myvar + ' .';
  			var timerID = setTimeout('exec_refresh();', 100);
  			if (timeout > 0)
			{
				timeout -= 1;
			}
			else
			{
    				clearTimeout(timerID);
    				window.status = '';
    				window.location = '".$location."';
    			}
		}
		var myvar = '';
		var timeout = '".$time."';
		exec_refresh();
		//--> </script>";
	}

	$folder_level = ''; $i = 0;
	while (!file_exists($folder_level.'conf.php'))
	{
		$folder_level .= '../'; $i++;
		if ($i == 7) { die('Config file not found'); }
	}
	define("BASEDIR", $folder_level);
	require_once BASEDIR.'conf.php';

	define("INCLUDES", BASEDIR."include/");
	define("ADMINS", BASEDIR."admin/");
	define("SELF", basename($_SERVER['PHP_SELF']));

	$DB = NULL;
	if(!@include(INCLUDES.'class.DB.php'))
		die("<b>Error:</b> can not open class.DB.php!!!");

	$DBH = new DB("mysql:host=".$Config['mysql']['hostname'].";dbname=".$Config['mysql']['dbname'], $Config['mysql']['username'], $Config['mysql']['password'], $Config['mysql']['charset']);
	$DBH->error = $Config['mysql']['error'];

	$STH = $DBH->prepare("SELECT * FROM settings`");
	$STH->execute();
	while($row = $STH->fetch(PDO::FETCH_ASSOC))
		$Config[$row['setting']] = $row['value'];

	$Config['CountSecondsLabelPirate'] = $Config['CountDayLabelPirate']*24*60*60;

	function getDataKey()
	{
		global  $Config;
		$buf = array();
		$TypeKeyCash = explode(",", $Config['TypeKeyCash']);
		for ($i = 0; $i < count($TypeKeyCash); $i++)
		{
			$tmp = explode(":",  $TypeKeyCash[$i]);
			$buf[$i] = array('id' => $tmp[0], 'cost' => $tmp[1]);
		}
		return $buf;
	}

	$USER = null;
	if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
	{
		$DataIncom = array(); $DataKopeck = array();
		$STH = $DBH->query("SELECT * FROM user WHERE id=".$_SESSION['id']." AND mail='".$_SESSION['user']."' AND password='".$_SESSION['p']."'");
		$STH->execute();
		$USER = $STH->fetch(PDO::FETCH_OBJ);

		//*-----------------------------
		//* system in game
		//*------------------------------
		$STH = $DBH->prepare("SELECT * FROM `income` WHERE `Normal` > 0 OR `Gold` > 0 OR `Platinum` > 0 OR `Premium` > 0");
		$STH->execute();
		$i = 0;
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			$DataIncom[$i] = $row;
			$i++;
		}

		if (count($DataIncom) > 0)
		{
			$idIncom = rand(0, count($DataIncom) - 1);
			$IncomType = 0; $IncomTypeRand = array(); $sql = ""; $idDataKopeck = 0;
			$DataIncomType = array(
				0 => $DataIncom[$idIncom]['Normal'],
				1 => $DataIncom[$idIncom]['Gold'],
				2 => $DataIncom[$idIncom]['Platinum'],
				3 => $DataIncom[$idIncom]['Premium']
			);

			$j = 0;
			for ($i = 0; $i < count($DataIncomType); $i++)
			{
				if ($DataIncomType[$i] > 0)
				{
					$IncomTypeRand[$j] = $i;
					$j++;
				}
			}

			if (count($IncomTypeRand) > 0)
			{
				$IncomType = rand(0, count($IncomTypeRand ) - 1);

				switch ($IncomType)
				{
				  case 0:
				    $sql = "SELECT `id`, `KopeckNormal` FROM `user` WHERE `id` <> :i AND `KopeckNormal` > 0 ";
				    break;
				  case 1:
				    $sql = "SELECT `id`, `KopeckGold` FROM `user` WHERE `id` <> :i AND `KopeckGold` > 0 ";
				    break;
				  case 2:
				    $sql = "SELECT `id`, `KopeckPlatinum` FROM `user` WHERE `id` <> :i AND `KopeckPlatinum` > 0 ";
				    break;
				  case 3:
				    $sql = "SELECT `id`, `KopeckPremium` FROM `user` WHERE `id` <> :i AND `KopeckPremium` > 0 ";
				    break;
				}
			}

			if (strlen($sql) > 1)
			{
				$STH = $DBH->prepare($sql);
				$STH->execute(array('i' => $_SESSION['id']));
				$i = 0;
				while($row = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$DataKopeck[$i] = $row;
					$i++;
				}
			}
			if (count($DataKopeck) > 0)
			{
				$idDataKopeck = rand(0, count($DataKopeck) - 1);
				$buf = getDataKey();
				$csh = $buf[$IncomType]['cost']*$Config['IncomeUser']/100;
				switch ($IncomType)
				{
				  case 0:
				    $STH = $DBH->prepare("UPDATE `income` SET `Normal`=Normal-1 WHERE id_user=:i");
				    $STH->execute(array('i' => $DataIncom[$idIncom]['id_user']));
				    $STH = $DBH->prepare("UPDATE `user` SET `Kopeck`=Kopeck-1, `KopeckNormal`=KopeckNormal-1, `CountCsh`=CountCsh+:cc1, `IncomeCash`=IncomeCash+:cc2 WHERE id=:i");
				    $STH->execute(array('cc1' => $csh, 'cc2' => $csh, 'i' => $DataKopeck[$idDataKopeck]['id']));
				    break;
				  case 1:
				    $STH = $DBH->prepare("UPDATE `income` SET `Gold`=Gold-1 WHERE id_user=:i");
				    $STH->execute(array('i' => $DataIncom[$idIncom]['id_user']));
				    $STH = $DBH->prepare("UPDATE `user` SET `Kopeck`=Kopeck-1, `KopeckGold`=KopeckGold-1, `CountCsh`=CountCsh+:cc1, `IncomeCash`=IncomeCash+:cc2 WHERE id=:i");
				    $STH->execute(array('cc1' => $csh, 'cc2' => $csh, 'i' => $DataKopeck[$idDataKopeck]['id']));
				    break;
				  case 2:
				    $STH = $DBH->prepare("UPDATE `income` SET `Platinum`=Platinum-1 WHERE id_user=:i");
				    $STH->execute(array('i' => $DataIncom[$idIncom]['id_user']));
				    $STH = $DBH->prepare("UPDATE `user` SET `Kopeck`=Kopeck-1, `KopeckPlatinum`=KopeckPlatinum-1, `CountCsh`=CountCsh+:cc1, `IncomeCash`=IncomeCash+:cc2 WHERE id=:i");
				    $STH->execute(array('cc1' => $csh, 'cc2' => $csh, 'i' => $DataKopeck[$idDataKopeck]['id']));
				    break;
				  case 3:
				    $STH = $DBH->prepare("UPDATE `income` SET `Premium`=Premium-1 WHERE id_user=:i");
				    $STH->execute(array('i' => $DataIncom[$idIncom]['id_user']));
				    $STH = $DBH->prepare("UPDATE `user` SET `Kopeck`=Kopeck-1, `KopeckPremium`=KopeckPremium-1, `CountCsh`=CountCsh+:cc1, `IncomeCash`=IncomeCash+:cc2 WHERE id=:i");
				    $STH->execute(array('cc1' => $csh, 'cc2' => $csh, 'i' => $DataKopeck[$idDataKopeck]['id']));
				    break;
				}
			}
		}
	}
	// locale
	if(!@include(BASEDIR.'locale/'.$Config['StartLocale'].'/locale.php'))
		die("<b>Error:</b> can not loaded locale!!!");
	// theme
	if (file_exists(BASEDIR."themes/".$Config['theme']))
		define("THEMES", BASEDIR."themes/".$Config['theme']."/");
	else
		define("THEMES", BASEDIR."themes/default/");

	function GenSalt()
	{
		$salt = '';
		for ($i = 0; $i < 10; $i++)
		{
			$salt .= chr(rand(33, 126));
		}
		return $salt;
	}
	//--------------------------------------------------------------------------------------------------
	// 
	//--------------------------------------------------------------------------------------------------

	// functions
	function getCountKey()
	{
		global $DBH, $_SESSION;
		$STH = $DBH->query("SELECT SellKeyNormal, SellKeyGold, SellKeyPlatinum, SellKeyPremium FROM user WHERE id=".$_SESSION['id']." AND mail='".$_SESSION['user']."' AND password='".$_SESSION['p']."'");
		$STH->execute();
		$row = $STH->fetch(PDO::FETCH_OBJ);
		return '['.$row->SellKeyNormal.', '.$row->SellKeyGold.', '.$row->SellKeyPlatinum.', '.$row-> SellKeyPremium.']';
	}

	$ValueOpenChest = array();
	$ValueOpenChest['value'][0] = 50;
	$ValueOpenChest['chance'][0] = 1;

	$ValueOpenChest['value'][1] = 20;
	$ValueOpenChest['chance'][1] = 2;

	$ValueOpenChest['value'][2] = 10;
	$ValueOpenChest['chance'][2] = 3;

	$ValueOpenChest['value'][3] = 5;
	$ValueOpenChest['chance'][3] = 4;

	$ValueOpenChest['value'][4] = 1;
	$ValueOpenChest['chance'][4] = 90;

	function RoundValueOpenChest()
	{
		global $ValueOpenChest;
		$tmp = array();
		$res = 0;
		$j = 0;
		//calc chance
		for ($i = 0; $i < count($ValueOpenChest['chance']); $i++)
		{
			if ($i > 0)
				$ValueOpenChest['chance'][$i] = $ValueOpenChest['chance'][$i] + $ValueOpenChest['chance'][$i - 1];
		}

		for ($i = 0; $i < 100; $i++)
		{
			if ($i == $ValueOpenChest['chance'][$j])
				$j++;
			$tmp[$i] = $ValueOpenChest['value'][$j];
		}
		shuffle($tmp);
		$res = $tmp[rand(0, 99)];
		return $res;
	}

	function DBH_AddRoundValue($str)
	{
		global $DBH, $_SESSION;
		$row = "";

		list($type, $value) = explode(",", $str);
		switch ((int)$type)
		{
		  case 0:
		    $row = "`KopeckNormal`=KopeckNormal+".$value;
		    break;
		  case 1:
		    $row = "`KopeckGold`=KopeckGold+".$value;
		    break;
		  case 2:
		    $row = "`KopeckPlatinum`=KopeckPlatinum+".$value;
		    break;
		  case 3:
		    $row = "`KopeckPremium`=KopeckPremium+".$value;
		    break;
		}

		$STH = $DBH->prepare("UPDATE `user` SET `Kopeck`=Kopeck+".$value.", ".$row." WHERE id=:i AND mail=:m AND password=:p");
		$STH->execute(array('i' => $_SESSION['id'], 'm' => $_SESSION['user'], 'p' => $_SESSION['p']));
	}

	function DBH_AddOpenChest()
	{
		global $DBH, $_SESSION;
		$STH = $DBH->prepare("UPDATE `user` SET `OpenChest`=OpenChest+1 WHERE id=:i AND mail=:m AND password=:p");
		$STH->execute(array('i' => $_SESSION['id'], 'm' => $_SESSION['user'], 'p' => $_SESSION['p']));
	}

	function DBH_DeleteKey($keys)
	{
		global $DBH, $_SESSION;
		$row = "";

		switch ($keys)
		{
		  case 0:
		    $row = "`SellKeyNormal`=SellKeyNormal-1";
		    break;
		  case 1:
		    $row = "`SellKeyGold`=SellKeyGold-1";
		    break;
		  case 2:
		    $row = "`SellKeyPlatinum`=SellKeyPlatinum-1";
		    break;
		  case 3:
		    $row = "`SellKeyPremium`=SellKeyPremium-1";
		    break;
		}

		$STH = $DBH->prepare("UPDATE `user` SET `SellKey`=SellKey-1, ".$row." WHERE id=:i AND mail=:m AND password=:p");
		$STH->execute(array('i' => $_SESSION['id'], 'm' => $_SESSION['user'], 'p' => $_SESSION['p']));
	}

	function DBH_UpdateIncome($str)
	{
		global $DBH, $_SESSION;
		$tmp = explode(",", $str);
		$STH = $DBH->prepare("UPDATE `income` SET `Normal`=Normal+:k0, `Gold`=Gold+:k1, `Platinum`=Platinum+:k2, `Premium`=Premium+:k3 WHERE id_user=:i");
		$STH->execute(array('k0' => $tmp[0], 'k1' => $tmp[1], 'k2' => $tmp[2], 'k3' => $tmp[3], 'i' => $_SESSION['id']));
	}
?>