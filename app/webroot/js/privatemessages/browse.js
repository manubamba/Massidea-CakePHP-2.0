page = 'inbox';
//var allTags;

function addTagToPrivateMessageTagList(callback) {
//	$("#create_message_tag").dialog("open");
	
}

function privateMessageInit(messageId) {
	$('#privatemessages #browse-page h2').hide();
	$('#privatemessages #browse-page h2.title_'+page).show();
	var showName = true;
	var displayName = "\"PrivateMessage.Sender.username\"";
	if (page == 'sent') {
		displayName = "\"Receiver.username\"" ;
		$('#PrivateMessages-table .title_from').hide();
		$('#PrivateMessages-table .title_to').removeClass('hidden');		
	}
	if (page == 'conversation') {
		page += "/" + messageId; 
	}
	if (page == 'tagOpener') {
		page += "/" + messageId; 
	}
	
	if (page == 'thread') {
		showName = false;
		page += "/" + messageId; 
		displayName = "\"Sender.username\"";
	}
	if (page == 'myNotes') {
		showName = false;
		displayName = "\"Receiver.username\"";
	}
	var oTable = $('#PrivateMessages-table').dataTable( {
		"sDom": '<"H"l<p>fr<"block"T>>t<"F"ip>',
//		"oTableTools": {			
//			"aButtons": privateMessageCreateButtons()
//		},
		"fnInitComplete": function() {
			if($("#sidebar .boxLinks").is(':hidden')) $("#sidebar .boxLinks").show('drop');
		},
		"oSearch": {"sSearch": ""}, //This is a fix so that the search works when there are special characters!
		"aaSorting": [[4,'desc']],
		"bProcessing": true,
		"bJQueryUI": true,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		"sPaginationType": "full_numbers",
		"bAutoWidth": false,
		"sAjaxDataProp": "messages",
		"sAjaxSource": jsMeta.baseUrl+"/private_messages/fetch_messages_" + page,
		"oTableTools": {
			"aButtons": privateMessageCreateButtons()
		},
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			var user_id;
			var username;
			if(page == 'sent') {
				user_id = aData.UserPrivateMessage.receiver_id;
				username = aData.Receiver.username;
			} else if(page == 'conversation/'+messageId) {
				user_id = aData.PrivateMessage.sender_id;
				username = aData.PrivateMessage.Sender.username;				
			} else if(page == 'thread/'+messageId) {
				user_id = aData.PrivateMessage.sender_id;
				username = aData.Sender.username;				
			}
			else {
				user_id = aData.PrivateMessage.sender_id;
				username = aData.PrivateMessage.Sender.username;
			}
			var reply_to_id = aData.PrivateMessage.id;
			if  (!aData.PrivateMessage.title) {
				aData.PrivateMessage.title = '&ltNo Title&gt';
				$('.message-title',nRow).addClass('grey');
			}
			var conversation_link = '| <div class="inline">\
				<a href="#" class="privatemessage-conversation">View full conversation</a>\
				</div>\
				';
			if(page == 'conversation/'+messageId) {
				conversation_link = '';
			} 
			if(page == 'thread/'+messageId) {
				conversation_link = '';
			} 
			if(page == 'myNotes') {
				conversation_link = '| <div class="inline">\
					<a href="#" class="privatemessage-thread">View thread</a>\
					</div>\
					';
			} 
			if(page == 'inbox' || page == 'conversation/' + messageId) {
				if(aData.UserPrivateMessage.read == "0") {
				$(nRow).addClass('message-unread');
			}
			} 
		
			
			var actions = '\
				<div class="hidden message-buttons">\
					<div class="send-message inline">\
						<a href="#">Reply</a> | \
						<input type="hidden" class="send-message-name" value="'+ username +'" />\
						<input type="hidden" class="send-message-id" value="'+ user_id +'" />\
						<input type="hidden" class="send-message-parent-id" value="'+ reply_to_id  +'" />\
					</div>\
				<div class="inline delete-message">\
				<a href="#" class="privatemessage-delete">Delete</a> \
				</div>'
				+ conversation_link +
				'</div>\
				';
			$('.message-title',nRow).html(aData.PrivateMessage.title + actions );

			var checkbox = '<input type="checkbox" name="selected"/>';
			$('td:eq(0)',nRow).html(checkbox);
			

			return nRow;
		},
		"fnDrawCallback": function() {
			var checkboxes = $('#PrivateMessages-table th.checkbox-header input');
			checkboxes.prop('checked', false);
		},
		"aoColumns": [
		              {"mDataProp": "PrivateMessage.id", "bVisible": false},
		              {"mDataProp": null, "bSortable": false, "sClass": "checkbox-column"},		              
		              {"mDataProp": eval(displayName) ,"sClass": "message-username", "bVisible": showName},
		              {"mDataProp": "PrivateMessage.title", "sClass":"no-overflow message-title padding-left-right"},
		              {"mDataProp": "PrivateMessage.created", "bVisible": false},
		              {"mDataProp": "PrivateMessage.timeago" ,"iDataSort": 4,  "sClass":"center no-overflow"},
		              {"mDataProp": "PrivateMessage.message", "bVisible": false, "bSearchable": true}
		              ]

	} );
	return oTable;	
}

