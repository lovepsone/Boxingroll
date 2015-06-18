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

	$USER = null;
	if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
	{
		$STH = $DBH->query("SELECT * FROM user WHERE id=".$_SESSION['id']." AND mail='".$_SESSION['user']."' AND password='".$_SESSION['p']."'");
		$STH->execute();
		$USER = $STH->fetch(PDO::FETCH_OBJ);
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
	$ValueOpenChest['value'][0] = 30;
	$ValueOpenChest['chance'][0] = 3;

	$ValueOpenChest['value'][1] = 10;
	$ValueOpenChest['chance'][1] = 12;

	$ValueOpenChest['value'][2] = 5;
	$ValueOpenChest['chance'][2] = 25;

	$ValueOpenChest['value'][3] = 1;
	$ValueOpenChest['chance'][3] = 60;

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
?>