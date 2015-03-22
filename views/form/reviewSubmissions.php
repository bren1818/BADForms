<?php
	include "../../includes/include.php";
	$conn = getConnection();
	pageHeader();
	
	getDataTablesInclude();
	
	$formID = 0;
	if( isset($_REQUEST) && isset($_REQUEST['formID']) && $_REQUEST['formID'] != "" ){
		$formID = $_REQUEST['formID'];
	}
	
	$query = "SELECT * FROM `theform` WHERE `id` = :formID";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	if( $query->execute() ){
		$theForm = $query->fetchObject("theform");
	}
	
	
	$count = 0;
	
	$query = "SELECT Count(`id`) as `count` FROM `formEntry` WHERE `formID` = :formID";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	if( $query->execute() ){
		$result = $query->fetch();
		$count = $result["count"];
	}
	
?>
<a class="btn" href="/views/form/buildForm.php?formID=<?php echo $formID; ?>"><i class="fa fa-code"></i> Build Form</a>
<a class="btn" href="/views/form/editForm.php?formID=<?php echo $formID; ?>"><i class="fa fa-pencil-square-o"></i> Edit Form Information</a>
<a class="btn" href="/renderForm.php?formID=<?php echo $formID; ?>"><i class="fa fa-desktop"></i> Preview Form</a>


	<h1>Form Submissions for: &ldquo;<?php echo $theForm->getTitle(); ?>&rdquo;</h1>
	<p>Number of Submissions: <b><?php echo $count; ?></b></p>
    
    <?php
		function buildTableHeader($formID){
			$conn = getConnection();
			$query = $conn->prepare("SELECT `label` FROM `formobject` WHERE `formID` = :formID order by `rowOrder`");
			$query->bindParam(':formID', $formID);
			if( $query->execute() ){
				
				echo '<table id="submissions" class="dataTable display" cellspacing="0" width="100%">';
				$formFields = "";
				while( $item = $query->fetch() ){
						$formFields.= '<th>'.$item["label"].'</th>';
				}
				
				echo '<thead>';
				echo '<tr>';
				echo $formFields;
				echo '</tr>';
				echo '</thead>';
				
				echo '<tfoot>';
				echo '<tr>';
				echo $formFields;
				echo '</tr>';
				echo '</tfoot>';
				
			}
		}
		
		function buildTableBody($formID){
			$conn = getConnection();
			echo '<tbody>';
			$ids = array();
			$query = $conn->prepare("SELECT `id` FROM `formobject` WHERE `formID` = :formID order by `rowOrder`");
			$query->bindParam(':formID', $formID);
			if( $query->execute() ){
				while( $item = $query->fetch() ){
						//$formFields.= '<th>'.$item["id"].'</th>';
						$ids[] = $item['id'];
				}
			}
			
			$query = $conn->prepare("SELECT `fs`.`data`, fe.`saveTime`  FROM `formentry` as `fe` 
			INNER JOIN `formsavejson` as `fs` on `fs`.`entryID` = `fe`.`id`
			where `fe`.`formID` = :formID order by `fe`.`saveTime` DESC LIMIT 5");
			$query->bindParam(':formID', $formID);
			
			if( $query->execute() ){
				while( $row = $query->fetch() ){
					echo '<tr>';
					
						foreach( json_decode($row["data"]) as $key=>$value){
						$value = (array)$value;
						if( $value["encrypted"] == 1 ){
							$val = $encryptor->decrypt( $value["value"] );
							//echo $value["name"]." : ".$val." (decrypted From: ".$value["value"].") <br />";
							echo '<td>'.$val.'</td>';
						}else{
							//echo $value["name"]." : ".$value["value"]." <br />";
							echo '<td>'.$value["value"].'</td>';
						}
					}
						
					echo '</tr>';	
				}
			}
			
			
			
			
			
			echo '</tbody>';
			echo '</table>';
		}
		
		buildTableHeader($formID);
		buildTableBody($formID);
	?>
    <script>
		$(function(){
			$('#submissions').DataTable();
		});
	</script>
    
    <!--
    
    <table>
<?php
	//need Form Rows to match title tags for entries grab from form and iterate through each corresponding result set	
	//pa( $theForm );
	$encryptionMode = $theForm->getEncryptionMode();
	
	$dencryptionKey = "";
	$encryptor = "";
	
	if( $encryptionMode < 2 ){
		//have to check for decryption	
		$salty = $theForm->getEncryptionSalt();
		$encryptionKey = BASE_ENCRYPTION_SALT;
		
		$encryptor = new BrenCrypt();
		$encryptor->setKey( $encryptionKey.$salty );
		
		//echo $salty;
	}
	
	echo '<p>Last 5 submissions</p>';
	
	
	$query = "SELECT `fs`.`data`, fe.`saveTime`  FROM `formentry` as `fe` 
			INNER JOIN `formsavejson` as `fs` on `fs`.`entryID` = `fe`.`id`
			where `fe`.`formID` = :formID order by `fe`.`saveTime` DESC LIMIT 5";
			
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	if( $query->execute() ){
		$counter = 1;
		while( $row = $query->fetch() ){
			echo "<tr>";
				echo "<td>";
					echo "<br /><p><b>Form Entry</b> on ".$row["saveTime"]."</p>";
					//echo pa(json_decode($row["data"]),1);
					foreach( json_decode($row["data"]) as $key=>$value){
						$value = (array)$value;
						if( $value["encrypted"] == 1 ){
							$val = $encryptor->decrypt( $value["value"] );
							echo $value["name"]." : ".$val." (decrypted From: ".$value["value"].") <br />";
						}else{
							echo $value["name"]." : ".$value["value"]." <br />";
						}
					}
				echo "</td>";
			echo "</tr>";
			$counter++;	
		}
	}
?>
</table>
-->
<p>
<a target="_blank" class="btn" href="/views/form/downloadSubmissions.php?formID=<?php echo $formID; ?>&fileType=TXT">Download as Text</a>
<a target="_blank" class="btn" href="/views/form/downloadSubmissions.php?formID=<?php echo $formID; ?>&fileType=XML">Download as XML</a>
<a target="_blank" class="btn" href="/views/form/downloadSubmissions.php?formID=<?php echo $formID; ?>&fileType=CSV">Download as CSV</a>
<a  target="_blank" class="btn" href="/views/form/downloadSubmissions.php?formID=<?php echo $formID; ?>&fileType=JSON">Download as JSON</a>
</p>
<br />
<p><a class="btn" href="/">Home</a></p>
    
    
<?php	
	pageFooter();
?>