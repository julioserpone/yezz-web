var form_1;
var form_2;
var relative_url;

function live_chat(url) {

	var typing_timer;
	var interval_id;
	var audio = $('<audio></audio>');
	
	relative_url = url;
	
	get_chat_status();
	get_invitation_message();
	get_unique_id('form_1');
	get_unique_id('form_2');

	if (check_audio()) {
		
		audio.attr('id', 'audio').append('<source src="' + relative_url + 'sounds/alert_1.ogg" type="audio/ogg">').append('<source src="' + relative_url + 'sounds/alert_1.mp3" type="audio/mpeg">').append('<source src="' + relative_url + 'sounds/alert_1.wav" type="audio/wav">').appendTo('body');

	}
	
	$(document).ajaxStart(function() {
		
		$('#chat_content .loading').show();
		
	}).ajaxStop(function() {
		
		$('#chat_content .loading').fadeOut();
		
	});
	
	$('body').on('keyup', '#message', function() {

		if ($(this).parents('form').attr('id') == form_2) {
		
			clearTimeout(typing_timer);
			
			var status;
			
			if ($(this).val() == '') {
				
				status = 0;
				
			} else {
				
				status = 1;
				
			}
			
			typing_timer = setTimeout(function() {

				data = 'action=visitor_typing&visitor_typing=' + status;
				
				$.ajax({
					type: 'POST',
					url: relative_url + 'process.php',
					dataType: 'json',
					data: data,
					global: false	
				});
				
			}, 200);
			
		}
		
	});
		
	$('body').on('keydown', '#message', function(event) {
			
		if (event.keyCode == 13) {

			event.preventDefault();
			
			if ($(this).parents('form').attr('id') == form_2) {
				
				send_message($(this).parents('form'));
				
			}
			
		}
		
	});
	
	$('body').on('click', '#send_message', function(event) {
		
		event.preventDefault();
		
		if ($(this).parents('form').attr('id') == form_2) {
			
			send_message($(this).parents('form'));
			
		}
		
	});
		
	$('body').on('click', '#chat_header', function() {
		
		get_chat_status();
		
		data = 'action=visitor_contact_operator';
		
		$.ajax({
			type: 'POST',
			url: relative_url + 'process.php',
			dataType: 'json',
			data: data,
			global: false,
			success: function(data) {

				if (data.success) {
					
					if ($('#chat_content').is(':hidden')) {
					
						$('#chat_content').show(0, function() {

							$('#chat_content #' + form_1).hide(0, function() {
								
								$('#chat_content #' + form_2).show(0, function() {
									
									get_chat();
									interval_id = setInterval(get_chat, 2000);
									$('i.arrow').addClass('icon_chevron_down').removeClass('icon_chevron_up');
									$(this).html(data.content);
									
									if (!check_audio()) {
										
										$('.chat_sound').remove();
										
									}
					
								});
								
							});

						});
						
					} else {
						
						$('#chat_content').hide(0, function() {
							
							$('i.arrow').addClass('icon_chevron_up').removeClass('icon_chevron_down');
							
						});
						
					}
					
				} else {

					if ($('#chat_content').is(':hidden')) {
						
						$('#chat_content').show(0, function() {

							$('#chat_content #' + form_2).hide(0, function() {
								
								$('#chat_content #' + form_1).show(0, function() {
									
									$('i.arrow').addClass('icon_chevron_down').removeClass('icon_chevron_up');
									
								}).html(data.content);
								
							});

						});
						
					} else {
						
						$('#chat_content').hide(0, function() {

							$('#chat_content #' + form_1).hide().empty();
							$('i.arrow').addClass('icon_chevron_up').removeClass('icon_chevron_down');
							
						});
						
					}

				}

			}
			
		});
	
	});
	
	$('body').on('click', '#start_chat', function() {
		
		$('#' + form_1).validate({
			rules: {
				username: 'required',
				email: {
					required: true,
					email: true
				},
				message: 'required'
			},
			messages: {
				username: "Please enter your name",
				email: "Please enter a valid email address",
				message: "Please write a message"
			}
		});
		
		var is_valid = $('#' + form_1).valid();
		
		if (is_valid) {
			
			data = $(this).parents('form').serialize() + '&action=visitor_start_chat';
			
			$.ajax({
				type: 'POST',
				url: relative_url + 'process.php',
				dataType: 'json',
				data: data,
				success: function(data) {

					if (data.success) {

						$('#chat_content #' + form_1).fadeOut(function() {

							$('#chat_content #' + form_2).fadeIn(function() {
								
								get_chat_status();
								get_chat();
								interval_id = setInterval(get_chat, 2000);
								$(this).html(data.content);
								
								if (!check_audio()) {
									
									$('.chat_sound').remove();
									
								}

							});
							
						}).empty();
						
					} else {
						
						$('#chat_content #' + form_1).fadeOut().empty().fadeIn('slow', function() {
							
							get_chat_status();
							$(this).html(data.content);

						});
						
					}
					
				}
			});
		
		}
		
	});

	$('body').on('click', '#stop_chat', function(event) {
		
		event.preventDefault();
		
		data = 'action=visitor_stop_chat';
		
		$.ajax({
			type: 'POST',
			url: relative_url + 'process.php',
			dataType: 'json',
			data: data,
			success: function(data) {
				
				$('#chat_content').slideUp('slow', function() {
					
					get_chat_status();
					$('#chat_content #' + form_2).empty();
					clearInterval(interval_id);
					
				});
				
			}
		});	
		
	});

	$('body').on('click', '#send_email', function() {

		$('#' + form_1).validate({
			rules: {
				username: 'required',
				email: {
					required: true,
					email: true
				},
				message: 'required'
			},
			messages: {
				username: "Please enter your name",
				email: "Please enter a valid email address",
				message: "Please write a message"
			}
		});
		
		var is_valid = $('#' + form_1).valid();

		if (is_valid) {
			
			data = $(this).parents('form').serialize() + '&action=visitor_send_email';
			
			$.ajax({
				type: 'POST',
				url: relative_url + 'process.php',
				dataType: 'json',
				data: data,
				success: function(data) {

					if (data.success) {

						$('#chat_content #' + form_1).fadeOut().empty().fadeIn(function() {
								
							$('#chat_content #' + form_1).html(data.content);

						});
						
					} else {

						$('#chat_content #' + form_1).fadeOut().empty().fadeIn(function() {

							$('#chat_content #' + form_1).html(data.content);
							
						});
						
					}
					
				}
			});
		
		}
		
	});
	
	$('body').on('click', '#invitation_message a.close', function(event) {
		
		event.preventDefault();
		delete_invitation_message();

	});
	
	$('body').on('click', '#accept_invitation', function(event) {
		
		event.preventDefault();
		delete_invitation_message();
		$('#chat_header').trigger('click');
		
	});

	$('body').on('click', 'a.chat_sound', function(event) {
		
		event.preventDefault();
		
		if ($('a.chat_sound i').hasClass('icon_volume_up')) {
			
			$('a.chat_sound i').removeClass('icon_volume_up').addClass('icon_volume_off');
			$('#audio').prop('muted', true);
			
		} else {
			
			$('a.chat_sound i').removeClass('icon_volume_off').addClass('icon_volume_up');
			$('#audio').prop('muted', false);
			
		}

	});

}

