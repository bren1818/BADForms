<?php
	include "../../includes/include.php";
	$conn = getConnection();
	pageHeader();
	
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
	<h1>Form Submissions for: &ldquo;<?php echo $theForm->getTitle(); ?>&rdquo;</h1>
	<p>Number of Submissions: <b><?php echo $count; ?></b></p>
    
    <table>
<?php
	//need Form Rows to match title tags for entries grab from form and iterate through each corresponding result set	
	
	$query = "SELECT `fs`.`data`  FROM `formentry` as `fe` 
			INNER JOIN `formsavejson` as `fs` on `fs`.`entryID` = `fe`.`id`
			where `fe`.`formID` = :formID;";
			
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	if( $query->execute() ){
		$counter = 1;
		while( $row = $query->fetch() ){
			echo "<tr>";
				echo "<td>";
					echo "<br /><p><b>Form Entry</b>: ".$counter."</p>";
					//echo pa(json_decode($row["data"]),1);
					foreach( json_decode($row["data"]) as $key=>$value){
						$value = (array)$value;
						echo $value["name"]." : ".$value["value"]." <br />";
					}
				echo "</td>";
			echo "</tr>";
			$counter++;	
		}
	}
?>
</table>

<p><a class="btn" href="/">Home</a></p>
    
    
<?php	
	pageFooter();
?>