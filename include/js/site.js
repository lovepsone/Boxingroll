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
});