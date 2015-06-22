<?php
	define("GAME_PAGE", false);
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();
	openbox($locnav[3]);

	$countBox = explode(",", $Config['countBox']);

	$DataKey = array();
	$TypeKeyCash = explode(",", $Config['TypeKeyCash']);
	for ($i = 0; $i < count($TypeKeyCash); $i++)
	{
		$tmp = explode(":",  $TypeKeyCash[$i]);
		$DataKey[$i] = array('id' => $tmp[0], 'cost' => $tmp[1]);
	}

	if (isset($_POST['BuyKey']) && isset($_POST['CountBuyKey']) && (int)$_POST['CountBuyKey'] > 0)
	{
		// проверка кеша
		$CountBuyKey = (int)$_POST['CountBuyKey'];
		$TypeKey = (int)$_POST['keys'];
		$cash = $CountBuyKey * $DataKey[$TypeKey - 1]['cost'];
		if ($cash <= $USER->CountCsh)
		{
			//type box
			$darr = array(); $sql = "";

			$darr['id'] = $USER->id;
			$darr['s1'] = $USER->SellKey + $CountBuyKey;
			$darr['cc'] = $USER->CountCsh - $cash;

			switch($TypeKey)
			{
				case 1:
					$darr['s2'] = $USER->SellKeyNormal + $CountBuyKey;
					$sql = "UPDATE user SET SellKey=:s1, SellKeyNormal=:s2, CountCsh=:cc WHERE id=:id";
					break;
				case 2:
					$darr['s2'] = $USER->SellKeyGold + $CountBuyKey;
					$sql = "UPDATE user SET SellKey=:s1, SellKeyGold=:s2, CountCsh=:cc WHERE id=:id";
					break;
				case 3:
					$darr['s2'] = $USER->SellKeyPlatinum + $CountBuyKey;
					$sql = "UPDATE user SET SellKey=:s1, SellKeyPlatinum=:s2, CountCsh=:cc WHERE id=:id";
					break;
				case 4:
					$darr['s2'] = $USER->SellKeyPremium + $CountBuyKey;
					$sql = "UPDATE user SET SellKey=:s1, SellKeyPremium=:s2, CountCsh=:cc WHERE id=:id";
					break;
			}
			$STH = $DBH->prepare($sql);
			$STH->execute($darr);
			Redirect(BASEDIR.'handle.php?cmd=0', true);
		}
		else
		{
			Redirect(BASEDIR.'handle.php?cmd=1', true);
		}
		
	}
	else
	{
		echo '<form method="post">';
		echo '<tr><td align="center" colspan="10" valign="top"><hr size="2"></td></tr>';
	
	
		for ($i = 0; $i < count($DataKey); $i++)
		{
			$check = '';
			if ($i == 0) $check = 'checked';
			echo '<tr height="100px"><td align="center" class="shop" width="60px"><img src="'.BASEDIR.'images/key/'.$DataKey[$i]['id'].'.png" height="45px"/><td>';
			echo '<td align="left" class="shop">'.$locKey[$DataKey[$i]['id']].'</td>';
			echo '<td align="center" class="shop" width="160px">'.$locale['CostKey'].'&nbsp;&nbsp;'.$DataKey[$i]['cost'].'&nbsp;p.</td>';
			echo '<td align="center" class="shop" width="60px"><input name="keys" type="radio" value="'.$DataKey[$i]['id'].'" '.$check.'>&nbsp;</td></tr>';
	
		}
		
		if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
		{
			echo '<tr><td colspan="5" align="center" class="shop" height="30px">'.$locale['count'].'&nbsp;&nbsp;<input type="text" name="CountBuyKey" value="1" style="width:100px;" />';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="BuyKey" value="'.$locale['buy'].'" style="width:170px;" class="BoxButton" /></td></tr>';
		}
		else
		{
			echo '<tr><td colspan="5" align="center" height="30px"><span class="shop-msg">'.$locale['shop_msg_auth'].'</span></td></tr>';
		}

		echo '</form>';
	}
	closebox();
	require_once THEMES.'footer.php';
?>