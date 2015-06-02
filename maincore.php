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

?>