function privateMessageCreateButtons() {
	var deleteButton ={
		"sExtends": "text",
		"sButtonText": "Delete",
		"fnClick": function ( nButton, oConfig, oFlash ) {
			var selected = $('#PrivateMessages-table tbody :checked').parent().parent();
			var total_selected = selected.length;
			if(!total_selected) return;
			var id = new Array();
			var confirm = false;
			var ext = total_selected > 1 ? " messages?" : " message?";
			var deletemessage = "Delete "+total_selected+ext;
			$( '<div id="dialog-confirm" title="'+deletemessage+'"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>These messages will be permanently deleted and cannot be recovered. Are you sure?</p></div>' ).dialog({
				resizable: false,
				height:200,
				modal: true,
				buttons: {
					Delete: function() {
						$.each(selected,function(index,tr){
							id.push(PrivateMessage.dataTable.fnGetData(tr).PrivateMessage.id);
							PrivateMessage.dataTable.fnDeleteRow(tr);
						});
						privateMessageDelete(id);
						$( this ).dialog( "close" );
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}
	};
	var markAsButton = {
		"sExtends": "collection",
		"sButtonText": "Mark...",
		"aButtons": [
	             {
	            	 "sExtends": "text",
	            	 "sButtonText": "Read",

	            	 "fnClick": function ( nButton, oConfig, oFlash ) {
	            		 var selected = $('#PrivateMessages-table tbody :checked').parent().parent();
	            		 var total_selected = selected.length;
	            		 var id = new Array();
	            		 if(!total_selected) return;
	            		 $.each(selected,function(index,tr){
	            			 $(tr).removeClass('message-unread');
	            			 id.push(PrivateMessage.dataTable.fnGetData(tr).PrivateMessage.id);
	            		 });	
	            		 privateMessageMark(id, true);	            		 
	            	 }
	             },
	             {
	            	 "sExtends": "text",
	            	 "sButtonText": "Unread",
	            	 "fnClick": function ( nButton, oConfig, oFlash ) {
	            		 var selected = $('#PrivateMessages-table tbody :checked').parent().parent();
	            		 var total_selected = selected.length;
	            		 var id = new Array();
	            		 if(!total_selected) return;
	            		 $.each(selected,function(index,tr){
	            			 $(tr).addClass('message-unread');
	            			 id.push(PrivateMessage.dataTable.fnGetData(tr).PrivateMessage.id);
	            		 });	
	            		 privateMessageMark(id, false);
	            	 }
	             }
         ]
	};
	
	var flagButton = {
		"sExtends": "text",
		"sButtonText": "Flag...",
		"fnClick": function ( nButton, oConfig, oFlash ) {
		}
	};	
	var tableButtons = new Array();
	tableButtons.push(deleteButton);
	if (page == 'inbox') {
		tableButtons.push(markAsButton);
	}
	if (page == 'inbox'|| page.indexOf('conversation') > -1) {
		tableButtons.push(flagButton);
	}
	return tableButtons;
}


function privateMessageDelete(id) {
	$.ajax({ 
		type: 'POST',
		data: {data:{messageId:id}},
		url: jsMeta.baseUrl+"/private_messages/delete/"+ page+"/",
		success: function(data) {
			privateMessagesCountUnread(page, true);
			if(data >= 1) {
				setFlash("Message deleted successfully",'successfull');
				showFlash();
			} else {
				setFlash("Failure in message delete. Message not deleted");
				showFlash();
			}
		}
	});
}


function privateMessageMark(id, markRead) {
	if(!markRead) {
		markRead=0;
	} else {
		markRead=1;
	}
	$.ajax({ 
		type: 'POST',
		data: {data:{messageId:id, markRead:markRead}},
		url: jsMeta.baseUrl+"/private_messages/mark/",
		success: function() {
			privateMessagesCountUnread(page, true);
		}
	});
}

function privateMessageListTags() {
	$.ajax({ 
		type: 'json',	
		url: jsMeta.baseUrl+"/private_message_tags/view/",
		success: function(data) {
				allTags = $.parseJSON(data);	
		}
	});
	return false;
}


function PrivateMessageTagsCreateInit() {
	$("#create_message_tag").dialog({
		autoOpen: false,
		resizable: false,
		show: {effect: 'slide', duration: 300},
		hide: {effect:'slide', duration: 300, direction: 'right'},
		modal: true,
		buttons: {
			'Create Tag': function() {
				$("#PrivateMessageTagsAddForm").submit();
			},
			Cancel: function() {
				$('#PrivateMessageTagsTitle').html('');
				$(this).dialog("close");
			}
		},
		close: function() {
		}
	});
	
	$("#PrivateMessageTagsAddForm").submit(function(){
		$("#create_message_tag").dialog('close');
		data = $(this).serializeArray();
		$.ajax({ 
			type: 'POST',
			data: data,
			url: jsMeta.baseUrl+"/private_message_tags/add/",
			success: function(data) {
				if(data != 'false') {
					data = $.parseJSON(data);
					var newTag = '<li class="small-margin-top-bottom block hover border-tag" style="border-color:'+data.PrivateMessageTag.color+'">\
									<a class="wide inline-block tagOpener_link" href="#">'+data.PrivateMessageTag.name+'</a>\
									<a href="#" class="tagAddLink">\
										<img alt="" class="inline hoverDarker icon right small-padding-left-right" src="'+jsMeta.baseUrl+'/img/icon_link.png">\
									</a>\
									<input type="hidden" value="'+data.PrivateMessageTag.id+'" class="tagId" />\
									<div class="hidden clear">\
										<a href="#" class="tagEditLink"><img alt="" class="inline hoverDarker icon small-padding-left-right" src="'+jsMeta.baseUrl+'/img/icon_edit.png"></a>\
										<a href="#" class="tagDeleteLink"><img alt="" class="inline hoverDarker icon small-padding-left-right" src="'+jsMeta.baseUrl+'/img/icon_red_cross.png"></a>\
									</div>\
								</li>';
					newTag = $(newTag).prependTo("#tags-container ul");  // hide().show(200);	
					eventAnimate($(newTag), '#FFC726');
					flash("Tag created successfully",true,'successfull');
				} else {
					flash("Tag not created successfully",true, 'unsuccessful');
				}
			}
		});
		return false;
	});
	
}
function PrivateMessageTagsLink(messageId, tagId) {
	$.ajax({ 
		type: 'POST',	
		data: {data:{messageId:messageId, tagId:tagId}},
		url: jsMeta.baseUrl+"/private_message_tags/tag/",
		success: function(data) {
			if(data) {
				flash("Tag linked successfully",true,'successfull');
			} else if (data == 0){
				flash("Tag not linked successfully",true);
			}
		}
	});
}
function PrivateMessageTagsDelete(anchor, tagId) {
	$.ajax({ 
		type: 'POST',	
		data: {data:{tagId:tagId}},
		url: jsMeta.baseUrl+"/private_message_tags/delete/",
		success: function(data) {
			if(data == 1) {
				$(anchor).parent().parent().remove();
				flash("Tag deleted successfully",true,'successfull');
			} else if (data == 0){
				flash("Tag not deleted successfully",true);
			}
		}
	});
}


function toggleLinks() {
	
  $("#sidebar ul").toggle('slide');
}

function reinitialiseDataTable(pageRequested, messageId) {
	privateMessagesCountUnread(page, true);
	$("#sidebar .boxLinks").hide();
	PrivateMessage.dataTable.fnClearTable(false);
	PrivateMessage.dataTable.fnDestroy();
	page = pageRequested;
	delete PrivateMessage;
	PrivateMessage = new DataTableClass(privateMessageInit(messageId));
	return false;	
	
}
function privateMessageComposeInit() {	
	var message = $("#PrivateMessageComposeMessage");
	var characters = $("#privateMessageComposeCharacters");
	var receiver = $("#UserPrivateMessageReceiverUsername");
	var title = $("#PrivateMessageComposeTitle")
	var receivers = new Array();
	var receiversDiv = $('#compose_private_message .privateMessageReceivers');
	$(characters).html(limit);
	var limit = 1000;
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

	$("#compose_private_message").dialog({
		autoOpen: false,
		resizable: false,
		width: 470,
		show: {effect: 'slide', duration: 300, complete: function() {
				$("#UserPrivateMessageReceiverUsername").focus();
				$('#PrivateMessageComposeFormSubmit').prop("disabled",false);
			}
		},
		hide: {effect:'slide', duration: 300, direction: 'right'},
		modal: true,
		buttons:
		[{
			id: 'PrivateMessageComposeFormSubmit',
			text: 'Send Message',
			click: function() {
				$('#PrivateMessageComposeFormSubmit').prop("disabled",true);
				$("#PrivateMessageComposeForm").submit();
			}
        },    
		{
			text: 'Cancel',
			click: function() {
				$(this).dialog("close");
			}
		}],
		close: function() {
			$(message).val("");
			$(characters).text(limit);
			$(".privateMessageReceivers").html("");
			title.val("");
			$(receiver).val("");
			receivers.length = 0;
		}
	});

	
	
	$("#PrivateMessageComposeForm").submit(function(){
		var chars = countCharactersLeft(message,limit);
		if(chars < 0 || chars == limit) {
			eventAnimate(message);
		} else {
			$("#compose_private_message").dialog("close");
			var hiddeninput = $('<input type="hidden" name="data[UserPrivateMessage][receivers]" value="'+receivers+'" />').appendTo(this);
			var thedata = $(this).serializeArray();	
			$(hiddeninput).remove();
			sendPrivateMessage(thedata);
		}
		return false;
	});
	
	function buttonise( username, id ) {
		var buttonSetDiv = '<div class="inline-block"><a class="receiversListName" href="#">'+username+'</a><a class="receiversListRemoveButton" href="#">Cancel</a></div>';
		
		buttonSet = $(".receiversListName",buttonSetDiv)
		.button().click(function() { 
					return false;
				}).next().button({
					text: false,
					icons: {
						primary: "ui-icon-close"
					}
				}).click(function() {
					var index = $.inArray(id, receivers );
					receivers.splice(index, 1);		
					$(this).parent().remove();					
				}).parent().buttonset();
		return buttonSet;
	}

	$( "#UserPrivateMessageReceiverUsername" )
		// don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
					$( this ).data( "autocomplete" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			source: function( request, response ) {
				$.getJSON(jsMeta.baseUrl+"/users/listUsers/",
					{term: request.term},
					function(data,textStatus,jqXRH) {
						var responseArray = new Array();
						$.each(data,function(key,value){
							if($.inArray(value.id, receivers) == -1) {
								responseArray.push(this);
							}
						})
						response(responseArray,textStatus,jqXRH); 
					});
			},
			search: function() {
				var term = this.value;
				if ( term.length < 2 ) {
					return false;
				}
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = this.value;
				receivers.push(ui.item.id);
				var userButton = buttonise(ui.item.value, ui.item.id);
				$(receiversDiv).append(userButton);
				terms = '';
				this.value = terms;
				return false;
			},
			open: function(event, ui) {

			}
		});
}

$(document).ready(function() {
	$.farbtastic('#colorpicker').linkTo('#PrivateMessageTagColor');
//	privateMessageListTags();
	privateMessageComposeInit();
	PrivateMessageTagsCreateInit();
	PrivateMessage = new DataTableClass(privateMessageInit());
	$( "#PrivateMessages-table" ).selectable({ 
				filter: 'tbody tr ', 
				distance: 20,
				selected: function(event, ui) {
					var checkbox = $(ui.selected).children().children()[0];
					if($(checkbox).is(':checked')) {
						$(checkbox).prop('checked', false);
					} else {
						$(checkbox).prop('checked', true);
					}
						
				}
	});
	
	$('#compose_message_link').live("click",function(e) {
		$("#compose_private_message").dialog("open");
		return false;		
	}
	);
	$('.sentbox_link').live("click",function(e) {
		reinitialiseDataTable('sent');
		return false;		
	}
	);
	$('.inbox_link').live("click",function(e) {
		reinitialiseDataTable('inbox');
		return false;
		
	}
	);
	$('.myNotes_link').live("click",function(e) {
		reinitialiseDataTable('myNotes');
		return false;
		
	}
	);
	$('.tagOpener_link').live("click",function(e) {
		tagId = $(this).siblings('.tagId').val();
		reinitialiseDataTable('tag',tagId);
		return false;
		
	}
	);
	$('#tags-container ul li').live("mouseover mouseout",function() {
			$("div.tag-options", this).toggle();
	}	
	);
	
	$('.tagCreate').live("click",function(e) {
		$("#create_message_tag").dialog("open");
		return false;		
	}
	);
	$('.tagAddLink').live("click",function(e) {
		tagId = $(this).siblings('.tagId').val();
		 var selected = $('#PrivateMessages-table tbody :checked').parent().parent();
		 var total_selected = selected.length;
		 var id = new Array();
		 if(!total_selected) return;
		 $.each(selected,function(index,tr){
			 id.push(PrivateMessage.dataTable.fnGetData(tr).PrivateMessage.id);
		 });	
		 PrivateMessageTagsLink(id, tagId);
		return false;		
	}
	);
	$('.tagDeleteLink').live("click",function(e) {
		anchor = this;
		tagId = $(this).parent().siblings('.tagId').val();
		 $( '<div id="dialog-confirm" title="Delete tag"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete  permanently?</p></div>' ).dialog({
			 resizable: false,
			 height:180,
			 modal: false,
			 buttons: {
				 Delete: function() {
					 PrivateMessageTagsDelete(anchor, [tagId]);					 
					 $( this ).dialog( "close" );
				 }, 
				 Cancel: function() {
					 $( this ).dialog( "close" );
				 }
			 }
		 });
				 
		return false;		
	}
	);
	
	
	$('#PrivateMessages-table > tbody > tr').live("click mouseover mouseout",function(e){

		if(e.type=="mouseover") { //show the links for read/reply/delete
			$('.message-title > div',this).removeClass('hidden');
			return true;
		}

		if(e.type=="mouseout"){ // donot remove links for read/reply/delete if the message is open
			if($(this).next().children().hasClass('message_td')) {
				return true;
			}			
			$('.message-title > div',this).addClass('hidden');//remove links for read/reply/delete on mouseout
			return true;
		}		
		
		if(e.type=="click") {
			PrivateMessage.titleRow = this;
			if(PrivateMessage.isMessageRow(this)) {return false;}
			PrivateMessage.init();			
			PrivateMessage.clickedElement = e.target; //its the clicked element			
			if(PrivateMessage.clickedElement.className == 'privatemessage-conversation') {				
				var messageId = PrivateMessage.data.PrivateMessage.id;
				reinitialiseDataTable('conversation', messageId);
				PrivateMessage.accordion = false;
				return false;
				
			}
			if(PrivateMessage.clickedElement.className == 'privatemessage-thread') {				
				var messageId = PrivateMessage.data.PrivateMessage.id;
				reinitialiseDataTable('thread', messageId);
				PrivateMessage.accordion = false;
				return false;				
			}			
			if(PrivateMessage.clickedElement.className == 'privatemessage-delete') {
				 $( '<div id="dialog-confirm" title="Delete message"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete  permanently?</p></div>' ).dialog({
        			 resizable: false,
        			 height:180,
        			 modal: false,
        			 buttons: {
        				 Delete: function() {
        					 PrivateMessage.deleteMessage(function(rowDetails){				
        						 privateMessageDelete([rowDetails.PrivateMessage.id]);
        					 });
        					 $( this ).dialog( "close" );
        				 }, 
        				 Cancel: function() {
        					 $( this ).dialog( "close" );
        				 }
        			 }
        		 });
				
				
				return false;
			}
			

			if(PrivateMessage.clickedElement.type == "checkbox") {
				if($(PrivateMessage.clickedElement).is(':checked')) {
					$(PrivateMessage.titleRow).addClass('row_selected');					
				} else {
					$('#PrivateMessages-table > thead input, #PrivateMessages-table > tfoot input').prop('checked', false);
					$(PrivateMessage.titleRow).removeClass('row_selected');
				}
				return true;
			}
			if($(PrivateMessage.titleRow).hasClass('message-unread')) {
				id = PrivateMessage.data.PrivateMessage.id;			
				$(PrivateMessage.titleRow).removeClass('message-unread');
				privateMessageMark([id], true);
			}
			PrivateMessage.initRead();
			PrivateMessage.content = PrivateMessage.data.PrivateMessage.message;	
			if(PrivateMessage.openRows.length) {
				PrivateMessage.switchMessage();
			} else {
				PrivateMessage.openMessage();
			}


			
			
		}
	});
	
	$('#PrivateMessages-table > thead input, #PrivateMessages-table > tfoot input').live("change",function(e){
		var checkboxes = $('#PrivateMessages-table > tbody > tr > td.checkbox-column input');
		if($(this).is(':checked')) {
			$('#PrivateMessages-table > thead input, #PrivateMessages-table > tfoot input').prop('checked', true);
			checkboxes.prop('checked', true);
		} else {
			$('#PrivateMessages-table > thead input, #PrivateMessages-table > tfoot input').prop('checked', false);
			checkboxes.prop('checked', false);
		}
	});


} );