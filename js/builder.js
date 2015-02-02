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
	
	function unbindToolbar(){
		$('.but').unbind();
		$('select.select.type').unbind();
	}
	
	function bindToolbar(){
		
		$('select.select.type').change(function(event){
			var t = $(this).find('option:selected').attr('data-type');
			$(this).parents('li').attr('class', t ); // remove non type related classes and then add current
			//console.log( t );
		});
		
		$('input[name="listType"]').click(function(){
			var p = $(this).parents('li');//.attr('class'
				$(p).removeClass('list-type-1 list-type-2');
				$(p).addClass('list-type-' + $(this).attr('value') );
		});
		
		
		$('.but').click(function(){
			var t = $(this).parent().parent();
			var c = $(this).attr('class');
			switch( c ){
				case 'butUp but':
					moveUp( t );
				break;
				case 'butDown but':
					moveDown( t );
				break;
				case 'butDelete but':
					$(this).parents('li').addClass('deleted');
					$(this).parents('li').find('input[name="isDeleted"]').attr('value', 1);
					window.alert("delete");
				break;
				default:
					console.log( c );
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
		return '<div class="tools"><div class="butUp but">up</div><div class="butDown but">down</div><div class="butDelete but">Delete</div></div>'
	}
	
	$(function(){
		$('#addRow').click(function(){
			unbindToolbar();
			$.get( "/getFormEntryRow.php?form=1", function( data ) {
				$( "#formHolder ul" ).append( data );
				$( "#formHolder ul li" ).last().prepend( rowFunctions() );
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
			
			$.post( "/saveForm.php", { formID: "<?php echo $formID; ?>", ownerID : "<?php echo $ownerID; ?>", form: saveString })
			  .done(function( data ) {
				 //check for codes or errors 
				var obj = jQuery.parseJSON( data );
				if( obj !== null ){
					for(var o = 0; o < obj.length; o++){
						if( obj[o].tempID != "" && obj[o].id != "" ){
							console.log( obj[o].tempID + " > " + obj[o].id );
							$('.form_row_object .row.hidden input[value="' + obj[o].tempID + '"]').parent().find('input[name="id"]').attr('value', obj[o].id);
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
	});