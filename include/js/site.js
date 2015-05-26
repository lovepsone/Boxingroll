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
		// ��� ���
		var send_data = { last_id: $(chat).attr('data-last-id') };
		if (text)
            		send_data.text = $(text).val();
		// ��� ������
		$.post(
 			'include/handle.chat.php',
            		send_data, // ����� ������� ������
            		function (data)
			{
 				// ������ ������?
				if (data && $.isArray(data))
				{
					$(data).each(function (k)
					{
						// ��������� ���� ���������
						var msg = $('<div>' + data[k].created + ': ' + data[k].text + '</div>');
						// � ������� ��� � ����
                        			$(chat).append(msg);
						// ���� ���� �� ������ ����������
						if (parseInt($(chat).attr('data-last-id')) < data[k].id)
						// ���������� ����� ���� ��
						$(chat).attr('data-last-id', data[k].id);
					});
                    
                    // ���� ��� ��������, �� ��� ��������� ������, �������� �����
                    if (text) {
                        // �������� �����
                        $(form).find('textarea').attr("disabled", false);
                        // � ������� �����
                        $(text).val('');
                    }

                    // ���������
                    $(chat).scrollTop(chat.scrollHeight);

                    // ������� ������ 
                    update_timer();
                }
            },
            'JSON' // ���������� ������ ������������� ��� JSON ������
        );
    }

    // ��� �� ��� �������� �������� ������ � ���, �������� ����� ������
    update();

  // ��� �� ���� ���� ����������� ��� � 5 ������, �������� ������
    var timer;
    function update_timer() {
        if (timer) // ���� ������ ��� ���, ����������
            clearTimeout(timer);
        timer = setTimeout(function () {
            update();
        }, 5000);
    }
    update_timer();
});
