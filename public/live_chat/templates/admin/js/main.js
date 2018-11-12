$(document).ready(function() {

	var typing_timer;
	var interval_id;
	var audio_1 = $('<audio></audio>');
	var audio_2 = $('<audio></audio>');
	
	if (check_audio()) {
		
		audio_1.attr('id', 'audio_1').append('<source src="../sounds/alert_1.ogg" type="audio/ogg">').append('<source src="../sounds/alert_1.mp3" type="audio/mpeg">').append('<source src="../sounds/alert_1.wav" type="audio/wav">').appendTo('body');
		audio_2.attr('id', 'audio_2').append('<source src="../sounds/alert_2.ogg" type="audio/ogg">').append('<source src="../sounds/alert_2.mp3" type="audio/mpeg">').append('<source src="../sounds/alert_2.wav" type="audio/wav">').appendTo('body');

	}

	$('#form_1').on('keyup', '#message', function() {

		clearTimeout(typing_timer);
		
		var status;
		
		if ($(this).val() == '') {
			
			status = 0;
			
		} else {
			
			status = 1;
			
		}
		
		typing_timer = setTimeout(function() {

			data = 'action=operator_typing&operator_typing=' + status;
			
			$.ajax({
				type: 'POST',
				url: 'process.php',
				dataType: 'json',
				data: data			
			});
			
		}, 200);
		
	});

	$('#form_1').on('keydown', '#message', function(event) {

		if (event.keyCode == 13) {
			
			event.preventDefault();

			send_message($(this).parents('form'));

		}
		
	});

	$('#form_1').on('click', '#send_message', function(event) {
		
		event.preventDefault();

		send_message($(this).parents('form'));

	});

	$('body').on('click', '.start_chat', function(event) {
		
		event.preventDefault();
		
		data = 'action=operator_start_chat&chat_id=' + $(this).data('id');
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {

					get_chat();
					interval_id = setInterval(get_chat, console_interval);
					$('#form_1').show();

				}

			}	
		});

	});

	$('#form_1').on('click', '#stop_chat', function(event) {
		
		event.preventDefault();

		clearInterval(interval_id);

		data = 'action=operator_stop_chat';
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {
					
					$('.message_content').empty();
					$('#form_1').hide();
					
				}
				
			}			
		});

	});

	$('body').on('click', '.open_chat', function(event) {
		
		event.preventDefault();
		
		data = 'action=operator_open_chat&chat_id=' + $(this).data('id');
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {

					get_chat();
					interval_id = setInterval(get_chat, console_interval);
					
					$('#form_1').show(function() {
						
						$('.message_content').scrollTop($('.message_content')[0].scrollHeight);
						
					});	

				}
				
			}			
		});
	
	});

	$('body').on('click', '.watch_chat', function(event) {
		
		event.preventDefault();

		data = 'action=operator_watch_chat&chat_id=' + $(this).data('id');
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {

					get_chat();
					interval_id = setInterval(get_chat, console_interval);
					
					$('#form_1').hide(function() {
						
						$('.message_content').scrollTop($('.message_content')[0].scrollHeight);
						
					});

				}
				
			}			
		});

	});
	
	$('body').on('click', '.transfer_chat', function(event) {
		
		event.preventDefault();

		data = 'action=operator_transfer_chat&department_id=' + $(this).data('id');

		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {
					
					clearInterval(interval_id);						
					$('.message_content').empty();
					$('#form_1').hide();
					
				}
				
			}			
		});
		
	});

	$('#canned_messages').on('change', function() {

		$('#message').val(this.value);

	});

	$('a.sound').click(function(event) {
		
		event.preventDefault();
		
		if ($('a.sound i').hasClass('icon-volume-up')) {
			
			$('a.sound i').removeClass('icon-volume-up').addClass('icon-volume-off');
			$('#audio_1').prop('muted', true);
			$('#audio_2').prop('muted', true);
			
		} else {
			
			$('a.sound i').removeClass('icon-volume-off').addClass('icon-volume-up');
			$('#audio_1').prop('muted', false);
			$('#audio_2').prop('muted', false);
			
		}

	});

	$('a.status').click(function(event) {
		
		event.preventDefault();

		data = 'action=operator_update_status';
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {
					
					get_operator_status();
				
				}
				
			}			
		});
			
	});

	$('body').on('click', '#invite_visitor', function(event) {

		event.preventDefault();
		
		$('#form_2').show();
		$('#ip_address').val($(this).data('ip'));
		
	});

	$('#form_2').validate({
		rules: {
			invitation_message: 'required'
		},
		messages: {
			invitation_message: "Please write a message"
		},
		errorPlacement: function(error, element) {
			element.attr('placeholder', error.text());
		}
	});

	$('body').on('click', '#send_invitation', function(event) {
		
		event.preventDefault();
		
		var isValid = $('#form_2').valid();
		
		if (isValid) {
			
			data = $('#form_2').serialize() + '&action=operator_send_invitation';
			
			$.ajax({
				type: 'POST',
				url: 'process.php',
				dataType: 'json',
				data: data,
				success: function(data) {
					
					if (data.success) {
						
						$('#form_2').hide(function() {
							
							$('#alert_1').show();
							$('#invitation_message').val('');
							
						});

					} else {
					
						alert(data.content);
					
					}
					
				}
			});
			
		}
		
	});
	
	$('body').on('click', '#alert_1 a.close', function(event) {
		
		event.preventDefault();

		$("#alert_1").hide();

	});

	$('#form_1').on('click', '#update_online_departments', function(event) {
		
		event.preventDefault();
		
		$('.dropdown-toggle').dropdown();
		
		data = 'action=operator_get_online_departments';
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {
					
					$('#online_departments').html(data.content);
					
				} else {
					
					$('#online_departments').html(data.content);
					
				}
				
			}
		});
		
	});
	
});

