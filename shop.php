<?php
	define("GAME_PAGE", false);
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();
	openbox($locnav[3]);

	$countBox = explode(",", $Config['countBox']);
	$countCost = explode(",", $Config['countCost']);

	if (isset($_POST['BuyBox']) && isset($_POST['cost']) && $_POST['cost'] > 0)
	{
		// проверка кеша
		$cash = (int)$_POST['cost'] * (int)$_POST['box'];
		if ($cash <= $USER->CountCsh)
		{
			//type box
			$typebox = 0; $darr = array(); $sql = "";
			for ($i = 0; $i < count($countCost); $i++)
			{
				if ($countCost[$i] == $_POST['cost']) $typebox = $i;
			}

			$darr['id'] = $USER->id;
			$darr['s1'] = $USER->SellKey + $_POST['box'];
			$darr['cc'] = $USER->CountCsh - $cash;

			switch($typebox)
			{
				case 0:
					$darr['s2'] = $USER->SellKeyNormal + (int)$_POST['box'];
					$sql = "UPDATE user SET SellKey=:s1, SellKeyNormal=:s2, CountCsh=:cc WHERE id=:id";
					break;
				case 1:
					$darr['s2'] = $USER->SellKeyGold + (int)$_POST['box'];
					$sql = "UPDATE user SET SellKey=:s1, SellKeyGold=:s2, CountCsh=:cc WHERE id=:id";
					break;
				case 2:
					$darr['s2'] = $USER->SellKeyPlatinum + (int)$_POST['box'];
					$sql = "UPDATE user SET SellKey=:s1, SellBKeyPlatinum=:s2, CountCsh=:cc WHERE id=:id";
					break;
				case 3:
					$darr['s2'] = $USER->SellKeyPremium + (int)$_POST['box'];
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
		echo '<tr><td align="center" valign="top"><hr size="5"></td></tr>';
	
		$listCost = '';
	
		for ($i = 0; $i < count($countCost); $i++)
		{
			$listCost .= '<option value="'.$countCost[$i].'">'.$countCost[$i].'&nbsp;p.</option>';
		}
	
		for ($i = 0; $i < count($countBox); $i++)
		{
			$check = '';
			if ($i == 0) $check = 'checked';
			echo '<tr><td align="center" class="shop" height="30px"><input name="box" type="radio" value="'.$countBox[$i].'" '.$check.'>&nbsp;x'.$countBox[$i].'&nbsp;'.$locale['SellKeys'].'</td></tr>';
	
		}
		echo '<tr><td align="center" class="shop" height="30px">'.$locale['CostKeysType'].'&nbsp;<select name="cost" class="textbox" style="width:250px">'.$listCost.'</select></td></tr>';
		if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
		{
			echo '<tr><td align="center" class="shop" height="30px"><input type="submit" name="BuyBox" value="'.$locale['buy'].'" style="width:170px;" class="BoxButton" /></td></tr>';
		}
		else
		{
			echo '<tr><td align="center" height="30px"><span class="shop-msg">'.$locale['shop_msg_auth'].'</span></td></tr>';
		}
		echo '</form>';
	}
	closebox();
	require_once THEMES.'footer.php';
?>