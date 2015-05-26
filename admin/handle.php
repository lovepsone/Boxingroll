<?php
	require_once '../maincore.php';
	require_once THEMES.'header.admin.php';
	HeadMenu();
	if (isset($_GET['cmd']) && $_GET['cmd'] == 'addnews')
	{
		openbox($locale['AdminNewsAddSucces']);
	}
	else if (isset($_GET['cmd']) && $_GET['cmd'] == 'editnews')
	{
		openbox($locale['AdminNewsEditSucces']);
	}
	else if (isset($_GET['cmd']) && $_GET['cmd'] == 'delnews')
	{
		openbox($locale['AdminNewsDelSucces']);
	}
	closebox();
	require_once THEMES.'footer.php';
?>