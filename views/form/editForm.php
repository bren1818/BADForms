<?php
	include "../../includes/include.php";
	pageHeader();
?>
<!--Form Generated by Brendon Irwin's Form Generator-->
<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
<link rel="stylesheet" href="<?php echo CSS_DIR.'/formBuilder.css'; ?>"/>
<link rel="stylesheet" href="<?php echo CSS_DIR.'/formPreview.css'; ?>"/>
<?php
	getWYSIWYGIncludes();
	

	$conn = getConnection(); //set to DB Conn
	$theform = new Theform($conn); 

	if( isPostback() ){

			if( isset($_POST['formID']) ){
				$theform = $theform->load(  $_POST['formID'] );	
			}
			
			$owner = $theform->getOwner();
			
			$theform->getFromPost();
			$theform->setOwner( $owner );
			//$theform->setEnabled(1);
			$theform->setLastUpdated( date('Y-m-d H:i:s',time()) );
			
			if( $theform->getSunrise() != ""){
				$theform->setSunrise( getdatetime( $theform->getSunrise() ) );
			}
			
			if( $theform->getSunset() != "" ){
				$theform->setSunset( getdatetime( $theform->getSunset() ) );
			}
			
			if( $theform->getEncryptionmode() != 2 ){
				if( trim($theform->getEncryptionsalt()) == ""){
					$theform->setErrorCount( $theform->getErrorCount() + 1 );
					$theform->setErrors( $theform->getErrors().'<p>A Salt is required if this form allows for encryption</p>');
				}
			}
		
		/*Perform Save*/
	
		if( $theform->getErrorCount() > 0 ){
			echo $theform->getErrors();
		}else{
			if( $theform->save() > 0 ){
				echo '<div class="formRow"><p>Update Saved!</p></div>';
			}
		}
	}else{
		if( isset($_REQUEST) ){
			if( isset($_REQUEST['formID']) ) {
				
				$theform = $theform->load( $_REQUEST['formID'] );
			}else{
				echo '<h2>Error No FOrm ID!</h2>';
				exit;
			}
		}else{
			echo '<h2>Error No Form ID!</h2>';
			exit;	
		}
	}
	
	if(  null !== ($theform->getJqTheme()) && $theform->getJqTheme() != "" && null !== ($theform->getJqVersion()) && $theform->getJqVersion() != "" ){
	
	echo ' <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/'.$theform->getJqVersion().'/themes/'.$theform->getJqTheme().'/jquery-ui.css" />';
	
		}else{
	?>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <?php
		}
	?>





