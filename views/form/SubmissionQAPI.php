<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	if( isPostBack() ){
		if( isset($_POST['formID']) && isset($_POST['fields']) ){
			
			$formID = $_POST['formID'];
			$fields = explode(",",$_POST['fields']);
			
			//echo 'Form id: '.$formID.' <pre>'.print_r($fields,true).'</pre>';
			
			$formKeys = array();
			
			$query = $conn->prepare("SELECT `fo`.`label`, `fo`.`encrypted`, `fo`.`id`, `ot`.`name`
										FROM `formobject` as `fo`
										INNER JOIN `objecttype` as `ot` ON
										`ot`.`id` = `fo`.`type`
										WHERE
										`fo`.`formID` = :formID
										ORDER BY
										`fo`.`rowOrder` ASC");
					$query->bindParam(':formID', $formID);				
				if( $query->execute() ){
					while( $row = $query->fetch(PDO::FETCH_ASSOC) ){
						if( in_array($row["id"],$fields) ){
							$formKeys[] = array("id" => $row["id"], "encrypted"=>$row["encrypted"],"label"=>$row["label"], "type" => $row["name"]);
						}
						
						
						
						
						
						
						
						
						
						
						
						
					}
					
					
						
					
					
					
					
					
					
					
				}
			
				//echo '<pre>'.print_r($formKeys,true).'</pre>';
			
				$count = sizeof( $formKeys );
			
				//echo "#keys: ".$count;
				
				if( $count > 0 ){
				
				
				/*
				
SELECT 

f1.`rowID`, f1.`formValue` as `v1`, f1.`encrypted` as `e1`,
f2.`formValue` as `v2`, f2.`encrypted` as `e2`
 
FROM `formentryvalue` f1
right join `formentryvalue` f2 on f2.`rowID` = f1.`rowID`

WHERE  f1.`formID` = 1
AND
f2.`formKey` = 2

group by f1.`rowID`

order by f1.`rowID` 



*/
				
				
				
				
				
				
				$superQuery = "SELECT ";
				
				//$counter = 0;
				
				/*
					SELECT 	
					f1.`rowID`, f1.`formValue` as `v1`, f1.`encrypted` as `e1`,
					f2.`formValue` as `v2`, f2.`encrypted` as `e2`
				*/	
				
				for( $c = 0; $c < $count; $c++){
					
					if( $c == 0){
						$superQuery.= " f".$formKeys[$c]["id"].".`rowID`, f".$formKeys[$c]["id"].".`formValue` as `v".$formKeys[$c]["id"]."`".(($count > 1) ? "," : "");		
					}else{
						$superQuery.= " f".$formKeys[$c]["id"].".`formValue` as `v".$formKeys[$c]["id"]."`".( ( ($c +1) < $count )? "," : "");
					}
				}
				
				/* FROM `formentryvalue` f1 */
				$superQuery.= " FROM `formentryvalue` f".$formKeys[0]["id"]." ";
				
				if( $count > 1 ){
					
				/* right join `formentryvalue` f2 on f2.`rowID` = f1.`rowID` */
				for( $c = 1; $c < $count; $c++){
					$superQuery.=  " inner join `formentryvalue` f".$formKeys[$c]["id"]." on f".$formKeys[$c]["id"].".`rowID` = f".$formKeys[0]["id"].".`rowID` "; // AND  f".$formKeys[$c]["id"].".`formKey` = ".$formKeys[$c]["id"]." " ;
					
					//$superQuery.= ( ( ($c +1) < $count )? "," : "");
				}
				
				}
				
				/*WHERE  f1.`formID` = 1*/
				
				$superQuery.= " WHERE  f".$formKeys[0]["id"].".`formID` = :formID ";
				
				
				
				if( $count > 1 ){
					/*
						AND
					*/
					$superQuery.= " AND ";
					
					/*
					
					*/
					
					
					for( $c = 1; $c < $count; $c++){
						
						$superQuery.=  " f".$formKeys[$c]["id"].".`formKey` = ".$formKeys[$c]["id"]." ";
						$superQuery.= ( ( ($c +1) < $count )? " AND " : "");
						
					}
					
				}
				
				/*
					group by f1.`rowID`
					order by f1.`rowID`  ASC
				
				*/
				$superQuery.= " group by f".$formKeys[0]["id"].".`rowID` order by f".$formKeys[0]["id"].".`rowID`  ASC";
				
				echo '<p><br />'.$superQuery.'<br /></p>';
				
				$query = $conn->prepare($superQuery);
				$query->bindParam(':formID', $formID);	
				
				
				echo '<table id="submissions" class="dataTable display" cellspacing="0" width="100%">';
						$formFields = "";
						for($x =0; $x < sizeof($formKeys); $x++){
								$formFields.= '<th>'.$formKeys[$x]["label"].'</th>';
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
				
				
				
				
				
				if( $query->execute() ){
					while( $row = $query->fetch() ){
						//echo '<pre>'.print_r($row,true).'</pre>';
						echo '<tr>';
							
							for($x =0; $x < sizeof($formKeys); $x++){
								echo '<td>'.$row["v".$formKeys[$x]["id"]].'</td>';	
							}
							
							
						echo '</tr>';
					}
					
				}
				
				
				
				
				echo '</table>';
				
				?>
                <script>
					$(function(){
						$('#submissions').DataTable();
						//async
					});
				</script>
				<?php
				}
				
			
			
			
		}
		exit;
	}
	
	pageHeader();
	
	
	
	$formID = 0;
	if( isset($_REQUEST) && isset($_REQUEST['formID']) && $_REQUEST['formID'] != "" ){
		$formID = $_REQUEST['formID'];
	}
	
	getDataTablesInclude($formID);
	
	$query = "SELECT * FROM `theform` WHERE `id` = :formID";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	if( $query->execute() ){
		$theForm = $query->fetchObject("theform");
	}
	?>
    <form id="QBuilder" method="post">
    	<fieldset>
    		<legend>Form Components to Query:</legend>
            <?php
				$query = $conn->prepare("SELECT `fo`.`label`, `fo`.`encrypted`, `fo`.`id`, `ot`.`description`
										FROM `formobject` as `fo`
										INNER JOIN `objecttype` as `ot` ON
										`ot`.`id` = `fo`.`type`
										WHERE
										`fo`.`formID` = 1
										ORDER BY
										`fo`.`rowOrder` ASC");
				if( $query->execute() ){
					while( $row = $query->fetch(PDO::FETCH_ASSOC) ){
						echo '<label><input class="QOptions" type="checkbox" name="columns" value="'.$row["id"].'" /> <b>'.( ($row["encrypted"] == 1) ? '<i style="color: #f00;" class="icon-key"></i> ' : '').$row["label"].'</b> ('.$row["description"].')</label><br />';
						
					}
				}
										
			?>
            <input type="hidden" name="formID" value="<?php echo $theForm->getId(); ?>" />
        </fieldset>
        <br /><br />
        <button id="fetch">Fetch Data</button>
        
    </form>
    
    <script type="text/javascript">
		$(function(){
			$('#fetch').click(function(event){
				event.preventDefault();
				var fields = "";
				var formID =$('#QBuilder input[name="formID"]').attr('value');
				$('#QBuilder input.QOptions').each(function(){
					if( $(this).prop('checked') == true ){
						fields += $(this).attr('value') + ",";
					}
				});
				fields = fields.substring(0, fields.length - 1);
				$('#loaded').html('loading...');
				$.post( "submissionQAPI.php", { formID: formID, fields: fields } ).done(function( data ) {
					$('#loaded').html( data );	
					
					
				});
				//
			});
		});
	</script>
    
    <div id="loaded">
    
    </div>
    
    <?php
	
	
	pageFooter();
?>