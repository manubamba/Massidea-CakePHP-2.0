function linkedGroupsInit() {	
	var groupId = $("#group_id").val();
	var oTable = $('#linkedGroups_table').dataTable( {
		"sDom": '<"H"l<p>fr<"block"T>>t<"F"ip>',
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

$(document).ready(function(){
	LinkedGroups = new DataTableClass(linkedGroupsInit());
});