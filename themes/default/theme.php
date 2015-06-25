<?php

	if (isset($_POST['AuthReg']))
	{
		Redirect(BASEDIR.'reg.php?cmd=1', true);
	}

	if (isset($_POST['AuthLogOut']))
	{
		unset($_SESSION['user']);
		unset($_SESSION['id']);
		unset($_SESSION['name']);
		unset($_SESSION['gmlevel']);
		unset($_SESSION['p']);
		Redirect(BASEDIR.'index.php', true);
	}
	function HeadMenu()
	{
		global $locnav, $locale, $_SESSION;

		echo '<table cellpadding="0" cellspacing="0"  class="HeadBody" border="0px">';
		echo '<tr height="89px"><td class="HeadBodyLeft">Logotips</td>';
		echo '<td width="760px" class="HeadBodyRight" align="left">';
		echo '<div id="user"></div>';
		if (!isset($_SESSION['user']) && !isset($_SESSION['id']) && !isset($_SESSION['p']))
		{
			echo '<form id="logform" method="post"><table width="560px" border="0px" style="position:relative;margin-left:4%;"><tr><td>';
			echo '<input type="text" id="AuthMail" class="inputAuth" value="Mail"/>';
			echo '<input type="password" id="AuthPass" class="inputAuth" value="Password" style="margin-left:5px;"/>';
			echo '<input type="submit" id="AuthStart" value="'.$locale['b_auth'].'" style="width:140px;margin-left:5px;" class="BoxButton" />';
			echo '<input type="submit" name="AuthReg" value="'.$locale['b_reg'].'" style="width:140px;margin-left:5px;" class="BoxButton" />';
			echo '</td></tr></table></form>';
		}
		else if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
		{
			echo '<form id="logform" method="post"><table width="560px" border="0px" style="position:relative;margin-left:5%;"><tr><td>';
			echo '<div id="UserData"><input type="button" value="'.$locale['data'].'" style="width:130px;margin-left:5px;" class="BoxButton tips"/>';
			echo '<input type="submit" id="AddCash" value="'.$locale['b_add_cash'].'" style="width:130px;margin-left:5px; text-decoration:line-through;" class="BoxButton" />';
			echo '<input type="submit" id="OutCash" value="'.$locale['b_out_cash'].'" style="width:130px;margin-left:5px; text-decoration:line-through;" class="BoxButton" />';
			echo '<input type="submit" name="AuthLogOut" value="'.$locale['b_logaut'].'" style="width:130px;margin-left:5px;" class="BoxButton" /></div>';
			echo '</td></tr></table></form>';
		}
		echo '</td></tr>';
		echo '</table>';
		// nav
		echo '<div width="100%" align="center">';
		echo '<div class="headNav">';
		echo '<a href="'.BASEDIR.'index.php">'.$locnav[1].'</a>';
		echo '<a href="'.BASEDIR.'game.php">'.$locnav[2].'</a>';
		echo '<a href="'.BASEDIR.'shop.php">'.$locnav[3].'</a>';
		echo '<a href="'.BASEDIR.'index.php">'.$locnav[4].'</a>';
		echo '<a href="'.BASEDIR.'index.php">'.$locnav[5].'</a>';
		echo '</div>';
		echo '</div>';
	}

	function Footer()
	{
		echo '<div class="footer"><div style="text-align:center">Copyright &copy; 2015 <a href="'.BASEDIR.'index.php" style="text-decoration: none;">Boxing Roll<a> by LovePSone</div></div>';
	}

	function openbox($title = "")
	{
		global $locale;
		echo '<table width="100%" class="MainBg" cellpadding="0" cellspacing="0"><tr><td>';

		echo '<table width="100%" cellpadding="0" cellspacing="0"><tr>';
		// start box left
		echo '<td width="250px" align="right" valign="top">';

		echo '<table cellpadding="0" cellspacing="0" width="100%" class="boxLeft">';
		echo '<tr><td colspan="2" align="right"><span class="boxLeftTitle"><b>'.$locale['chat'].'</b></span></td></tr>';
		echo '<tr><td align="center">';
		echo '<div id="chat"></div><br>';
		if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']) && defined("GAME_PAGE") && !GAME_PAGE)
		{
			echo '<form id="chat-form"><textarea id="chat-msg" style="width:230px;"></textarea><br><input type="submit" value="'.$locale['chat_Button'].'"  class="BoxButton" style="width:130px;"/></form>';
		}
		else if (defined("GAME_PAGE") && GAME_PAGE)
		{
			echo '<div>'.$locale['GameNonChat'].'</div>';
		}
		else
		{
			echo '<div>'.$locale['chat_non_msg'].'</div>';
		}
		echo '</td></tr>';
		echo '<tr><td colspan="2" height="100%"></td></tr>';
		echo '</table>';

		echo '</td>'; // close left
		// start box center
		echo '<td height="100%" align="center">';
		if (defined("GAME_PAGE") && GAME_PAGE)
		{
			echo '<table cellpadding="0" cellspacing="0" height="100%" width="100%" class="boxCenterGame">';
		}
		else
		{
			echo '<table cellpadding="0" cellspacing="0" height="100%" width="100%" class="boxCenter"><tr><td colspan="10" class="boxTitle" align="center"><b>'.$title.'</b></td></tr>'; //center
		}
	}

	function closebox()
	{
		global $locale, $_SESSION, $DBH, $USER, $Config;
		echo '<tr><td colspan="5" height="100%"></td></tr></table>';
		echo '</td>'; //close center
		// start box right
		echo '<td width="250px" align="left" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" width="100%" class="boxRight">';
		if (ADMIN_PANEL)
		{
			echo '<tr><td><span class="boxRightTitle"><b>'.$locale['AdminPanel'].'</b></span></td></tr>';
			echo '<tr><td align="center"><hr width="90%"></td></tr>';
			echo '<tr><td align="center"><a href="'.BASEDIR.'admin/index.php">'.$locale['AdminSettings'].'</a></td></tr>';
			echo '<tr><td align="center"><hr width="90%"></td></tr>';
			echo '<tr><td><span class="boxRightTitle"><b>'.$locale['AdminNews'].'</b></span></td></tr>';
			echo '<tr><td align="center"><hr width="90%"></td></tr>';
			echo '<tr><td align="center"><a href="'.BASEDIR.'admin/news.php?cmd=1">'.$locale['AdminNewsAdd'].'</a></td></tr>';
			echo '<tr><td align="center"><a href="'.BASEDIR.'admin/news.php?cmd=2">'.$locale['AdminNewsEdit'].'</a></td></tr>';
			echo '<tr><td align="center"><hr width="90%"></td></tr>';
		}
		else
		{
			if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
			{
				if (defined("GAME_PAGE") && !GAME_PAGE)
				{
					echo '<tr><td colspan="2" width="250px"><span class="boxRightTitle"><b>'.$locale['userStats'].'</b></span></td></tr>';
					echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
					echo '<tr><td class="boxRightText">'.$locale['cSellKey'].'</td><td class="boxRightValue" align="right">'.$USER->SellKey.'</td></tr>';
					echo '<tr><td class="boxRightText">'.$locale['cOpenChest'].'</td><td class="boxRightValue" align="right">'.$USER->OpenChest.'</td></tr>';
					echo '<tr><td class="boxRightText">'.$locale['cKopeck'].'</td><td class="boxRightValue" align="right">'.$USER->Kopeck.'</td></tr>';
					echo '<tr><td class="boxRightText">'.$locale['IncomeCash'].'</td><td class="boxRightValue" align="right">'.$USER->IncomeCash.'</td></tr>';
	
					echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['keys'].'</b></span></td></tr>';
					echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
					echo '<tr><td colspan="2" class="boxRightText" align="left" valing="middle">';
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/1.png" height="25px"/> x '.$USER->SellKeyNormal;
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/2.png" height="25px"/> x '.$USER->SellKeyGold;
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/3.png" height="25px"/> x '.$USER->SellKeyPlatinum;
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/key/4.png" height="25px"/> x '.$USER->SellKeyPremium;
					echo '</td></tr>';
	
					echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['kopecks'].'</b></span></td></tr>';
					echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
					echo '<tr><td colspan="2" class="boxRightText" align="left" valing="middle">';
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/1.png" height="12px"/> x '.$USER->KopeckNormal;
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/2.png" height="12px"/> x '.$USER->KopeckGold;
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/3.png" height="12x"/> x '.$USER->KopeckPlatinum;
					echo '&nbsp;&nbsp;<img src="'.BASEDIR.'images/kopeck/4.png" height="12px"/> x '.$USER->KopeckPremium;
					echo '</td></td></tr>';
				}
				else
				{
					echo '<tr><td colspan="10" style="padding: 0px;" width="100%"><table cellpadding="0" cellspacing="0" width="100%"><div id="GameUpdateUser" style="width:100%"></div></table></td></tr>';
				}
				echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['lables'].'</b></span></td></tr>';
				echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
				if (strtotime($USER->TimerVipLabelPirate) > strtotime(date("Y-m-d H:i:s")))
				{
					$countSek = strtotime($USER->TimerVipLabelPirate) - strtotime(date("Y-m-d H:i:s"));
					$val = $countSek*100/$Config['CountSecondsLabelPirate'];
					echo '<tr><td colspan="2" class="boxRightText" align="left" valing="middle">&nbsp;&nbsp;';
					echo '<img src="'.BASEDIR.'images/label/2.png" height="30px" style="position:relative; top: 10px;"/>&nbsp;&nbsp;'.$locale['hplables'];
					echo '&nbsp;&nbsp;<meter value="'.$val.'" max="100" low="10" high="70">'.$val.' %</meter>';
					echo '</td></td></tr>';
				}
				else if ($USER->ContLabelPirate > 0)
				{
					$val = $USER->ContLabelPirate*100/$Config['CountKeyLabelPirate'];
					echo '<tr><td colspan="2" class="boxRightText" align="left" valing="middle">&nbsp;&nbsp;';
					echo '<img src="'.BASEDIR.'images/label/1.png" height="30px" style="position:relative; top: 10px;"/>&nbsp;&nbsp;'.$locale['hplables'];
					echo '&nbsp;&nbsp;<meter value="'.$val.'" max="100" low="10" high="70">'.$val.' %</meter>';
					echo '</td></td></tr>';
				}
				else
				{
					$val = strtotime($USER->DateLabelPirate)+ 30*24*60*60 - strtotime(date("Y-m-d H:i:s"));
					$val = round(($val/60)/60, 1);
					echo '<tr><td colspan="2" class="boxRightText" align="left" valing="middle">&nbsp;&nbsp;';
					echo '<img src="'.BASEDIR.'images/label/3.png" height="30px" style="position:relative; top: 10px;"/>&nbsp;&nbsp;'.$locale['dellables'];
					echo '<br>&nbsp;'.$locale['timelables'].'&nbsp;'.$val;
					echo '</td></td></tr>';	
				}
				echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['CashInfo'].'</b></span></td></tr>';
				echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['CountCsh'].'</td><td class="boxRightValue" align="right">'.$USER->CountCsh.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cAddCash'].'</td><td class="boxRightValue" align="right">'.$USER->cAddCash.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cOutCash'].'</td><td class="boxRightValue" align="right">'.$USER->cOutCash.'</td></tr>';
			}
			else
			{
				echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['overallStatsProject'].'</b></span></td></tr>';
				echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['overallCountUser'].'</td><td class="boxRightValue" align="right">0</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['overallCountPaidCash'].'</td><td class="boxRightValue" align="right">0</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['overallCountGameBox'].'</td><td class="boxRightValue" align="right">0</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['overallCountAddCash'].'</td><td class="boxRightValue" align="right">0</td></tr>';
			}
			echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
			if (isset($_SESSION['gmlevel']) && $_SESSION['gmlevel'] > 3 && isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
			{
				echo '<tr><td colspan="2" align="center"><a href="'.BASEDIR.'admin/index.php">'.$locale['AdminPanel'].'</a></td></tr>';
			}
			else if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
			{
				// ������ �� ��� �������
			}
		}
		echo '<tr><td colspan="2" height="100%"></td></tr>';
		echo '</table>';
		echo '</td></tr></table>'; //right

		echo '</td></tr></table>';
	}

	function RedirectBox($url)
	{
		global $locale;
		echo '<tr><td align="center" width="100%">'.$locale['redirect'].'</td></tr>';
		RedirectTime($url);
	}
?>

