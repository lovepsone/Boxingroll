<?php

	require_once 'maincore.php';
	require_once THEMES.'header.php';
	if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
		Redirect(BASEDIR.'index.php', true);
	HeadMenu();

	openbox($locale['b_reg']);
	$_SESSION['ERROR_REG'] = 0; $s = ''; $p = '';
	if (isset($_POST['register']) && ($_POST['register'] == '1') && !$_SESSION['ERROR_REG'] && $_POST['kapcha'] == $_SESSION['rand_code'])
	{
		//nickname
		$nickname = $_POST['mail'];
		$position = 0;
		for ($i = 0; $i < strlen($nickname); $i++)
		{
			if ($nickname[$i] == '@')
				$position = $i;
		}
		$nickname = substr($nickname, 0, $position - 1);

		$s = GenSalt();
		$p = SHA1(md5($_POST['pass1']) + $s);
		$STH = $DBH->prepare("INSERT INTO `user`(`nickname`, `mail`, `password`, `salt`, `date`) VALUES (:n, :m, :p, :s, :d)");
		$STH->execute(array('n' => $nickname, 'm' => $_POST['mail'], 'p' => $p, 's' => $s, 'd' => date("Y-m-d")));
		echo '<tr><td align="center" valign="top" colspan="2"><br><hr width="60%"><br><h1>'.$locale['reg_sucess'].'</h1><hr width="60%"></td></tr>';

	}
	// вывести что капта введена не верно
	elseif (isset($_GET['cmd']) && $_GET['cmd'] == 1)
	{
			echo '<tr><td align="center" valign="top"><hr width="60%"></td></tr>';
			echo '<tr><td align="center" valign="center">tyt pravila</td></tr>';
			echo '<tr><td align="center"><hr width="60%"></td></tr>';
			echo '<tr><td align="center" valign="top" class="Box">';
			echo '<a href="'.BASEDIR.'reg.php?cmd=2">'.$locale['b_accept'].'</a> | <a href="index.php">'.$locale['b_non'].'</a>';
			echo '</td></tr>';
	}
	else if(isset($_GET['cmd']) && $_GET['cmd'] == 2)
	{
		echo "<form method=post>";
		echo '<input name="register" value="1" type="hidden">';
		echo '<tr><td align="center" valign="top" colspan="2"><br><hr width="60%"><br></td></tr>';
		echo '<tr><td align="right" width="50%">'.$locale['reg_mail'].'&nbsp;&nbsp;</td><td><input id="regMail" name="mail" type="text" class="inputAuth" style="width:120px;" value=""/>&nbsp;&nbsp;<img id="LoaderRegMail" src="'.BASEDIR.'images/ajax-loader.gif"></td></tr>';
		echo '<tr><td align="right">'.$locale['reg_pass1'].'&nbsp;&nbsp;</td><td><input type="password" name="pass1" class="inputAuth" style="width:120px;" value=""/></td></tr>';
		echo '<tr><td align="right">'.$locale['reg_pass2'].'&nbsp;&nbsp;</td><td><input type="password" name="pass2" class="inputAuth" style="width:120px;" value=""/></td></tr>';
		echo '<tr><td align="right"><img src="'.INCLUDES.'captcha.php" /></td><td><input name="kapcha" type="text" class="inputAuth" style="width:120px;" value=""/></td></tr>';
		echo '<tr><td colspan="2" align="center"><br><input type="submit" value="'.$locale['registre'].'" style="width:160px;" class="BoxButton"></td></tr>';
		echo '<tr><td align="center" valign="top" colspan="2"><br><hr width="60%"></td></tr>';
		echo '</form>';
	}
	else
	{
		Redirect(BASEDIR.'reg.php?cmd=1', true);
	}
	closebox();
	require_once THEMES.'footer.php';
?>