function initReadPrivateMessageDialog() {
	var message = $("#PrivateMessageMessage");
	var sender = $("#PrivateMessageReceiver");
	var time;

	$("#send_private_message").dialog({
		autoOpen: false,
		resizable: false,
		height: 350,
		width: 450,
		show: {effect: 'slide', duration: 300},
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
			$(message).text("");
			$(sender).text("");
			$(time).text("");
		}
	});

	

}





$(document).ready(function(){
	
	initReadPrivateMessageDialog();
	
	

});

