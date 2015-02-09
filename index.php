<?php
	error_reporting( E_ALL );
	
	require_once( "includes/include.php" );
	//require_once( "includes/db.php" );
	
	$db = getDB();
	pageHeader();
	if( dbExists($db, DATABASE_NAME) == 0 ){
		echo '<p>Database does not appear to exist, please run the <a href="/setup/index.php">setup wizard</a></p>';	
		exit;
	}
?>
<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
<h1>Brens Awesome Dynamic Forms</h1>
<?php
	//echo DATABASE_USER;
?>
<a class="btn" href="/views/form/createForm.php"><i class="fa fa-list-alt"></i> Create Form</a>
<a class="btn" href="/views/form/buildForm.php"><i class="fa fa-list-ul"></i> Add Form Data</a>
<a class="btn" href="/views/list/buildList.php"><i class="fa fa-sort-amount-desc"></i> Build List</a>

<?php
pageFooter();
?>