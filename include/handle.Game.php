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
		    DBH_DeleteKey((int)$value);
		    break;
		  case 'getCountKey':
		    $result = getCountKey();
		    break;
		  case 'RoundValueOpenChest':
		    $result = RoundValueOpenChest();
		    break;
		  case 'DBH_AddRoundValue':
		    DBH_AddRoundValue($value);
		    break;
		}
		echo $result;

		if ($cmd == 'GameUpdateUser')
		{
			echo '<tr><td colspan="2" width="250px"><span class="boxRightTitle"><b>'.$locale['userStats'].'</b></span></td></tr>';
			echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['cSellKey'].'</td><td class="boxRightValue" align="right">'.$USER->SellKey.'</td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['cOpenChest'].'</td><td class="boxRightValue" align="right">'.$USER->OpenChest.'</td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['cKopeck'].'</td><td class="boxRightValue" align="right">'.$USER->Kopeck.'</td></tr>';
	
			echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['keys'].'</b></span></td></tr>';
			echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
			echo '<tr><td class="boxRightText" align="left" valing="middle">';
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/1.png" height="25px"/> x '.$USER->SellKeyNormal;
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/2.png" height="25px"/> x '.$USER->SellKeyGold;
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/3.png" height="25px"/> x '.$USER->SellKeyPlatinum;
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/4.png" height="25px"/> x '.$USER->SellKeyPremium;
			echo '</td><td class="boxRightValue" align="left"></td></tr>';
	
			echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['kopecks'].'</b></span></td></tr>';
			echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
			echo '<tr><td class="boxRightText" align="left" valing="middle">';
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/1.png" height="12px"/> x '.$USER->KopeckNormal;
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/2.png" height="12px"/> x '.$USER->KopeckGold;
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/3.png" height="12x"/> x '.$USER->KopeckPlatinum;
			echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/4.png" height="12px"/> x '.$USER->KopeckPremium;
			echo '</td><td class="boxRightValue" align="left"></td></tr>';
		}
	}
?>