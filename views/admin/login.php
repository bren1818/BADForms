<?php
	include "../../includes/include.php";
	
	$username = "";
	
	if(  isPostback() ){
		$conn = getConnection();
		$admin = new Admin($conn);
		
		$password = isset($_POST['password']) ? $_POST['password'] : "";
		$username = isset($_POST['username']) ? $_POST['username'] : "";
		$errorMessage = "";
		
		//echo $username." : ".$password;
		
		$admin = $admin->getByUsername($username);
		
		if( is_object( $admin ) ){
			$salt = $admin->getSalt();
			$truePassword = hash('sha1', $salt.$password);
			
			if( $truePassword == $admin->getPassword() ){
				logMessage("$username logged in successfully", "logins.txt", "" ,"");
				
				$sessionManager->setCurrentUser( $username );
				$sessionManager->setCurrentUserID( $admin->getId() );
				$sessionManager->renew();
				$sessionManager->save();
				
				header("Location: /");
				
			}else{
				$errorMessage = "Unknown User or incorrect Password";	
			}
		}else{
			$errorMessage = "Unknown User or incorrect Password";	
		}
	}
	
	
	pageHeader();
	
	?>
    <link rel="stylesheet" href="/css/formPreview.css" />
    
    <?php
		//if( ! isPostback() ){
	?>
    		
    <form class="form previewForm" method="POST" action="login.php">
    	<?php
        	if( isset($errorMessage) && $errorMessage != ""){
				echo "<p>$errorMessage</p>";
			}
		?>
        <div class="formRow">
            <div class="formRowLabel">
                <label for="username">
                    <span class="labelText"><i class="fa fa-user-secret"></i> Username: </span>		
                </label>
            </div>
            <div class="formRowInput">
                <input class="inputBox" type="text" name="username" id="username" value="<?php echo $username; ?>" title="Username" placeholder="username" required="required"/>
            </div>	
        </div>
        
        
        <div class="formRow">
            <div class="formRowLabel">
                <label for="password">
                    <span class="labelText"><i class="fa fa-lock"></i> Password: </span>		
                </label>
            </div>
            <div class="formRowInput">
                <input class="inputBox" type="password" name="password" id="password" value="" title="Enter your Password" placeholder="password" required="required" pattern="(?=^.{6,60}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s).*$"/>
            </div>	
        </div>
        
        <div class="formRow">
            <p align="center"><button class="btn"><i class="fa fa-sign-out"></i> Submit</button></p>
        </div>
    </form>
					
    <?php
	//}	
	pageFooter();
?>