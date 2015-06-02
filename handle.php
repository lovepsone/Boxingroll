<?php
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();

	if (isset($_GET['cmd']))
	{
		switch((int)$_GET['cmd'])
		{
			case 0: openbox($locale['shop_msg_sucess']); break;
			case 1: openbox($locale['shop_msg_err_cash']); break;
		}
	}
	else
	{
		Redirect(BASEDIR.'index.php', true);
	}

	closebox();
	require_once THEMES.'footer.php';
?>