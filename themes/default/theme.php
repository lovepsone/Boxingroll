<?php

	if (isset($_POST['AuthReg']))
	{
		Redirect(BASEDIR.'reg.php?cmd=1', true);
	}

	function HeadMenu()
	{
		global $locnav, $locale, $DBH, $_SESSION;
		$STH = $DBH->query("SELECT * FROM news WHERE id=(SELECT max(id) FROM news)");
		$STH->execute();
		$data = $STH->fetch(PDO::FETCH_ASSOC);
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
			$STH = $DBH->query("SELECT * FROM user WHERE id=".$_SESSION['id']." AND mail='".$_SESSION['user']."' AND password='".$_SESSION['p']."'");
			$STH->execute();
			$d = $STH->fetch(PDO::FETCH_OBJ);
			$tips = '<table>';
			$tips .= '<tr><td>'.$locale['cOpenBox'].'</td><td>0</td></tr>';
			$tips .= '<tr><td>'.$locale['cCloseBox'].'</td><td>0</td></tr>';
			$tips .= '<tr><td>'.$locale['cAddCash'].'</td><td>0</td></tr>';
			$tips .= '<tr><td>'.$locale['cOutCash'].'</td><td>0</td></tr>';
			$tips .= '<tr><td>'.$locale['CountCsh'].'</td><td>0</td></tr>';
			$tips .= '</table>';
			echo '<form id="logform" method="post"><table width="560px" border="0px" style="position:relative;margin-left:5%;"><tr><td>';
			echo '<div id="UserData"><input type="button" value="'.$locale['data'].'" style="width:130px;margin-left:5px;" class="BoxButton tips" title="'.$tips.'"/>';
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
		echo '<table width="100%"><tr><td align="center">';
		echo '<table class="boxbg" align="center">';
		echo '<tr><td colspan="10" class="boxTitle" align="center" valign="bottom"><b>'.$title.'</b></td></tr>';
	}

	function closebox()
	{
		echo '</td></tr><tr><td height="100%" colspan="10"></td></tr></table>';
		echo '</table>';
	}

?>