<form name="theform" id="theform" method="POST" action="" enctype="multipart/form-data">
	<div class="formRow">
		<div class="rowLabel">
			<label for="title"><i class="fa fa-pencil"></i> Title:*</label>
		</div>
		<div class="rowField">
			<input type="text" name="title" id="title" value="<?php echo (isset($theform) ?  $theform->getTitle() : ''); ?>"  title="Title required" required="required"/>
		</div>
	</div>
	<div class="formRow">
		<div class="rowLabel">
			<label for="description"><i class="fa fa-info"></i> Description of Form:</label>
		</div>
		<div class="rowField">
			<textarea name="description" id="Description"  title="" ><?php echo (isset($theform) ?  $theform->getDescription() : ''); ?></textarea>
		</div>
	</div>
    
	<div class="formRow">
		<div class="rowLabel">
			<label for="encryptionMode"><i class="fa fa-unlock-alt"></i> Encryption Mode:*</label>
		</div>
		<div class="rowField">
			<?php $encryptionMode_values = array("All", " Some", " None"); ?>
            <?php if( $theform->getEncryptionMode() == ""){ $theform->setEncryptionMode(2); } /*Default to no Encryption*/ ?>
			<?php for($sm = 0; $sm < sizeof( $encryptionMode_values); $sm++){ 
				if( $sm == $theform->getEncryptionMode() ){
				?>
				<label><?php echo $encryptionMode_values[$sm]; ?>: <input disabled="disabled" type="radio" name="encryptionMode" id="encryptionMode" value="<?php echo $sm; ?>" <?php if( ( is_object($theform) &&  $theform->getEncryptionMode() ?  $theform->getEncryptionMode()  : '') == $sm){ echo " checked"; } ?> /></label><br />
			<?php
				}
			 } ?>
		</div>
	</div>
    <div class="formRow">
    	*Note Encryption cannot be modified after creation
    </div>
    
	<div class="formRow">
		<div class="rowLabel">
			<label for="jqVersion"><i class="fa fa-code-fork"></i> jQuery Version:</label>
		</div>
		<div class="rowField">
        	<?php
				$default = ""; 
				if( isset($theform) && $theform->getJqVersion() != "" ){
					$default = trim($theform->getJqVersion());
				}
				?>
                <select name="jqVersion" id="jqVersion" title="" />
				<?php
				$query = "SELECT distinct `themeVersion` FROM `jquerythemes`";
				$query = $conn->query( $query );
				if( $query->execute() ){
					
					
					while( $result = $query->fetch(PDO::FETCH_ASSOC) ){
						echo '<option value="'.$result["themeVersion"].'" '.($default == $result["themeVersion"] ? 'selected' : '').'>'.$result["themeVersion"].'</option>';
						if( $default == ""){ $default = $result["themeVersion"]; }
					}
				}
				?>
           		</select> 
		</div>
	</div>
   
	<div class="formRow jqueryTheme">
		<div class="rowLabel">
			<label for="jqTheme"><i class="fa fa-css3"></i> jQuery Theme:</label>
		</div>
		<div class="rowField">
			<select  name="jqTheme" id="jqTheme" data-selected="<?php echo (isset($theform) ?  $theform->getJqTheme() : ""); ?>" data-version="<?php echo (isset($theform) ?  ($theform->getJqversion() == "" ? $default : $theform->getJqversion() ) : "" ); ?>" title="">
			</select>
			<p>For theme previews go to: <a target="_blank" href="http://jqueryui.com/themeroller/">http://jqueryui.com/themeroller/</a> and select "Gallery"</p>
		</div>
	</div>
    
	<div class="formRow">
		<div class="rowLabel">
			<label for="sunrise"><i class="fa fa-calendar"></i> Sun rise:</label>
		</div>
		<div class="rowField">
			<label><i class="fa fa-calendar"></i> (mm/dd/yyyy) <input class="dateInput" type="text" name="sunrise" id="sunrise" value="<?php echo (isset($theform) ?  getinputdate($theform->getSunrise()) : ''); ?>" title=" Date should be in format mm/dd/yyyy HH:mm"/></label>
		</div>
	</div>
     <div class="formRow">
		<div class="rowLabel">
			<label for="notAvailableText"><i class="fa fa-info"></i> Not Available Text (prior to sunrise):</label>
		</div>
		<div class="rowField">
			<textarea name="notAvailableText" id="notAvailableText"  title="" ><?php echo ( (isset($theform) && $theform->getNotAvailableText() !="" )  ?  $theform->getNotAvailableText() : FORM_NOT_ACTIVE_TEXT); ?></textarea>
		</div>
	</div>
    
	<div class="formRow">
		<div class="rowLabel">
			<label for="sunset"><i class="fa fa-calendar"></i> Sun set:</label>
		</div>
		<div class="rowField">
			<label><i class="fa fa-calendar"></i> (mm/dd/yyyy) <input class="dateInput" type="text" name="sunset" id="sunset" value="<?php echo (isset($theform) ?  getinputdate($theform->getSunset()) : ''); ?>" title=" Date should be in format mm/dd/yyyy HH:mm" /></label>
		</div>
	</div>
    
         <div class="formRow">
		<div class="rowLabel">
			<label for="expiredText"><i class="fa fa-info"></i> Form Expired Text (post sunset):</label>
		</div>
		<div class="rowField">
			<textarea name="expiredText" id="expiredText"  title="" ><?php echo ( (isset($theform) && $theform->getExpiredText() !="" ) ?  $theform->getExpiredText() : FORM_EXPIRED_TEXT); ?></textarea>
		</div>
	</div>
    
     <div class="formRow">
		<div class="rowLabel">
			<label for="submissionText"><i class="fa fa-info"></i> Submission Text:</label>
		</div>
		<div class="rowField">
			<textarea name="submissionText" id="submissionText"  title="" ><?php echo ( (isset($theform) && $theform->getSubmissionText() !="" ) ?  $theform->getSubmissionText() : FORM_SUBMISSION_TEXT); ?></textarea>
		</div>
	</div>
	
    
	<br />
	<div class="clear"></div>
	<h4>Advanced options</h4>
	<p><hr /></p>
	<div class="clear"></div>
	
	<div class="formRow caching">
		<div class="rowLabel">
			<label for="useCaching"><i class="fa fa-clock-o"></i> Use Caching:</label>
		</div>
		<div class="rowField">
			<select name="useCaching">
				<option value="0" <?php if( $theform->getUseCaching() == 0 ){ echo " selected"; } ?>>No</option>
				<option value="1" <?php if( $theform->getUseCaching() == 1 ){ echo " selected"; } ?>>Yes</option>
			</select>
		</div>
	</div>	
	
	<div class="formRow caching">
		<div class="rowLabel">
			<label for="isPrivate"><i class="fa fa-user-secret"></i> Form is private (Show Publicly in list of forms):</label>
		</div>
		<div class="rowField">
			<select name="isPrivate">
				<option value="0" <?php if( $theform->getIsPrivate() == 0 ){ echo " selected"; } ?>>No</option>
				<option value="1" <?php if( $theform->getIsPrivate() == 1 ){ echo " selected"; } ?>>Yes</option>
			</select>
		</div>
	</div>	
	  
    <div class="formRow active">
		<div class="rowLabel">
			<label for="enabled"><i class="fa fa-check-square-o"></i> Form Enabled:</label>
		</div>
		<div class="rowField">
			<select name="enabled">
				<option value="0" <?php if( $theform->getEnabled() == 0 ){ echo " selected"; } ?>>No</option>
				<option value="1" <?php if( $theform->getEnabled() == 1 ){ echo " selected"; } ?>>Yes</option>
			</select>
		</div>
	</div>	
    
    
	<div class="formRow active">
		<div class="rowLabel">
			<label for="formActive"><i class="fa fa-css3"></i> Use Preview CSS:</label>
		</div>
		<div class="rowField">
			<select name="usePreviewCSS">
				<option value="0" <?php if( $theform->getUsePreviewCSS() == 0 ){ echo " selected"; } ?>>No</option>
				<option value="1" <?php if( $theform->getUsePreviewCSS() == 1 ){ echo " selected"; } ?>>Yes</option>
			</select>
		</div>
	</div>	
    
    <div class="formRow">
		<div class="rowLabel">
			<label for="notActiveText"><i class="fa fa-info"></i> Not Enabled Text:</label>
		</div>
		<div class="rowField">
			<textarea name="notActiveText" id="notActiveText"  title="" ><?php echo (  (isset($theform) && $theform->getNotActiveText() !="" ) ?  $theform->getNotActiveText() : FORM_NOT_ENABLED_TEXT); ?></textarea>
		</div>
	</div>
	
	


