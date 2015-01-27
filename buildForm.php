<?php
	include "includes/include.php";
?>
<style>
	.form_row_object{ width: 800px; margin: 10px auto; }
	.row{ margin: 5px 0px; width: 100%; padding: 5px 0px;}
	.row label{ width: 200px; display: inline-block; } 
	
	.form_row_object:nth-child(2) {
		background: #ff0000;
	}
</style>


<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
	function buildToolbar(){
		
	}
	
	

	function orderItems(){
		$('#formHolder ul li .form_row_object').each(function(index){
			$(this).find(":input[name='order']").attr('value',index);
		});
	}
	
	function rowFunctions(){
		//for sorting up down and delete?
	}
	
	$(function(){
		$('#addRow').click(function(){
			//window.alert("Go!");
			$.get( "getFormEntryRow.php?form=1", function( data ) {
				$( "#formHolder ul" ).append( '<li>' + data + '</li>' );
				orderItems();
			});
						
		});
		
		$('#save').click(function(){
			orderItems(); // build into below
			$('#formHolder ul li .form_row_object').each(function(index){
				var formDataObj = {};
				$(this).find(":input").not("[type='submit']").not("[type='reset']").each(function(){
					var thisInput = $(this);
					formDataObj[thisInput.attr("name")] = thisInput.val();
				});
				console.log( formDataObj );
			});
		});
		
		$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			stop: function(event, ui) { 
				//window.alert("dropped");
				orderItems();
			}
		});
		
		
		
		
	});
</script>

<div id="formHolder">
<ul id="sortable">
<li>
	<?php
		include "getFormEntryRow.php";
		$row = generateHtml("");
		echo $row;
	?>
</li>
</ul>
</div>

<button id="addRow">Add Row</button>
<button id="save">Save</button>