<?php
	require_once '../maincore.php';
	require_once THEMES.'header.admin.php';
	HeadMenu();
	openbox($locale['AdminTN']);

	if (isset($_GET['cmd']) && $_GET['cmd'] == 1)
	{
		if (isset($_POST['addnews']))
		{
			$STH = $DBH->prepare("INSERT INTO `news`(`name`, `news`, `date`) VALUES (:n1, :n2, :d)");
			$STH->execute(array('n1' => $_POST['NameNews'], 'n2' => $_POST['news'], 'd' => date("Y-m-d")));
			Redirect(ADMINS.'handle.php?cmd=addnews', true);
		}
		else
		{
			echo '<form method="post">';
			echo '<tr><td align="center" valign="top"><hr width="60%"></td></tr>';
			echo '<tr><td align="center" height="60px"><input type="text" name="NameNews" class="inputAuth" value="'.$locale['AdminTitleNews'].'" style="width:550px;"/></td></tr>';
			echo '<tr><td align="center"><textarea id="txt" name="news"></textarea></td></tr>';
			echo '<tr><td align="center" height="60px"><input type="submit" name="addnews" value="'.$locale['AdminNewsAdd'].'" style="width:150px;" class="BoxButton" /></td></tr>';
			echo '</form>';
		}

	}
	else if (isset($_GET['cmd']) && $_GET['cmd'] == 2)
	{
		$editlist = '';
		$STH = $DBH->prepare("SELECT * FROM `news`");
		$STH->execute();

		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			$editlist .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}

		if (isset($_POST['newsselect']) && isset($_POST['id']))
		{
			$STH = $DBH->query("SELECT * FROM news WHERE id=".(int)$_POST['id']);
			$STH->execute();
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			echo '<form method="post">';
			echo '<tr><td align="center" valign="top"><hr width="60%"></td></tr>';
			echo '<tr><td align="center" height="60px"><input type="text" name="editNameNews" class="inputAuth" value="'.$row['name'].'" style="width:550px;"/></td></tr>';
			echo '<tr><td align="center"><textarea id="txt" name="news">'.$row['news'].'</textarea></td></tr>';
			echo '<tr><td align="center" height="60px"><input type="submit" name="editnews" value="'.$locale['AdminNewsEdit'].'" style="width:150px;" class="BoxButton" /><input type="hidden" name="idEditNews" value="'.(int)$_POST['id'].'"></td></tr>';
			echo '</form>';
		}
		else if (isset($_POST['editnews']))
		{
			$STH = $DBH->prepare("UPDATE news SET name=:n1, news=:n2, date=:d WHERE id=:id");
			$STH->execute(array('n1' => $_POST['editNameNews'], 'n2' => $_POST['news'], 'd' => date("Y-m-d"), 'id' => (int)$_POST['idEditNews']));
			Redirect(ADMINS.'handle.php?cmd=editnews', true);
		}
		else if (isset($_POST['delnews']) && isset($_POST['id']))
		{
			$STH = $DBH->query("DELETE FROM `news` WHERE (`id`='".(int)$_POST['id']."')");
			$STH->execute();
			Redirect(ADMINS.'handle.php?cmd=delnews', true);
		}
		else
		{
			echo '<form method="post">';
			echo '<tr><td align="center" valign="top"><hr width="60%"></td></tr>';
			echo '<tr><td align="center" height="50px"><select name="id" class="textbox" style="width:450px">'.$editlist.'</select></td></tr>';
			echo '<tr><td align="center" height="50px"><input type="submit" name="newsselect" value="'.$locale['AdminNewsEdit'].'" style="width:170px;" class="BoxButton" />';
			echo '<input type="submit" name="delnews" value="'.$locale['AdminNewsDel'].'" style="width:170px;" class="BoxButton" /></td></tr>';
			echo '</form>';
		}
	}
	else
	{
		Redirect(ADMINS.'index.php', true);
	}

	closebox();
	require_once THEMES.'footer.php';
?>