function sendPrivateMessage(formData) {
	$.ajax({ 
		type: 'POST',	
		data: formData,
		url: jsMeta.baseUrl+"/private_messages/send/",
		success: function(data) {
			if(data == 1) {
				setFlash("Message sent successfully",'successfull');
				showFlash();
			} else {
				setFlash("Failure in message send. Message not delivered");
				showFlash();
			}
		}
	});
}

function initSendPrivateMessageDialog() {
	var message = $("#PrivateMessageMessage");
	var characters = $("#privateMessageCharacters");
	var receiver = $("#PrivateMessageReceiver");
	var title = $("#PrivateMessageTitle")
	var limit = 1000;
	$(characters).html(limit);
	$(message).live("focus keydown keyup change",function(){ 
		limit = 1000;
		var chars = countCharactersLeft(this,limit);
		$(characters).html(chars);
	});
	$(title).live("focus keydown keyup change",function(){ 
		limit = 70;
		var chars = countCharactersLeft(this,limit);
		$(characters).html(chars);
	});

	$("#send_private_message").dialog({
		autoOpen: false,
		resizable: false,
		height: 350,
		width: 450,
		show: {effect: 'slide', duration: 300, complete: function() {
				$("#PrivateMessageTitle").focus();
			}
		},
		hide: {effect:'slide', duration: 300, direction: 'right'},
		modal: true,
		buttons: {
			'Send Message': function() {
				$("#PrivateMessageForm").submit();
			},
			Cancel: function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			$(message).val("");
			$(characters).text(limit);
			$("#PrivateMessageTo").val("");
			$("#PrivateMessageTitle").val("");
			$(receiver).val("");
		}
	});

	
	
	$("#PrivateMessageForm").submit(function(){
		var chars = countCharactersLeft(message,limit);
		if(chars < 0 || chars == limit) {
			eventAnimate(message);
		} else {
			sendPrivateMessage($(this).serializeArray());
			$("#send_private_message").dialog("close");
		}
		return false;
	});

}

$(document).ready(function(){
	initSendPrivateMessageDialog();
	$(".send-message > a").live('click',function() {
		var id = $(this).siblings('.send-message-id');
		var name = $(this).siblings('.send-message-name');
		var parent_id = $(this).siblings('.send-message-parent-id');
		$("#PrivateMessageTo").text(name.val());
		$("#UserPrivateMessageReceiverId").val(id.val());
		if(parent_id) {
			$("#PrivateMessageParentId").val(parent_id.val());
		} else {
			$("#PrivateMessageParentId").val(null);
		}
	
		$("#send_private_message").dialog("open");
		return false;
	});
	
});