function send_message(form) {

	$('#form_1').validate({
		onkeyup: false,
		rules: {
			message: 'required'
		},
		messages: {
			message: "Please write a message"
		}
	});
	
	var isValid = $('#form_1').valid();
	
	if (isValid) {
		
		data = form.serialize() + '&action=operator_send_message';
		
		$.ajax({
			type: 'POST',
			url: 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				if (data.success) {
					
					get_chat();
					$('#form_1')[0].reset();
					
				} else {
					
					alert(data.content);
					
				}
				
			}
		});
	
	}
	
}

function get_chat() {

	data = 'action=operator_get_chat';

	$.ajax({
		type: 'POST',
		url: 'process.php',
		dataType: 'json',
		data: data,
		success: function(data) {

			if (data.success) {

				$('.message_content').html(data.content);
				
				if (data.new_message) {
					
					$('#audio_1').trigger('play');
					$('.message_content').scrollTop($('.message_content')[0].scrollHeight);
					
				}

				if (data.user_typing) {
					
					$('.user_typing span').show();
					
				} else {
					
					$('.user_typing span').hide();
					
				}
				
			} else {
				
				location.reload();
				
			}
			
		}
		
	});

}

function get_online_visitors() {

	data = 'action=operator_get_online_visitors';

	$.ajax({
		type: 'POST',
		url: 'process.php',
		dataType: 'json',
		data: data,
		success: function(data) {
			
			if (data.success) {
				
				$('#online_visitors').html(data.content);
			
			} else {
				
				$('#online_visitors').html(data.content);
				
			}

		}
	});
		
}

function get_pending_chat() {
	
	data = 'action=operator_get_pending_chat';

	$.ajax({
		type: 'POST',
		url: 'process.php',
		dataType: 'json',
		data: data,
		success: function(data) {
			
			if (data.success) {
				
				$('#pending_chat').html(data.content);
				
				if (data.new_chat) {
					
					$('#audio_2').trigger('play');
					
				}
				
			} else {

				$('#pending_chat').html(data.content);
			
			}
			
		}			
	});
		
}

function get_operator_status() {
	
	data = 'action=operator_get_status';
	
	$.ajax({
		type: 'POST',
		url: 'process.php',
		dataType: 'json',
		data: data,
		success: function(data) {
			
			if (data.success) {

				$('a.status span').html(data.content);
				
			} else {

				$('a.status span').html(data.content);
				
			}

		}
	});
	
}

function check_audio() {
	
	var audio = $('<audio></audio>');
	
	if (audio.get(0).canPlayType) {
		
		return true;
		
	} else {
		
		return false;
		
	}
	
}
