<?php

	require_once '../maincore.php';

	$text = isset($_POST['data']) ? trim($_POST['data']) : '';
	if (!empty($text))
	{

		$text = preg_replace($locale['censure_chat'], $locale['censure_block'], $text);
		$STH = $DBH->prepare("INSERT INTO `chat` (`id_user`, `msg`, `msg_date`) VALUES (:u, :m, :d)");
		$STH->execute(array(':u' => (int)$_SESSION['id'], ':m' => $text, ':d' => date("Y-m-d H:i:s")));
	}

	$STH = $DBH->prepare("SELECT *, DATE_FORMAT(`msg_date`, '%H:%i:%s') AS redate FROM `chat` LEFT JOIN user ON `id_user`=`id` ORDER BY msg_date ASC LIMIT 40");
	$STH->execute();
	while($res = $STH->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="chat-bgmsg" align="left"><span>'.$res['nickname'].'['.$res['redate'].']:</span><br>'.$res['msg'].'</div><div style="height:3px;"></div>';
	}
?>