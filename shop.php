<?php
	define("GAME_PAGE", false);
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();

	$DataKey = getDataKey();
	$DataLable = array(
	0 => array('img' => 'images/label/1.png', 'locale' => $locLabel[0], 'cost' => $Config['CostLabelPirate1']),
	1 => array('img' => 'images/label/2.png', 'locale' => $locLabel[1], 'cost' => $Config['CostLabelPirate2'])
	);

	if (isset($_POST['BuyKey']) && isset($_POST['CountBuyKey']) && (int)$_POST['CountBuyKey'] > 0 && isset($_POST['BuyKey']))
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
			openbox($locale['shop_msg_sucess']);
			RedirectBox(BASEDIR.'shop.php');
		}
		else
		{
			openbox($locale['shop_msg_err_cash']);
			RedirectBox(BASEDIR.'shop.php');
		}
		
	}
	else if (isset($_POST['BuyLable']))
	{
		$iLables = (int)$_POST['lables'];
		if ($DataLable[$iLables]['cost'] <= $USER->CountCsh)
		{
			if ($iLables == 0)
			{
				$darr = array();
				$darr['id'] = $USER->id;
				$darr['cc'] = $USER->CountCsh - $DataLable[$iLables]['cost'];
				$darr['clp'] = $USER->ContLabelPirate + $Config['CountKeyLabelPirate'];

				$STH = $DBH->prepare("UPDATE user SET CountCsh=:cc, ContLabelPirate=:clp WHERE id=:id");
				$STH->execute($darr);
				Redirect(BASEDIR.'handle.php?cmd=0', true);
			}
			else if ($iLables == 1)
			{
				$darr = array();
				$darr['id'] = $USER->id;
				$darr['cc'] = $USER->CountCsh - $DataLable[$iLables]['cost'];
				if ($USER->TimerVipLabelPirate > date("Y-m-d H:i:s"))
				{
					$darr['d'] = date("Y-m-d H:i:s", strtotime("+".$Config['CountDayLabelPirate']." day", strtotime($USER->TimerVipLabelPirate)));
				}
				else
				{
					$darr['d'] = date("Y-m-d H:i:s", strtotime("+".$Config['CountDayLabelPirate']." day", strtotime(date("Y-m-d H:i:s"))));
				}

				$STH = $DBH->prepare("UPDATE user SET CountCsh=:cc, TimerVipLabelPirate=:d WHERE id=:id");
				$STH->execute($darr);
				openbox($locale['shop_msg_sucess']);
				RedirectBox(BASEDIR.'shop.php');
			}
			else
			{
				openbox($locale['shop_msg_err_cash']);
				RedirectBox(BASEDIR.'shop.php');
			}
		}
		else
		{
			openbox($locale['shop_msg_err_cash']);
			RedirectBox(BASEDIR.'shop.php');
		}
	}
	else
	{
		openbox($locnav[3]);
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

		echo '<tr><td align="center" colspan="10" height="30px"><hr size="2"></td></tr>';

		for ($i = 0; $i < count($DataLable); $i++)
		{
			$check = '';
			if ($i == 0) $check = 'checked';
			echo '<tr height="100px"><td align="center" class="shop" width="60px"><img src="'.BASEDIR.$DataLable[$i]['img'].'" height="35px"/><td>';
			echo '<td align="left" class="shop">'.$DataLable[$i]['locale'].'</td>';
			echo '<td align="center" class="shop" width="160px">'.$locale['CostKey'].'&nbsp;&nbsp;'.$DataLable[$i]['cost'].'&nbsp;p.</td>';
			echo '<td align="center" class="shop" width="60px"><input name="lables" type="radio" value="'.$i.'" '.$check.'>&nbsp;</td></tr>';
		}
		if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
		{
			echo '<tr><td colspan="5" align="center" class="shop" height="30px"><input type="submit" name="BuyLable" value="'.$locale['buy'].'" style="width:170px;" class="BoxButton" /></td></tr>';
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