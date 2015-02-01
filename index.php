<?php
	error_reporting( E_ALL );
	
	require_once( "includes/include.php" );
	//require_once( "includes/db.php" );
	
	$db = getDB();
	if( dbExists($db, DATABASE_NAME) == 0 ){
		echo '<p>Database does not appear to exist, please run the <a href="/setup/index.php">setup wizard</a></p>';	
		exit;
	}
?>
<h1>Brens Awesome Dynamic Forms</h1>
<?php
	//echo DATABASE_USER;
?>
<a href="/views/form/createForm.php">Create Form</a>
<a href="/views/form/buildForm.php">Add Form Data</a>