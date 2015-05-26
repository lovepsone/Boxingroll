$(document).on('focus', 'input[type="text"], input[type="password"]', function(event){$(this).val() == this.defaultValue && $(this).val('');});
$(document).on('blur', 'input[type="text"], input[type="password"]', function(event){!$(this).val() && $(this).val(this.defaultValue);});

$(document).ready(function()
{
	$('#AuthStart, #AuthLogOut, #AuthReg').click(function()
	{
		var id = $(this).attr('id'), am = "", ap = "";
		if (id == "AuthStart")
		{
			am = $('#AuthMail').val();
			ap = $('#AuthPass').val();
		}

		$.ajax(
		{
			type: "POST",
			url: "include/handle.auth.php",
			data:{'data': id + ':' + am +':' + ap},
			success: function(data)
			{
				//alert(data);
				$("#user").html(data);
			}
		});
	});

	$('#regMail').bind('textchange', function()
	{
		alert("dsads");
		return true;
	});

	var chat = $('#chat')[0];
	var form = $('#chat-form')[0];
	$('#chat-form').submit(function(event)
	{
 		var text = $(form).find('textarea');
		$(form).find('textarea').attr("disabled", true);
        	update(text);
		return false;
	});

	function update(text)
	{
		// что шлём
		var send_data = { last_id: $(chat).attr('data-last-id') };
		if (text)
            		send_data.text = $(text).val();
		// шлём запрос
		$.post(
 			'include/handle.chat.php',
            		send_data, // отдаём скрипту данные
            		function (data)
			{
 				// ссылка пришла?
				if (data && $.isArray(data))
				{
					$(data).each(function (k)
					{
						// формируем наше сообщение
						var msg = $('<div>' + data[k].created + ': ' + data[k].text + '</div>');
						// и цепляем его к чату
                        			$(chat).append(msg);
						// если ласт ид меньше пришедшего
						if (parseInt($(chat).attr('data-last-id')) < data[k].id)
						// запоминаем новый ласт ид
						$(chat).attr('data-last-id', data[k].id);
					});
                    
                    // если это отправка, то при получении ответа, включаем форму
                    if (text) {
                        // включаем форму
                        $(form).find('textarea').attr("disabled", false);
                        // и очищаем текст
                        $(text).val('');
                    }

                    // прокрутка
                    $(chat).scrollTop(chat.scrollHeight);

                    // обновим таймер 
                    update_timer();
                }
            },
            'JSON' // полученные данные рассматривать как JSON объект
        );
    }

    // что бы при загрузке получить данные в чат, вызываем сразу апдейт
    update();

  // что бы окно чата обновлялось раз в 5 секунд, прицепим таймер
    var timer;
    function update_timer() {
        if (timer) // если таймер уже был, сбрасываем
            clearTimeout(timer);
        timer = setTimeout(function () {
            update();
        }, 5000);
    }
    update_timer();
});
