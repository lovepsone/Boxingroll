<?php

	require_once '../maincore.php';

    // получаем id последнего сообщения
    $last_id = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;
    
    // текст
    $text = isset($_POST['text']) ? trim($_POST['text']) : '';
    if (!empty($text)) {
        // вставка новой записи
        $sth = $dbh->prepare("INSERT INTO `chat` (`msg`) VALUES (:text)");
        $sth->execute(array(':text' => $text));
    }

    // загружаем сообщения, которые были после последнего полученного нами, но не более 20
    $STH = $DBH->prepare("SELECT * FROM `chat` WHERE `id_msg` > :last_id ORDER BY `id` DESC LIMIT 20");
     $STH->bindParam(':last_id', $last_id, PDO::PARAM_INT);
     $STH->execute();
    
    // отдаём массив сообщений в формате JSON
    echo json_encode(array_reverse($sth->fetchall()));

?>