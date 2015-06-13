<?php
	define("GAME_PAGE", false);
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();
	openbox($locale['NewsTitleLast']);

	$STH = $DBH->prepare("SELECT * FROM `news` ORDER BY `date` DESC limit ".$Config['CountNewsPage']);
	$STH->execute();

	while($row = $STH->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td align="center" valign="top"><hr class="NewsHeadHR" size="5"></td></tr>';
		echo '<tr><td class="NewsHead"><h1>'.$row['name'].'</h1></td></tr>';
		echo '<tr><td align="center" valign="top"><hr class="NewsHeadHR" size="5"></td></tr>';
		echo '<tr><td class="NewsBody">'.$row['news'].'</td></tr>';
		echo '<tr><td class="NewsFotter" align="right">'.$row['date'].'</td></tr>';
	}
	closebox();
	require_once THEMES.'footer.php';
?>