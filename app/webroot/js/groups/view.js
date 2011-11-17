function groupLinkInit() {
	var linkedsFetched = false;
	
	$("#add_new_link").dialog({
		closeOnEscape: true,
		draggable: true,
		modal: false,
		resizable: false,
		width: 630,
		title: 'Add new link to Group',
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	
	$("#linked-addnewlink-link").click(function(){
		$("#add_new_link").dialog("open");
		if(!linkedsFetched) {
			$("#GroupsLinkForm").submit();
			linkedsFetched = true;
		}
		return false;
	});
	
	$("#linked-container > ul > li > img").live('click',function(){
		if($(this).parent().hasClass('link_deleted')) {
			linkGroups(this,true);
		} else {
			deleteContentLink(this);
		}
		
	});
	
	$("#GroupsLinkForm").submit(function(){		
		searchPossibleLinks($(this).serializeArray());
		return false;
	});
	
	$(".add_new_link_list > ul > li > .linked-title").live('click',function(){
		linkGroups(this);
		return false;
	});
	
}
function linkGroups(link,undo) {
	var amountContainer = $("#linked-container > h3 > span");
	var toId = link.id.split('-');
	var linkData = {from:	$("#GroupsLinkForm > #GroupId").val(),
					to:		toId[1]
					};
	$("#add_new_link > .add_new_link_list > ul").html(loading);
	
	$.ajax({ 
		type: 'POST',
		data: linkData,
		url: jsMeta.baseUrl+"/linked_groups/add/",
		success: function(data) {
			if(data == 1) {
				flash("Contents linked together successfully",true,'successfull');
				if(undo) {
					$(link).parent().removeClass('link_deleted');
					$(link).attr('src',jsMeta.baseUrl+'/img/icon_red_cross.png');
					$(amountContainer).text(parseInt($(amountContainer).text())+1);
				} else {	
					$("#ContentsLinkForm").submit();
					addGroupToList(link);
				}
				return true;
			} else {
				return false;
			}
		}
	});
}
function addGroupToList(link) {
	console.log($(link));
	return;
	var container = $("#linked_groups_div > ul");
	var groupId = link.id.split('-')[1];
	var title = link.text;
	var contentClass = $(link).parent()[0].classList[0].split('-')[1];

	var li = '<li class="border-'+contentClass+' small-margin-top-bottom">\
			<a class="bold left" href="#">'+username+': </a>\
			<img id="delete_linked_content-'+contentId+'" alt="" class="size16 right pointerCursor" src="'+jsMeta.baseUrl+'/img/icon_red_cross.png">\
			<div class="clear"></div>\
			<a class="hoverLink blockLink" href="'+jsMeta.baseUrl+'/contents/view/'+contentId+'">'+title+'</a>\
		</li>';
	$(li).prependTo(container).hide().slideDown().effect('highlight',{},1000);
	$(amountContainer).text(parseInt(amount)+1);

	return;
}
function searchPossibleLinks(formData) {
	$.ajax({ 
		type: 'POST',
		dataType: 'json',
		data: formData,
		url: jsMeta.baseUrl+"/LinkedGroups/grouplinksearch/",
		success: function(data) {
			sendDataToLinkList(data);
			return true;
		}
	});
	return false;
}

function sendDataToLinkList(data) {
	
	var ul = $("#add_new_link > .add_new_link_list > ul");
	var output = '';
	
	$("#GroupsLinkForm > div.input > input, #LinkSearchOptionsViewForm > input:checkbox").live('keyup change', function(){
		output = getLinkedOutput(data);
		$(ul).html(output);
	});
	
	if(data.length === 0) {
		output = '<li>No contents found</li>';
		$(ul).html(output);
	} else {
		output = getLinkedOutput(data);	
		$(ul).html(output);
	}
}
function getLinkedOutput(data) {
	console.log(1);
//	var results = searchFromData($("#GroupsLinkForm > div.input > input").val(),data);
	var results = data;
	var thisGroupId = $("#GroupsLinkForm > #GroupId").val();
	if(results.length === 0) {
		output = '<li>No contents found</li>';
	} else {
		var output = renderResults(thisGroupId,results);
	}
	return output;
}

function searchFromData(searchquery,data) {
	var searchquery = searchquery.toLowerCase();
	var returns = [];
	var options = $("#LinkSearchOptionsViewForm > input:checkbox");
	return returns;
}
function renderResults(contentId,data) {
	var output = '';
	$.each(data,function(){
		output = output+ '\
		<li class="border-'+this['class']+' shrinkFontMore">\
			<a class="left" href='+jsMeta.baseUrl+'/Groups/view/'+this.id+'>\
				<img alt="" src="'+jsMeta.baseUrl+'/img/icon_eye.png">\
			</a>\
			<a id="link_to_group-'+this.id+'" class="left linked-title hoverLink" href="#">'+this.name+'</a>\
			<div class="clear"></div>\
		</li>';
	});
	return output;
}
function linkedGroupsInit() {
	linkedGroupsCreateDatatable();
	$("#linked_groups_dialog").dialog({
		closeOnEscape: true,
		draggable: true,
		modal: false,
		resizable: true,
		width: 630,
		title: 'Linked Groups',
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	$("#group-home-linkedgroups h3 a, li#linked_link").click(function(){
		$("#linked_groups_dialog").dialog("open");
		return false;
	});
}
function linkedGroupsCreateDatatable() {	
	var groupId = $("#group_id").val();
	var oTable = $('#linkedGroups_table').dataTable( {
		"sDom": '<"H"l<p>fr<"block">>t<"F"ip>',
		"oSearch": {"sSearch": ""}, //This is a fix so that the search works when there are special characters!
		"aaSorting": [[1,'desc']],
		"bProcessing": true,
		"bJQueryUI": true,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		"sPaginationType": "full_numbers",
		"bAutoWidth": false,
		"sAjaxDataProp": "",
		"sAjaxSource": jsMeta.baseUrl+"/linked_groups/getList/" + groupId,
		"aoColumns": [
			              {"mDataProp": "To.id", "bVisible": false},	              
			              {"mDataProp": "To.name"}
		              ]
	} );
	return oTable;	
}
function campaignsInit() {
	campaignsCreateDatatable();
	$("#campaigns_dialog").dialog({
		closeOnEscape: true,
		draggable: true,
		modal: false,
		resizable: true,
		width: 630,
		title: "Group's Campaigns",
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	$("#group_home_campaigns h3 a, li#campaigns_link").click(function(){
		$("#campaigns_dialog").dialog("open");
		return false;
	});
}
function campaignsCreateDatatable() {	
	var groupId = $("#group_id").val();
	var oTable = $('#campaigns_table').dataTable( {
		"sDom": '<"H"l<p>fr<"block">>t<"F"ip>',
		"oSearch": {"sSearch": ""}, //This is a fix so that the search works when there are special characters!
		"aaSorting": [[1,'desc']],
		"bProcessing": true,
		"bJQueryUI": true,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		"sPaginationType": "full_numbers",
		"bAutoWidth": false,
		"sAjaxDataProp": "Campaign",
		"sAjaxSource": jsMeta.baseUrl+"/groups/getCampaignList/" + groupId,
		"aoColumns": [
			              {"mDataProp": "id", "bVisible": false},	              
			              {"mDataProp": "name"},	              
			              {"mDataProp": "start_time"},	              
			              {"mDataProp": "end_time"}
		              ]
	} );
	return oTable;	
}
function membersInit() {
	membersCreateDatatable();
	$("#memebers_dialog").dialog({
		closeOnEscape: true,
		draggable: true,
		modal: false,
		resizable: true,
		width: 630,
		title: "Group's Members",
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	$("li#members_link").click(function(){
		$("#memebers_dialog").dialog("open");
		return false;
	});
}
function membersCreateDatatable() {	
	var groupId = $("#group_id").val();
	var oTable = $('#members_table').dataTable( {
		"sDom": '<"H"l<p>fr<"block">>t<"F"ip>',
		"oSearch": {"sSearch": ""}, //This is a fix so that the search works when there are special characters!
		"aaSorting": [[1,'desc']],
		"bProcessing": true,
		"bJQueryUI": true,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		"sPaginationType": "full_numbers",
		"bAutoWidth": false,
		"sAjaxDataProp": "",
		"sAjaxSource": jsMeta.baseUrl+"/groups/getMemberList/" + groupId,
		"aoColumns": [
			              {"mDataProp": "User.id", "bVisible": false},	              
			              {"mDataProp": "User.username"}
		              ]
	} );
	return oTable;	
}
function adminsInit() {
	adminsCreateDatatable();
	$("#admins_dialog").dialog({
		closeOnEscape: true,
		draggable: true,
		modal: false,
		resizable: true,
		width: 630,
		title: "Group's Admins",
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	$("#administrators_div h3 a").click(function(){
		$("#admins_dialog").dialog("open");
		return false;
	});
}
function adminsCreateDatatable() {	
	var groupId = $("#group_id").val();
	var oTable = $('#admin_table').dataTable( {
		"sDom": '<"H"l<p>fr<"block">>t<"F"ip>',
		"oSearch": {"sSearch": ""}, //This is a fix so that the search works when there are special characters!
		"aaSorting": [[1,'desc']],
		"bProcessing": true,
		"bJQueryUI": true,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		"sPaginationType": "full_numbers",
		"bAutoWidth": false,
		"sAjaxDataProp": "",
		"sAjaxSource": jsMeta.baseUrl+"/groups/getAdminList/" + groupId,
		"aoColumns": [
			              {"mDataProp": "User.id", "bVisible": false},	              
			              {"mDataProp": "User.username"}
		              ]
	} );
	return oTable;	
}
$(document).ready(function(){
	$( "#campaigns_div" ).tabs();
	groupLinkInit();
	adminsInit();
	linkedGroupsInit();
	campaignsInit();
	membersInit();
	
	
});