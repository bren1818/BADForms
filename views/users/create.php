<?php
	include "../../includes/include.php";
	pageHeader("Create User");
	
	$admin = new admin();
	
	if( isPostback() ){
		$conn = getConnection();
		
		$admin->setConnection( $conn );
		$admin->getFromPost();
		
		$errors = "";
		$errorCount = 0;
		
		//post and not update
		
		if( $admin->getUsername() != "" && $admin->getPassword() != ""){
	
			$query = $conn->prepare("Select count(`id`) as `cnt` FROM `admin` WHERE `username` = :username");
			$username = $admin->getUsername();
			$query->bindParam(':username',$username );
			
			if( $query->execute() ){
				$result = $query->fetch();
				if( $result["cnt"] > 0 ){
					//user already exists
					$errors .= "<p>A user with the username: ".$username." already exists.</p>";
					$errorCount++;
				}
			}
			
			if( $admin->getEmail() != "" ){
				if( ! filter_var($admin->getEmail(), FILTER_VALIDATE_EMAIL) ){
					$errors .= "<p>The email: ".$admin->getEmail()." appears invalid.</p>";
					$errorCount++;
				}
			}
			
			if( $errorCount == 0 ){
				$salt = getUniqueID();
				$email = $admin->getEmail();
				$salt = hash('sha1',($salt.$email."badForms"));
				$password = $admin->getPassword();
				$truePassword = hash('sha1', $salt.$password);
				$admin->setSalt( $salt );
				$admin->setPassword( $truePassword );
			
				//$admin->setLastLogin( getCurrentDateTime() );
				$admin->setCreationDate( getCurrentDateTime() );
				
				if( $admin->save() > 0 ){
					echo '<h1>'.$admin->getUsername().' created successfully.</h1>';
					
					
					pageFooter();
					exit;
				}else{
					$errors .= "<p>The user: ".$admin->getUsername()." could not be saved, please try again</p>";
					$errorCount++;
				}
			}
			
			
			//pa( $admin );
			
			if( $errorCount > 0 ){
				echo '<p>'.$errorCount.' error(s) were found.</p>';
				echo $errors;
			}
		}
	
		
	}
	
	if( $currentUser->getUserLevel() == 1 ){
?>
	
	<link rel="stylesheet" href="/css/formPreview.css" />
	<form class="form previewForm" method="POST" action="/views/users/create.php">
		<div class="formRow">
			<h2><i class="fa fa-user-plus"></i> Setup Admin Account</h2>
			<p>Please create a password with atleast 1 small-case letter, 1 Capital letter, 1 digit, 1 special character and the length should be atleast 6 characters. The sequence of the characters is not important. 
		</div>
		
		<div class="formRow">
			<div class="formRowLabel">
				<label for="username">
					<span class="labelText"><i class="fa fa-child"></i> Username: </span>		
				</label>
			</div>
			<div class="formRowInput">
				<input class="inputBox" type="text" name="username" id="username" value="<?php echo $admin->getUsername() ?>" placeholder="Username" title="Enter a username" required="required" pattern="([a-zA-Z]+[0-9]*){3,20}" />
			</div>	
		</div>
		
		<div class="formRow">
			<div class="formRowLabel">
				<label for="userLevel">
					<span class="labelText"><i class="fa fa-user"></i> User Type: </span>		
				</label>
			</div>
			<div class="formRowInput">
				<select name="userLevel" id="userLevel" title="Select User Type">
					<option value="2"<?php if( $admin->getuserLevel() == 2){echo " selected"; }?>>Standard Admin</option>
					<option value="1"<?php if( $admin->getuserLevel() == 1){echo " selected"; }?>>Super Admin</option>
				</select>
			</div>	
		</div>
		
		
		<div class="formRow">
			<div class="formRowLabel">
				<label for="password">
					<span class="labelText"><i class="fa fa-unlock"></i> Password: </span>		
				</label>
			</div>
			<div class="formRowInput">
				<input class="inputBox" type="password" name="password" id="password" value="" title="Enter your Password" required="required" pattern="(?=^.{6,60}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s).*$"/>
			</div>	
		</div>
		
				
		<div class="formRow">
			<div class="formRowLabel">
				<label for="email">
					<span class="labelText"><i class="fa fa-envelope-o"></i> Email: </span>		
				</label>
			</div>
			<div class="formRowInput">
				<input class="inputBox" type="email" name="email" id="email" value="<?php echo $admin->getEmail() ?>" title="Enter your Email" />
			</div>	
		</div>
		
		<div class="formRow">
			<div class="formRowLabel">
				<label for="enabled">
					<span class="labelText"><i class="fa fa-check-square-o"></i> Enabled: </span>		
				</label>
			</div>
			<div class="formRowInput">
				<input name="enabled" type="checkbox" value="1" <?php if( $admin->getEnabled() ){ ?>checked="checked"<?php } ?>/> 
			</div>	
		</div>
		
		
		<div class="formRow">
			<p align="center"><button class="btn"><i class="fa fa-check"></i> Submit</button></p>
		</div>
	</form>

	
	
<?php
	//echo $currentUser->getUserLevel();

	}else{
		echo "<p>You do not have Access</p>";
	}
	pageFooter();
?>