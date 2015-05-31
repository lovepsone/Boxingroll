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

	// чат
	$('#chat-form').submit(function(event)
	{
		$('#chat-msg').attr("disabled", true);
        	update($('#chat-msg').val());
		return false;
	});

	function update(text)
	{
		$.ajax(
		{
			type: "POST",
			url: "include/handle.chat.php",
			data: {'data': text},
			success: function(data)
			{
				$('#chat').html(data);
				$('#chat-msg').attr("disabled", false);
				$('#chat-msg').val('');
				$('#chat').scrollTop(chat.scrollHeight);
			}
		});
	}

	update();
	var timer;
	function update_timer()
	{
        	if (timer) clearTimeout(timer);
		timer = setTimeout(function () { update(); }, 5000);
	}
    	update_timer();
});