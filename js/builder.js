	var formOwner = 1;
	
	
	var dialog; //for JQuery UI
	var chosenlist = "";
	
	function pickList(obj){
		chosenlist = obj;
		
		dialog = $( "#listPicker" ).dialog({
		  autoOpen: true,
		  height: 600,
		  width: 600,
		  modal: true,
		  title: "List Picker",
		  buttons: {
			Cancel: function() {
			  dialog.dialog( "close" );
			}
		  },
		  close: function() {
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
			chosenlist = "";
		  },
		  open: function(){
			  //$('#listPicker').html('' + new Date().getTime() );
			  $('#listPicker').html('<div id="availableLists" class="loading" style="height: 400px;"></div>');
			  $('#availableLists').load( "/views/list/listLists.php", function() {
					  //alert( "Load was performed." );
					  //bind events
					  $('#availableLists').removeClass('loading');
			  });
		  }
    	});
	
	}
	
	function pickListItem(listID, listName){
		var row = $(chosenlist).closest('div.listID');
		$(row).find('input[name="listID"]').attr('value', listID);
		$(row).find('label.listName').html( '<b>Chosen List</b>: &ldquo;' + listName + '&rdquo;  <a class="clearPick" onClick="clearPick(this);"><i class="fa fa-times"></i></a>');
		dialog.dialog("close");	
	}
	
	function pickGroup(obj, groupType ) {
		//groupType - 1 - groupItem
		//groupType - 2 - listItem
		chosenlist = obj;
		var url = "";
		var popTitle = "";
		if ( groupType == 1) {
		  url = "/views/group/listGroups.php";
		  popTitle = "Pick Re-useable Group";
		}else if (groupType == 2) {
		  //fix for reuseable item
		  url = "/views/group/listGroups.php";
		  popTitle = "Pick Re-useable Item";
		}
		
		
		dialog = $( "#listPicker" ).dialog({
		  autoOpen: true,
		  height: 600,
		  width: 600,
		  modal: true,
		  title: popTitle,
		  buttons: {
			Cancel: function() {
			  dialog.dialog( "close" );
			}
		  },
		  close: function() {
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
			chosenlist = "";
		  },
		  open: function(){
			  $('#listPicker').html('<div id="availableLists" class="loading" style="height: 400px;"></div>');
			  
			  $('#availableLists').load( url , function() {
					$('#availableLists').removeClass('loading');
			  });
		  }
    	});
	}

	function pickGroupItem(groupID, groupType, groupName){
		var row = $(chosenlist).closest('div.reUseableItem');
		$(row).find('input[name="reuseableID"]').attr('value', groupID);
		$(row).find('input[name="reuseableType"]').attr('value', groupType);
		$(row).find('label.groupName').html( '<b>Chosen Group</b>: &ldquo;' + groupName + '&rdquo;  <a class="clearPick" onClick="clearGroup(this);"><i class="fa fa-times"></i></a>');
		
		dialog.dialog("close");	
	}
	
	
	function clearPick(obj){
		//to do clear the pick
		var row = $(obj).closest('div.listID');
		$(row).find('input[name="listID"]').attr('value', '');
		$(row).find('label.listName').html('');
	}
	
	function clearGroup(obj){
		var row = $(obj).closest('div.reUseableItem');
		$(row).find('input[name="reuseableID"]').attr('value', '');
		$(row).find('input[name="reuseableType"]').attr('value', '');
		$(row).find('label.groupName').html('');
	}
	
	
	function moveUp(item) {
		var prev = item.prev();
		if (prev.length == 0)
			return;
		prev.css('z-index', 999).css('position','relative').animate({ top: item.height() }, 250);
		item.css('z-index', 1000).css('position', 'relative').animate({ top: '-' + prev.height() }, 300, function () {
			prev.css('z-index', '').css('top', '').css('position', '');
			item.css('z-index', '').css('top', '').css('position', '');
			item.insertBefore(prev);
		});
		orderItems();
	}
	function moveDown(item) {
		var next = item.next();
		if (next.length == 0)
			return;
		next.css('z-index', 999).css('position', 'relative').animate({ top: '-' + item.height() }, 250);
		item.css('z-index', 1000).css('position', 'relative').animate({ top: next.height() }, 300, function () {
			next.css('z-index', '').css('top', '').css('position', '');
			item.css('z-index', '').css('top', '').css('position', '');
			item.insertAfter(next);
		});
		orderItems();
	}
	
	function addBefore(item){
		unbindToolbar();
		$.get( "/getFormEntryRow.php?form=" + formID, function( data ) {
			$( "#formHolder ul" ).append( data );
			$( "#formHolder ul li" ).last().prepend( rowFunctions() );
			$( "#formHolder ul li" ).last().detach().insertBefore( $(item) );
			
			orderItems();
			bindToolbar();
		});	
	}
	
	function addAfter(item){
		unbindToolbar();
		$.get( "/getFormEntryRow.php?form=" + formID, function( data ) {
			$( "#formHolder ul" ).append( data );
			$( "#formHolder ul li" ).last().prepend( rowFunctions() );
			$( "#formHolder ul li" ).last().detach().insertAfter( $(item) );
		
			orderItems();
			bindToolbar();
		});	
	}
	
	function unbindToolbar(){
		$('.but').unbind();
		$('select.select.type').unbind();
		$('input[name="listType"]').unbind();
		$('.showSettings').unbind();
	}
	
	function capitaliseFirstLetter(string){
		return string.charAt(0).toUpperCase() + string.slice(1);
		}
	
	function toPlaceholder(label){
		return "Enter " + (label);
	}
	
	function toFormName(label){
		//replace
		return "form-" + (label).replace(/ /g, "-");;
	}
	
	function bindToolbar(){
		
		$('select.select.type').change(function(event){
			var t = $(this).find('option:selected').attr('data-type');
			$(this).closest('li').first().attr('class', t ); // remove non type related classes and then add current
			//console.log( t );
		});
		
		$('.showSettings').click(function(){
			$(this).closest('.advancedSettings').toggleClass('show');
			if( $(this).closest('.advancedSettings').hasClass('show') ){
				$(this).html('<i class="fa fa-cog"></i> Hide Advanced');
			}else{
				$(this).html('<i class="fa fa-cogs"></i> Show Advanced');
			}
		});
		
		$('input[name="listType"]').click(function(event){
			//event.preventDefault();
			var p = $(this).closest('li'); //().parent().parent();//.attr('class'
				$(p).removeClass('list-type-1 list-type-2 list-type-');
				$(p).addClass('list-type-' + $(this).attr('value') );
				
			//	event.stopPropagation();
				 
		});
		
		$('input[name="label"]').unbind();
		$('input[name="label"]').on("keyup change", function(e) {
				var name = $(this).closest('.form_row_object').find('input[name="name"]');
				var placeholder = $(this).closest('.form_row_object').find('input[name="placeholder"]');
				
				var tVal = $(this).attr('value');
				var nVal = $(name).attr('value');
				var pVal = $(placeholder).attr('value');
				
				if (e.keyCode == 8 ) {
						//backspace
						if ( nVal.substr(0, (nVal.length -1)) == toFormName(tVal) ) {
								$(name).attr('value', toFormName(tVal) );
						}
						
						if ( pVal.substr(0, (pVal.length -1)) == toPlaceholder(tVal) ) {
								$(placeholder).attr('value', toPlaceholder(tVal) );
						}
						
						if ( tVal == "") {
								$(placeholder).attr('value', '');
								$(name).attr('value', '');
						}
						
				}else{
						//console.log( "This: " + tVal + " Name: " + nVal + " Placeholder: " + pVal );
						if ( nVal == "" || nVal  == toFormName(tVal.substr(0, (tVal.length -1) )) ){
								$(name).attr('value', toFormName(tVal) );
						}
						
						if ( pVal == "" || pVal  == toPlaceholder(tVal.substr(0, (tVal.length -1)) ) ){
								$(placeholder).attr('value', toPlaceholder(tVal) );
						}
						
						
				}
		});
		
		$('.but').click(function(){
			var t = $(this).parent().parent();
			var c = $(this).attr('class');
			switch( c ){
				case 'butUp but btn':
					moveUp( t );
				break;
				case 'butDown but btn':
					moveDown( t );
				break;
				case 'butAddBefore but btn':
					addBefore( t );
				break;
				case 'butAddAfter but btn':
					addAfter( t );
				break;
				case 'butDelete but btn':
					//$(this).parents('li').addClass('deleted');
					//$(this).parents('li').find('input[name="isDeleted"]').attr('value', 1);
					
					if( $(this).parents('li').find("input[name='id']").attr('value') == "" ){
						//no value has been assigned
						$(this).parents('li').remove();
					}else{
						//flag for deletion - hide other elements
						$(this).parents('li').find("input[name='isDeleted']").attr('value', 1);
						$(this).parents('li').addClass('deleted');
						
						$(this).parents('li').find('form .form_row_object').append('<div class="row undo"><button class="undo btn">Undo Delete</button></div>');
						
						$(this).parents('li').find('form .form_row_object').find('.undo.btn').click(function(event){
							event.preventDefault();	
							$(this).parents('li').find("input[name='isDeleted']").attr('value', 0);
							$(this).parents('li').removeClass('deleted');
							$(this).parent().remove();
						});
					}

				break;
				default:
					//console.log( c );
				break;
			}
		});
	}

	function orderItems(){
		$('#formHolder ul li .form_row_object').not('li.deleted').each(function(index){
			$(this).find(":input[name='rowOrder']").attr('value',index);
		});
	}
	
	function rowFunctions(){
		//for sorting up down and delete?
		return '<div class="tools">' +
					'<div class="butUp but btn"><i class="fa fa-angle-double-up"></i></div>' +
					'<div class="butDown but btn"><i class="fa fa-angle-double-down"></i></div>' +
					'<div class="butAddBefore but btn"><i class="fa fa-caret-square-o-up"></i> Add Before</div>' +
					'<div class="butAddAfter but btn"><i class="fa fa-caret-square-o-down"></i> Add After</div>' +
					'<div class="butDelete but btn"><i class="fa fa-trash"></i></div>' +
				'</div>';
	}
	
	$(function(){
		$('#addRow').click(function(){
			unbindToolbar();
			$.get( "/getFormEntryRow.php?form=" + formID, function( data ) {
				$( "#formHolder ul" ).append( data );
				$( "#formHolder ul li" ).last().prepend( rowFunctions() );
				//$( "#formHolder ul li select").last().selectmenu();
				orderItems();
				bindToolbar();
			});			
		});
		
		$('#save').click(function(){
			orderItems(); // build into below
			var save = [];
			$('#formHolder ul li .form_row_object').each(function(index){
				var formDataObj = {};
				$(this).find(":input").not("[type='submit']").not("[type='reset']").each(function(){
					var thisInput = $(this);
					if( $(this).attr('type') == "radio" ){
						//radio - only record if it is selected
						if( $(this).is(':checked') ){
							formDataObj[thisInput.attr("name")] = thisInput.val();
						}
					}else{
						formDataObj[thisInput.attr("name")] = thisInput.val();
					}
				});
				//console.log( formDataObj );
				save.push(  formDataObj );
			});
			var saveString = JSON.stringify(save);
			//console.log( saveString  );
			
			$.post( "/saveForm.php", { formID: formID , ownerID : formOwner, form: saveString })
			  .done(function( data ) {
				 //check for codes or errors 
				var obj = jQuery.parseJSON( data );
				if( obj !== null ){
					for(var o = 0; o < obj.length; o++){
						if( obj[o].tempID != "" && obj[o].id != "" ){
							if( obj[o].deleted == 1 ){
								$('#' + obj[o].tempID).parents('li').remove();
							}else{
								$('.form_row_object .row.hidden input[value="' + obj[o].tempID + '"]').parent().find('input[name="id"]').attr('value', obj[o].id);
							}
						}
					}
				}
				alert("Saved"); //disable overlay?
			  });
		});
		
		$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			stop: function(event, ui) { 
				//window.alert("dropped");
				orderItems();
			}
		});
		
		//initilize
		$( "#formHolder ul li" ).prepend( rowFunctions() );
		bindToolbar();
		//$("#formHolder ul li select.select.type").selectmenu();
		/*
	$( document ).tooltip({show: null,
      position: {
        my: "left top",
        at: "left bottom"
      },
      open: function( event, ui ) {
        ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
      }
	  });*/
	});