<div class="formRow">
		<div class="rowLabel">
			<i class="fa fa-eye"></i> Number of Views
		</div>
		<div class="rowField">
			<?php echo (  (isset($theform)  ) ?  $theform->getNumViews() : ''); ?>
		</div>
	</div>
    <div class="formRow">
		<div class="rowLabel">
			<i class="fa fa-envelope-o"></i> Number of Submissions
		</div>
		<div class="rowField">
			<?php echo (  (isset($theform)  ) ?  $theform->getNumSubmissions() : ''); ?>
		</div>
	</div>



	
	<div class="clear"></div>
	<p><hr /></p>
	<div class="clear"></div>
	
	
	<div class="formRow rowCenter">
    	<input type="hidden" name="formID" value="<?php echo $theform->getId(); ?>" /><br />
		<button class="btn"><i class="fa fa-floppy-o"></i> Update Settings</button> | <a class="btn" href="/views/form/cloneForm.php?formID=<?php echo $theform->getId(); ?>">Clone Form</a> | <a class="btn" href="/views/form/deleteForm.php?formID=<?php echo $theform->getId(); ?>">Delete Form</a> 
        <hr /><br />
        <a class="btn" href="/views/form/buildForm.php?formID=<?php echo $theform->getId(); ?>"><i class="fa fa-code"></i> Build Form</a>
        <a class="btn" href='/views/form/reviewSubmissions.php?formID=<?php echo $theform->getId(); ?>'><i class='fa fa-clipboard'></i> View Submissions</a>
        <a class="btn" href="/"><i class="fa fa-home"></i> Home</a>
	</div>
	
	<!-- Custom Save Handler? -->
	
</form>
<?php
initWYSIWYG();
?>
<script type="text/javascript" src="<?php echo JS_DIR.'/formBuilder.js'; ?>"></script>
<?php
	pageFooter();
?>