<?php
	include "../includes/include.php";
	pageHeader("User Setup" , false);
	
	if( ! isPostback() ){
	
		if( isset($_REQUEST) && isset($_REQUEST['first']) &&  $_REQUEST['first'] != "" ){
			$conn = getConnection();
			$admin = new Admin($conn);
			$admin = $admin->getByUsername("admin");
			if( $admin->getId() > 0 ){
				$first = $_REQUEST["first"];
				
				if( ( $admin->getPassword() == md5($first."badForms")) && is_null($admin->getSalt())  ){
					//echo "<br />Sanity Check Pass!";
				?>
				<link rel="stylesheet" href="/css/formPreview.css" />
				<style>
					.fa.green{ color: rgba(0,144,0,.7); }
					.fa.red{ color: rgba(255,0,0,.7); }
				</style>
					<form class="form previewForm" method="POST" action="firstUser.php">
						<div class="formRow">
							<h2>Setup Admin Account</h2>
							<p><i class="fa fa-user-secret"></i> Your admin account username is <b><u>admin</u></b></p>
							<p>Please create a password with atleast 1 small-case letter, 1 Capital letter, 1 digit, 1 special character and the length should be atleast 6 characters. The sequence of the characters is not important. 
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
								<label for="match">
									<span class="labelText"><i class="fa fa-unlock-alt"></i> Confirm Password: </span>	
								</label>
							</div>
							<div class="formRowInput">
								<input class="inputBox" type="password" name="match" id="match" value="" title="Enter your Password again" required="required" pattern="(?=^.{6,60}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s).*$"/>
							</div>	
							<div class="formRow" id="passCheck"></div>
						</div>
						
						<div class="formRow">
							<div class="formRowLabel">
								<label for="email">
									<span class="labelText"><i class="fa fa-envelope-o"></i> Email: </span>		
								</label>
							</div>
							<div class="formRowInput">
								<input class="inputBox" type="email" name="email" id="email" value="" title="Enter your Email" required="required"/>
							</div>	
						</div>
						
						<div class="formRow">
							<input type="hidden" name="first" value="<?php echo $first; ?>"/>
							<p align="center"><button class="btn"><i class="fa fa-sign-out"></i> Submit & Continue</button></p>
						</div>
					</form>
					<script>
						$(function(){
							 $("#match").keyup(function() {
								var password = $("#password").val();
								$("#passCheck").html(password == $(this).val()
									? "<i class='green fa fa-check'></i> Passwords match.  <i class='fa fa-lock'></i>"
									: "<i class='red fa fa-times'></i> Passwords do not match!"
								);
							});
						});
					</script>
					
				<?php	
				}else{
					echo "<h2>Sanity Check has failed.</h2>";
					echo "<p> Admin is already created or password has been set</p>";
				}
			}else{
				echo "<h2>An error has occurred - no Admin user exists - please re-run setup!</h2>";
				echo "<p><a class='btn' href='index.php'>Run Setup</a></p>";
			}
		}else{
			echo "<h2>It appears you have got here erroneously.</h2>";
			echo "<p><a class='btn' href='/'>Home</a></p>";
		}
	}else{
		//do checks
		$password = isset($_POST['password']) ? $_POST['password'] : "";
		$passwordCheck = isset($_POST['match']) ? $_POST['match'] : "";
		$email = isset($_POST['email']) ? $_POST['email'] : "";
		$validationCode = isset($_POST['first']) ? $_POST['first'] : "";
		
		$conn = getConnection();
		$admin = new Admin($conn);
		$admin = $admin->getByUsername("admin");
		if( $admin->getId() > 0 ){
			if( ( $admin->getPassword() == md5($validationCode."badForms")) && is_null($admin->getSalt())  ){
				//sanity complete
				
				//other checks
				//echo "Password: $password<br />";
				//echo "Check: $passwordCheck<br />";
				//echo "Email: $email;<br />";
				//echo "Validation code: $validationCode<br />";
				
				if( ($password == $passwordCheck) && filter_var($email, FILTER_VALIDATE_EMAIL) ){
					$salt = getUniqueID();
					$salt = hash('sha1',($salt.$email));
					$truePassword = hash('sha1', $salt.$password);
					
					$admin->setPassword($truePassword);
					$admin->setSalt($salt);
					$admin->setEmail($email);
					$admin->setEnabled(1);
					$admin->setLastLogin( getCurrentDateTime() );
					$admin->setCreationDate( getCurrentDateTime() );
					$admin->setUserLevel(1);
					
					//must re-add Connection
					$admin->setConnection( $conn );
						
					if( $admin->save() > 0 ){
						//echo "Saved!";
						echo "<h1>Setup Complete!</h1>";
						echo "<p>Setup is complete. Please go to the <i class='fa fa-home'></i> Home</a> screen to continue.</p>";
						echo "<br /><p><a class='btn' href='/'><i class='fa fa-home'></i> Home</a></p>";	
						logMessage("Setup Complete! - User: $email setup successfully.", "setup.txt", "" ,"");
						
						global $sessionManager;
						
						if( ! is_object($sessionManager) ){
							$sessionManager = new adminSession();
						}
						
						$sessionManager->setCurrentUser( "admin" );
						$sessionManager->setCurrentUserID( $admin->getId() );
						$sessionManager->renew();
						$sessionManager->save();
						
					}else{
						echo "<h2>Error Saving Your information. Please try again.</h2>";
						echo "<p>If this problem persists, contact your local system administrator or customer support</p>";
						echo "<p><a class='btn' href='?first=".$first."'>Try Again</a></p>";	
					}
				
				}else{
					echo "<h2>Error Saving Your information. Please try again</h2>";
					echo "<p><a class='btn' href='?first=".$first."'>Try Again</a></p>";
				}
			
			}else{
				echo "<h2>Sanity Check has failed.</h2>";
				echo "<p> Admin is already created or password has been set</p>";
			}
		}else{
			echo "<h2>An error has occurred - no Admin user exists - please re-run setup!</h2>";
			echo "<p><a class='btn' href='index.php'>Run Setup</a></p>";
		}	

	}
	
	logMessage("Finalizing setup", "setup.txt", "" ,"");
	pageFooter();
?>