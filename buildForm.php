<?php
	include "includes/include.php";
?>
<style>
	.form_row_object{ width: 800px; margin: 10px auto; }
	.row{ margin: 5px 0px; width: 100%; padding: 5px 0px;}
	.row label{ width: 200px; display: inline-block; } 
	
	ul#sortable li:nth-child(odd) {
		background-color: rgba(0,255,0,.3);
	}
	ul#sortable li:nth-child(even) {
		background-color: rgba(0,0,255,.3);
	}
	
	ul#sortable{ padding: 0px; margin: 0px; list-style: none; }
	
	ul#sortable li:first-child .tools .butUp{ display: none; } 
	ul#sortable li:last-child .tools .butDown{ display: none; } 
	
	.tools{ clear: both; padding: 10px 0px; width: 100%; }
	.tools .but{ padding: 3px; background-color: #00F105; color: #000; font-weight: bold; display: inline-block; margin: 0px 10px; cursor: pointer; }
		
</style>


<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
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
			$(this).parents('li').attr('class', t );
			console.log( t );
		});
		
		//console.log("bind");
		$('.but').click(function(){
			//console.log("click");
			var t = $(this).parent().parent();
			var c = $(this).attr('class');
			switch( c ){
				case 'butUp but':
					//window.alert("up");
					moveUp( t );
				break;
				case 'butDown but':
					//window.alert("down");
					moveDown( t );
				break;
				case 'butDelete but':
					window.alert("delete");
				break;
				default:
					console.log( c );
				break;
			}
		});
	}

	function orderItems(){
		$('#formHolder ul li .form_row_object').each(function(index){
			$(this).find(":input[name='order']").attr('value',index);
		});
	}
	
	function rowFunctions(){
		//for sorting up down and delete?
		return '<div class="tools"><div class="butUp but">up</div><div class="butDown but">down</div><div class="butDelete but">Delete</div></div>'
	}
	
	$(function(){
		$('#addRow').click(function(){
			unbindToolbar();
			//window.alert("Go!");
			$.get( "getFormEntryRow.php?form=1", function( data ) {
				$( "#formHolder ul" ).append( '<li>' + rowFunctions() + data + '</li>' );
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
					formDataObj[thisInput.attr("name")] = thisInput.val();
				});
				//console.log( formDataObj );
				save.push(  formDataObj );
			});
			var saveString = JSON.stringify(save);
			console.log( saveString  );
		});
		
		$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			stop: function(event, ui) { 
				//window.alert("dropped");
				orderItems();
			}
		});
		
		$('#addRow').click();
		
		
	});
</script>

<div id="formHolder">
<ul id="sortable">
<?php /*
<li>
	<?php
		include "getFormEntryRow.php";
		$row = generateHtml("");
		echo $row;
	?>
</li>
*/?>
</ul>
</div>

<button id="addRow">Add Row</button>
<button id="save">Save</button>