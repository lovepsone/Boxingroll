<?php
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();
	openbox($locale['NewsTitleLast']);

	$STH = $DBH->prepare("SELECT * FROM `news` ORDER BY `date` DESC limit ".$Config['CountNewsPage']);
	$STH->execute();

	while($row = $STH->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td align="center" valign="top"><hr width="90%"></td></tr>';
		echo '<tr><td><h1>'.$row['name'].'</h1></td></tr>';
		echo '<tr><td>'.$row['news'].'</td></tr>';
		echo '<tr><td>'.$row['date'].'</td></tr>';
		echo '<tr><td align="center" valign="top"><hr width="90%"></td></tr>';
	}
	closebox();
	require_once THEMES.'footer.php';
?>