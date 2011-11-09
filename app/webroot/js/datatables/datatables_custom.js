function DataTableClass(dataTable) {
	this.dataTable = dataTable;
	this.openRows = new Array();
	this.titleRow = null;
	this.messageRow = null;
	this.content = null;  //this has to be set explicitly
	this.messageId = null;
	this.messageDiv = '<div class="the_message hidden"/>';	
	this.className = null;
	this.toClose = null;
	this.isOpen = false;
	this.openRowIndex = null;
	this.clickedElement = null;
	this.data = null;
	this.accordion = true;   //this has to be changed explicitly
	this.deleteCallback = function() {};
	this.openCallback = function() {};
	this.setDataTable = function(dataTable){this.dataTable = dataTable;}

	this.isMessageRow = function(tr){
		if($(tr).children().hasClass('message_td')) {
			return true;
		}
		return false;
	}
	
	this.init = function() {	
		this.data =  this.dataTable.fnGetData(this.titleRow);
		this.openRowIndex = $.inArray(this.titleRow, this.openRows );
		if(this.openRowIndex == -1) {				
			this.isOpen = false;
		} else {
			this.isOpen = true;
		}
	}
	
	this.initRead = function() {
		this.className = this.titleRow.className;
	}

	
	this.switchMessage = function() {
		var pm = this;
		if (this.isOpen) {
			var theMessageDiv = $('.the_message', $(this.openRows[this.openRowIndex]).next()[0]);
		$(theMessageDiv).slideUp(300,function(){
				pm.close(pm.openRowIndex);
		 });
			
		}else {
		if (this.accordion) {
			
				$('.the_message').slideToggle(300,function(){
					pm.close(0);
					pm.openMessage();
				});
			} else {
				pm.openMessage();
			}
		}
	}
	
	
	this.openMessage = function() {
		this.messageRow = dataTable.fnOpen( this.titleRow,
				nl2br(this.content,false),
				"message_td");
		$('td', this.messageRow).wrapInner(this.messageDiv);
		$('.the_message').slideDown(300);		
		$(this.messageRow).addClass(this.className);
		$(this.messageRow).addClass('message_row');
		$(this.titleRow).addClass('row_expanded');
		$('.message-buttons', this.titleRow).removeClass('hidden');
		this.isOpen = true;
		this.openRows.push(this.titleRow);
	}

	this.close = function(index) {
		this.toClose = $(this.openRows[index]);
		$('.message-buttons', this.toClose).addClass('hidden');
		$(this.toClose[0]).removeClass('row_expanded');
		this.dataTable.fnClose(this.toClose[0]);
		this.openRows.splice(index, 1);
	}

	
	this.deleteMessage = function(deleteCallback ) {
		if($(this.titleRow).hasClass('row_expanded')) {this.isOpen = false;}
		this.deleteCallback = deleteCallback;		
		this.dataTable.fnDeleteRow(this.titleRow,
				this.deleteCallback(this.data)
		);
	}

}