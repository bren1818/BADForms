<?php
	include "../../includes/include.php";
	pageHeader("Create Form");
?>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!--Form Generated by Brendon Irwin's Form Generator-->
<!--<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/> -->

<link rel="stylesheet" href="<?php echo CSS_DIR.'/formBuilder.css'; ?>"/>
<link rel="stylesheet" href="<?php echo CSS_DIR.'/formPreview.css'; ?>" />

<?php
	$conn = getConnection(); //set to DB Conn
	$theform = new Theform($conn); 
	if(strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
		$theform->getFromPost();
		$theform->setEnabled(1);
		$theform->setIsGroup(0);
		
		if( $theform->getSunrise() != "" ){
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
			if( $theform->getCreated() == "" ){
                            $theform->setCreated( date('Y-m-d H:i:s',time()) );
                        }
			
			if( $theform->save() > 0 ){
				header("Location: /views/form/buildForm.php?formID=".$theform->getId());
			}else{
				echo "<p>There was an error in your submission, please try again.</p>";
				echo $theform->getErrors();
			}
		}
		
	}
?>
<form name="theform" id="theform" method="POST" action="" enctype="multipart/form-data">
	<div class="formRow">
		<div class="formRowLabel">
			<label for="title"><i class="fa fa-pencil"></i> Title:*</label>
		</div>
		<div class="formRowInput">
			<input type="text" name="title" id="title" value="<?php echo (isset($theform) ?  $theform->getTitle() : ''); ?>"  title="Title required" required="required"/>
		</div>
	</div>
	<div class="formRow">
		<div class="formRowLabel">
			<label for="description"><i class="fa fa-info"></i> Description of Form:</label>
		</div>
		<div class="formRowInput">
			<textarea name="description" id="Description"  title="" ><?php echo (isset($theform) ?  $theform->getDescription() : ''); ?></textarea>
		</div>
	</div>
	<div class="formRow">
		<div class="formRowLabel">
			<label for="encryptionMode"><i class="fa fa-unlock-alt"></i> Encryption Mode:*</label>
		</div>
		<div class="formRowInput">
			<?php $encryptionMode_values = array("All", " Some", " None"); ?>
            <?php if( $theform->getEncryptionMode() == ""){ $theform->setEncryptionMode(2); } /*Default to no Encryption*/ ?>
			<?php for($sm = 0; $sm < sizeof( $encryptionMode_values); $sm++){ ?>
				<label><?php echo $encryptionMode_values[$sm]; ?>: <input type="radio" name="encryptionMode" id="encryptionMode" value="<?php echo $sm; ?>" <?php if( ( is_object($theform) &&  $theform->getEncryptionMode() ?  $theform->getEncryptionMode()  : '') == $sm){ echo " checked"; } ?>  required="required" /></label><br />
			<?php } ?>
		</div>
	</div>
    <div class="formRow">
    	*Note Encryption cannot be modified after creation
    </div>
	<div class="formRow encryptionSalt encryption-mode-<?php echo $theform->getEncryptionMode();  ?>">
		<div class="formRowLabel">
			<label for="encryptionSalt"><i class="fa fa-key"></i> Encryption Salt: - This is the second tier of making the encryption more difficult. You can provide one or use the generated one.</label>
		</div>
		<div class="formRowInput">
			<input type="text" pattern=".{0,60}" name="encryptionSalt" id="encryptionSalt" value="<?php echo isset($theform) ?  (($theform->getEncryptionSalt() != "" ) ?  $theform->getEncryptionSalt() : trim(md5(time()))  ) : trim(md5(time())); ?>"  title="" />
		</div>
	</div>
	
    <div class="formRow">
		<!--
        <div class="formRowLabel">
			<label for="owner">Owner:</label>
		</div>
		<div class="formRowInput">
			<input type="number" name="owner" id="owner" value="<?php echo (isset($theform) ?  $theform->getOwner() : ''); ?>" title="" />
		</div>
        -->
         <input type="hidden" name="owner" value="1" /> <!-- to hook up later -->
	</div>
  
   
    
	<div class="formRow">
		<div class="formRowLabel">
			<label for="jqVersion"><i class="fa fa-code-fork"></i> jQuery Version:</label>
		</div>
		<div class="formRowInput">
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
		<div class="formRowLabel">
			<label for="jqTheme"><i class="fa fa-css3"></i> jQuery Theme:</label>
		</div>
		<div class="formRowInput">
        	<select  name="jqTheme" id="jqTheme" data-selected="<?php echo (isset($theform) ?  $theform->getJqTheme() : ""); ?>" data-version="	<?php echo (isset($theform) ?  ($theform->getJqversion() == "" ? $default : $theform->getJqversion() ) : "" ); ?>" title="">
            </select>
            
            <p><i class="fa fa-info-circle"></i> For theme previews go to: <a target="_blank" href="http://jqueryui.com/themeroller/">http://jqueryui.com/themeroller/</a> and select "Gallery"</p>
        </div>
	</div>
	
	<div class="formRow">
		<div class="formRowLabel">
			<p><i class="fa fa-info-circle"></i> Sunrise/Set functionality can be used independantly of each other. Eg you can have a form which begins in the future and runs indefinitely, or starts now, and ends at a specified time. Neither are required.</p>
		</div>
	</div>	
	
	<div class="formRow">
		<div class="formRowLabel">
			<label for="sunrise"><i class="fa fa-sun-o"></i> Sun rise: (This determines when the form will become active)</label>
		</div>
		<div class="formRowInput">
			<label><i class="fa fa-calendar"></i> (mm/dd/yyyy) <input class="dateInput" type="text" name="sunrise" id="sunrise" value="<?php echo (isset($theform) ?  getinputdate($theform->getSunrise()) : ''); ?>" title=" Date should be in format mm/dd/yyyy"/></label>
		</div>
	</div>
	<div class="formRow">
		<div class="formRowLabel">
			<label for="sunset"><i class="fa fa-bed"></i> Sun set: (This determins when the form will become in-active)</label>
		</div>
		<div class="formRowInput">
			<label><i class="fa fa-calendar"></i> (mm/dd/yyyy) <input class="dateInput" type="text" name="sunset" id="sunset" value="<?php echo (isset($theform) ?  getinputdate($theform->getSunset()) : ''); ?>" title=" Date should be in format mm/dd/yyyy" /></label>
		</div>
	</div>
	<div class="formRow rowCenter">
		<input type="submit" value="Submit" class="btn" />
	</div>
</form>
<script type="text/javascript" src="<?php echo JS_DIR.'/formBuilder.js'; ?>"></script>
<?php
	pageFooter();
?>