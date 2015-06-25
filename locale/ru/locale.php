﻿<?
$locale = array();
$locnav = array();
$locKey = array();
$locLabel = array();

$locnav[1] = 'Главная';
$locnav[2] = 'Играть';
$locnav[3] = 'Магазин';
$locnav[4] = 'Сылка 4';
$locnav[5] = 'Сылка 5';

$locKey[1] = '<span style="color:#B6B5B4">Key Normal</span> - ключ обычного типа. Среди пиратов пользуется малым спросам, так как в покупке очень дешевый. В основном часто используют новички.';
$locKey[2] = '<span style="color:#EBC85D">Key Gold</span> - ключ золотого типа. В руках пирата ходовой ключ. Спрос на этот ключ немного больше. Ключ данного типа подходит для более опытных пиратов.';
$locKey[3] = '<span style="color:#7E757F">Key Platinum</span> - ключ типа метал. Редкий ключ для новичка и опытного пирата. На рынке пиратов стоит немалых денег, но цена оправдывает себя.';
$locKey[4] = '<span style="color:#BF997C">Key Premium</span> - ключ Веселого Роджера. Ключ сделан из драгоценного металла. На рынке такого ключа не найти. Только профи имеют данный ключ.';

$locLabel[0] = 'Метка пирата на '.$Config['CountLabelPirate1'].' ключей. Метка дает возможность покупать ключи. Если у Вас нет метки - вы не пират!!!';
$locLabel[1] = 'Легендарная метка пирата на 30 дней. Позволяет покупать бесконечное число ключей в течении 30 дней. Если у Вас нет метки - вы не пират!!!';

$locale['auth'] = 'Авторизация';
$locale['name'] = 'e-mail: ';
$locale['pass'] = 'пароль: ';
$locale['b_auth'] = 'Войти';
$locale['b_reg'] = 'Регистрация';
$locale['b_accept'] = 'Принимаю';
$locale['b_non'] = 'Отказываюсь';
$locale['b_no'] = 'Нет';
$locale['reg_mail'] = 'e-Mail: ';
$locale['reg_pass1'] = 'Пароль: ';
$locale['reg_pass2'] = 'Повторите пароль: ';
$locale['registre'] = 'зарегистрироваться';
$locale['IncomeCash'] = 'Общая прибыль:';
$locale['CostKey'] = 'цена:';
$locale['buy'] = 'Купить';
$locale['count'] = 'Количество:';
$locale['chat'] = 'Мини-Чат';
$locale['chat_Button'] = 'Отправить';
$locale['chat_non_msg'] = 'Для общения в чате требуется Авторизация!!!';
$locale['censure_chat'] = "/\w{0,5}[хx]([хx\s\!@#\$%\^&*+-\|\/]{0,6})[уy]([уy\s\!@#\$%\^&*+-\|\/]{0,6})[ёiлeеюийя]\w{0,7}|\w{0,6}[пp]([пp\s\!@#\$%\^&*+-\|\/]{0,6})[iие]([iие\s\!@#\$%\^&*+-\|\/]{0,6})[3зс]([3зс\s\!@#\$%\^&*+-\|\/]{0,6})[дd]\w{0,10}|[сcs][уy]([уy\!@#\$%\^&*+-\|\/]{0,6})[4чkк]\w{1,3}|\w{0,4}[bб]([bб\s\!@#\$%\^&*+-\|\/]{0,6})[lл]([lл\s\!@#\$%\^&*+-\|\/]{0,6})[yя]\w{0,10}|\w{0,8}[её][bб][лске@eыиаa][наи@йвл]\w{0,8}|\w{0,4}[еe]([еe\s\!@#\$%\^&*+-\|\/]{0,6})[бb]([бb\s\!@#\$%\^&*+-\|\/]{0,6})[uу]([uу\s\!@#\$%\^&*+-\|\/]{0,6})[н4ч]\w{0,4}|\w{0,4}[еeё]([еeё\s\!@#\$%\^&*+-\|\/]{0,6})[бb]([бb\s\!@#\$%\^&*+-\|\/]{0,6})[нn]([нn\s\!@#\$%\^&*+-\|\/]{0,6})[уy]\w{0,4}|\w{0,4}[еe]([еe\s\!@#\$%\^&*+-\|\/]{0,6})[бb]([бb\s\!@#\$%\^&*+-\|\/]{0,6})[оoаa@]([оoаa@\s\!@#\$%\^&*+-\|\/]{0,6})[тnнt]\w{0,4}|\w{0,10}[ё]([ё\!@#\$%\^&*+-\|\/]{0,6})[б]\w{0,6}|\w{0,4}[pп]([pп\s\!@#\$%\^&*+-\|\/]{0,6})[иeеi]([иeеi\s\!@#\$%\^&*+-\|\/]{0,6})[дd]([дd\s\!@#\$%\^&*+-\|\/]{0,6})[oоаa@еeиi]([oоаa@еeиi\s\!@#\$%\^&*+-\|\/]{0,6})[рr]\w{0,12}/i";
$locale['censure_block'] = "<span style='color:red'>[Цензура]</span>";
$locale['shop_msg_auth'] = 'Для совершения покупки в магазине пройдите авторизацию либо зарегистрируйтесь.';
$locale['shop_msg_err_cash'] = 'Для совершения покупки Вам не хватает денежных средств. Пополните свой баланс.';
$locale['shop_msg_sucess'] = 'Покупка совершена успешно!!!';

