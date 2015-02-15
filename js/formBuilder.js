$(function(){
	$('input[name="encryptionMode"]').change(function(event){
		var thisVal = $(this).val();
		$('.formRow.encryptionSalt').attr('class', 'formRow encryptionSalt encryption-mode-' + thisVal );
	});
	
	function setThemes(version){
		var defaultTheme = $('#jqTheme').attr('data-selected');
		$('#jqTheme').html();
		$.get('/views/helpers/jqthemes.php?version=' + version, function (data) {
			var themes = JSON.parse(data);
			if( themes.length > 0 ){
				for( var t = 0; t < themes.length; t++){
					if( themes[t] == defaultTheme ){
						$('#jqTheme').append('<option value="' +  themes[t] + '" selected>' + themes[t] + '</option>');
					}else{
						$('#jqTheme').append('<option value="' +  themes[t] + '">' + themes[t] + '</option>');
					}
				}
			}
		});
	}
	
	$('#jqVersion').change(function(){
		var version = $(this).val();
		setThemes( version );
	});
	
	if( $('#jqTheme').attr('data-version') != "" ){
		var version = 	$.trim( $('#jqTheme').attr('data-version') );
		setThemes(version);
	}
	
	$('#sunrise,#sunset').datepicker( {"dateFormat" : "mm/dd/yy"});
});