function get_invitation_message() {
	
	data = 'action=visitor_get_invitation_message';
	
	$.ajax({
		type: 'POST',
		url: relative_url + 'process.php',
		dataType: 'json',
		data: data,
		global: false,
		success: function(data) {

			if (data.success) {
				
				$('#invitation_message').show(function() {
					
					$("#invitation_message a#accept_invitation").html(data.invitation_message);
					
				});
	
			}
			
		}
	});
	
}

function delete_invitation_message() {
	
	data = 'action=visitor_delete_invitation_message';

	$.ajax({
		type: 'POST',
		url: relative_url + 'process.php',
		dataType: 'json',
		data: data,
		global: false,
		success: function(data) {

			if (data.success) {
				
				$("#invitation_message").alert('close');
	
			} else {
				
				$("#invitation_message").alert('close');
				
			}
			
		}
	});

}

function get_chat_status() {

	data = 'action=visitor_get_chat_status';
	
	$.ajax({
		type: 'POST',
		url: relative_url + 'process.php',
		dataType: 'json',
		data: data,
		global: false,
		success: function(data) {

			if (data.success) {
				
				$('#chat_header span').html(data.content);

			} else {

				$('#chat_header span').html(data.content);

			}
			
		}
	});	

}

function send_message(form) {

	$('#' + form_2).validate({
		onkeyup: false,
		rules: {
			message: 'required'
		},
		messages: {
			message: "Please write a message"
		}
	});
	
	var is_valid = $('#' + form_2).valid();
	
	if (is_valid) {
		
		data = form.serialize() + '&action=visitor_send_message';
		
		$.ajax({
			type: 'POST',
			url: relative_url + 'process.php',
			dataType: 'json',
			data: data,
			global: false,
			success: function(data) {
				
				if (data.success) {
					
					get_chat();
					$('#' + form_2)[0].reset();
				
				} else {
					
					alert(data.content);
					
				}
				
			}
		});
	
	}
	
}
	
function get_chat() {

	data = 'action=visitor_get_chat';
	
	$.ajax({
		type: 'POST',
		url: relative_url + 'process.php',
		dataType: 'json',
		data: data,
		global: false,
		success: function(data) {

			if (data.success) {

				$('.message_content').html(data.content);
				
				if (data.new_message) {
					
					$('#audio').trigger('play');
					$('.message_content').scrollTop($('.message_content')[0].scrollHeight);
					
				}

				if (data.operator_typing) {
					
					$('.operator_typing span').show();
					
				} else {
					
					$('.operator_typing span').hide();
					
				}
				
				if (data.queue) {
					
					get_chat_status();
					$('.queue span').hide();
					
				} else {

					$('.queue span').show();
					
				}

			} else {
				
				location.reload();
				
			}
			
		}
		
	});

}

function get_unique_id(prefix) {
	
	data = 'action=get_unique_id&prefix=' + prefix;

	$.ajax({
		type: 'POST',
		url: relative_url + 'process.php',
		dataType: 'json',
		data: data,
		global: false,
		success: function(data) {

			if (data.success) {

				unique_id(prefix, data.unique_id);
				
			}
			
		}
	});	

}

function unique_id(prefix, data) {

	if (prefix == 'form_1') {
		
		form_1 = data;
		
	} else if (prefix = 'form_2') {
		
		form_2 = data;
		
	}
	
}

function check_audio() {
	
	var audio = $('<audio></audio>');
	
	if (audio.get(0).canPlayType) {
		
		return true;
		
	} else {
		
		return false;
		
	}
	
}
