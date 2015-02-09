<?php
	//form ID
	//code type 1 = css 2 = js
	
	error_reporting(E_ALL);
	
	include "../../includes/include.php";
	//include "../../classes/includes.php";

	pageHeader();
	?>
	<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
	<?php
	$conn = getConnection();
	$form = new Formcode($conn);
	
	if( !isPostback() ){

		if( isset($_REQUEST) && isset($_REQUEST['id']) ){
			$codeID = $_REQUEST['id'];
			$form = $form->load( $codeID );
			$codeType = $form->getCodeType();
		}else{
	
			if( isset($_REQUEST) ){	
				$formID = $_REQUEST['formID'];
				$codeType = $_REQUEST['codeType'];
				
				$form->setFormID( $formID);
				$form->setCodeType( $codeType );
			
			}
		}
	}
	
	
	
	if( isPostback() ){
		
		$form->getFromPost();
		
		if( isset($_POST['id']) ){
			$form->setId( $_POST['id'] );
		}
		
		if( $form->getVersion() == "" ){
			$form->setVersion( 0 );
		}else{
			$v = $form->getVersion();
			$v++;
			$form->setVersion( $v );
		}
		
		if( $form->save() > 0 ){
			echo "<p><span class='saveMsg'><i class='fa fa-floppy-o'></i> Saved<span></p>";
		}
	}
	
	if( $form->getCodeType() == 1 ){
		//CSS
		echo '<h2>Edit FORM CSS</h2>';
	}
	
	if( $form->getCodeType() == 2 ){
		//JS
		echo '<h2>Edit FORM JS</h2>';
	}
	
	
	?>
	<p>Do not include &lt;style&gt; or &lt;script&gt; tags</p>
	<p>F11 - Go full screen, ctrl+space for code hint</p>
	<form id="codeForm" method="POST" action="/views/form/formCssJS.php">
		<div class="row">
			<textarea name="code" id="code"><?php echo $form->getCode(); ?></textarea>
		</div>
		<div class="row">
			<button class="btn" id="save"><i class="fa fa-floppy-o"></i> Save</button> 
		</div>
		<input type="hidden" name="id" value="<?php echo $form->getId(); ?>" />
		<input type="hidden" name="formID" value="<?php echo $form->getFormID(); ?>" />
		<input type="hidden" name="codeType" value="<?php echo $form->getCodeType(); ?>" />
		<input type="hidden" name="version" value="<?php echo $form->getVersion(); ?>" />
	</form>
	
	
	<div class="clear"></div>
	<script type="text/javascript">
		var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
			lineNumbers: true,
			styleActiveLine: true,
			matchTags: {bothTags: true},
		<?php if( $form->getCodeType() == 1 ){ ?>
			mode: "text/css", //text/html
		<?php } else {	?>
			mode: "text/javascript", //text/html
		<?php } ?>
			extraKeys: { 
				"F11": function(cm) {
				  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
				},
				"Esc": function(cm) {
				  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
				},
				"Ctrl-Space": "autocomplete",
				"Ctrl-J": "toMatchingTag"
			}
		});
		
		
		$(window).bind('keydown', function(event) {
			if (event.ctrlKey || event.metaKey) {
				switch (String.fromCharCode(event.which).toLowerCase()) {
				case 's':
					event.preventDefault();
					//alert('ctrl-s');
					$('#codeForm').submit();
					break;
				}
			}
		});
		
		$(function(){
			if( $('p span.saveMsg').length ){
				$('p span.saveMsg').fadeOut(2500);	
			}
		});
	</script>
   
	
	<a class="btn" href="/views/form/buildForm.php?formID=<?php echo $form->getFormID(); ?>"><i class="fa fa-pencil"></i> Go back to Form Builder</a>
	
	<?php
	
	
	pageFooter();
?>