$locale['reg_sucess'] = 'На Ваш e-mail отправлено письмо с кодом подверждения.';

$locale['AdminPanel'] = 'Панель администратора';
$locale['AdminSettings'] = 'Главные настройки';
$locale['AdminNews'] = 'Новости';
$locale['AdminNewsAdd'] = 'Добавить Новость';
$locale['AdminNewsEdit'] = 'Редактировать Новость';
$locale['AdminNewsDel'] = 'Удалить Новость';
$locale['AdminTitleNews'] = 'Название новости';
$locale['AdminTN'] = 'Редактор Новостей';
$locale['AdminNewsAddSucces'] = 'Новость успешно дабавлена!!!';
$locale['AdminNewsEditSucces'] = 'Новость успешно изменена!!!';
$locale['AdminNewsDelSucces'] = 'Новость успешно удалена!!!';
$locale['NewsTitleLast'] = 'Последние новости проекта';

$locale['data'] = 'Текущие данные';
$locale['b_add_cash'] = 'Пополнить cчет';
$locale['b_out_cash'] = 'Вывод средств';
$locale['b_logaut'] = 'Выход';

$locale['userStats'] = 'Ваша статистика';
$locale['cSellKey'] = 'Кол-во ключей:';
$locale['cKopeck'] = 'Кол-во жетонов:';
$locale['cOpenChest'] = 'Кол-во открытых сундуков:';
$locale['keys'] = 'Текущие ключи';
$locale['kopecks'] = 'Текущие жетоны';
$locale['lables'] = 'Текущая метка';
$locale['hplables'] = 'Жизнь метки:';
$locale['dellables'] = '<span style="color:red;">Ваша метка иссякла!</span>';
$locale['nonkeyshop1'] = 'Ваша метка пирата недостаточно сильна для покупки такого количества ключей либо иссякла!!!';
$locale['nonkeyshop2'] = 'Максимальное количество ключей которое Вы можете купить:';
$locale['timelables'] = 'Кол-во часов до получения стандартной метки:';
$locale['CashInfo'] = 'Денежные средства';
$locale['cCloseBox'] = 'Кол-во мнимых ящиков:';
$locale['cAddCash'] = 'Введенных средств:';
$locale['cOutCash'] = 'Выведенных средств:';
$locale['CountCsh'] = 'Состояние счета:';

$locale['redirect'] = 'Через 3 секунды вы будете перенаправлены на предыдущую страницу сайта.';

$locale['overallStatsProject'] = 'Общая статистика проекта';
$locale['overallCountUser'] = 'Зарегистр. пользователей:';
$locale['overallCountGameBox'] = 'Кол-во сыгранных ящиков:';
$locale['overallCountPaidCash'] = 'Выплачено денежных средств:';
$locale['overallCountAddCash'] = 'Пополнено денежных средств:';

$locale['GameNonChat'] = 'Во время игры нельзя использовать чат.';
$locale['GameStart'] = 'Для открытия сундука нажмите на имеющийся у вас ключик.';
$locale['GameEnd'] = 'Чтобы закончить розыгрыш нажмите на цифру.';

?>