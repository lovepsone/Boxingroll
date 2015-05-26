<?php

	if (isset($_POST['AuthReg']))
	{
		Redirect(BASEDIR.'reg.php?cmd=1', true);
	}

	function HeadMenu()
	{
		global $locnav, $locale, $_SESSION;
		/*$STH = $DBH->query("SELECT * FROM news WHERE id=(SELECT max(id) FROM news)");
		$STH->execute();
		$data = $STH->fetch(PDO::FETCH_ASSOC);*/
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
			echo '<input type="submit" id="AuthLogOut" value="'.$locale['b_logaut'].'" style="width:130px;margin-left:5px;" class="BoxButton" /></div>';
			echo '</td></tr></table></form>';
		}
		echo '</td></tr>';
		echo '</table>';
		// nav
		echo '<div width="100%" align="center">';
		echo '<div class="headNav">';
		echo '<a href="'.BASEDIR.'index.php">'.$locnav[1].'</a>';
		echo '<a href="'.BASEDIR.'game.php">'.$locnav[2].'</a>';
		echo '<a href="'.BASEDIR.'index.php">'.$locnav[3].'</a>';
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
		// start box left http://codediscuss.ru/blogs/14-ajax-chat-na-php-i-mysql
		echo '<td class="boxLeft" style="width:250px;" width="250px" align="center">';
		//echo '<div id="chat" data-last-id="0"></div><form id="chat-form"><textarea id="chat-msg"/></textarea><br><input type="submit" value="submit"  class="BoxButton" style="width:130px;"/></form>';
		echo '</td>'; // close left
		// start box center
		echo '<td height="100%" align="center">';
		echo '<table cellpadding="0" cellspacing="0" height="100%" width="100%" class="boxCenter"><tr><td colspan="10" class="boxTitle" align="center"><b>'.$title.'</b></td></tr>'; //center
	}

	function closebox()
	{
		global $locale, $_SESSION, $DBH;
		echo '<tr><td colspan="5" height="100%"></td></tr></table>';
		echo '</td>'; //close center
		// start box right
		echo '<td width="250px" style="width:250px;" align="left">';
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
			echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['overallStatsProject'].'</b></span></td></tr>';
			echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['overallCountUser'].'</td><td class="boxRightValue" align="right">0</td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['overallCountPaidCash'].'</td><td class="boxRightValue" align="right">0</td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['overallCountGameBox'].'</td><td class="boxRightValue" align="right">0</td></tr>';
			echo '<tr><td class="boxRightText">'.$locale['overallCountAddCash'].'</td><td class="boxRightValue" align="right">0</td></tr>';
			if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
			{
				$STH = $DBH->query("SELECT * FROM user WHERE id=".$_SESSION['id']." AND mail='".$_SESSION['user']."' AND password='".$_SESSION['p']."'");
				$STH->execute();
				$data = $STH->fetch(PDO::FETCH_OBJ);
				echo '<tr><td colspan="2"><span class="boxRightTitle"><b>'.$locale['userStats'].'</b></span></td></tr>';
				echo '<tr><td colspan="2" align="center"><hr width="90%"></td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cSellBox'].'</td><td class="boxRightValue" align="right">'.$data->cSellBox.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cOpenBox'].'</td><td class="boxRightValue" align="right">'.$data->cOpenBox.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cCloseBox'].'</td><td class="boxRightValue" align="right">'.$data->cCloseBox.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['CountCsh'].'</td><td class="boxRightValue" align="right">'.$data->CountCsh.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cAddCash'].'</td><td class="boxRightValue" align="right">'.$data->cAddCash.'</td></tr>';
				echo '<tr><td class="boxRightText">'.$locale['cOutCash'].'</td><td class="boxRightValue" align="right">'.$data->cOutCash.'</td></tr>';
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
?>

