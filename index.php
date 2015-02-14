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
<style>
  .ui-tabs-vertical { width: 55em; }
  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
 </style>
  
<h1>Brens Awesome Dynamic Forms</h1>
<?php
	//echo DATABASE_USER;
?>
<a class="btn" href="/views/form/createForm.php"><i class="fa fa-list-alt"></i> Create New Form</a>
<!--<a class="btn" href="/views/form/buildForm.php"><i class="fa fa-list-ul"></i> Add Form Data</a>-->
<a class="btn" href="/views/list/buildList.php"><i class="fa fa-sort-amount-desc"></i> Build Data List</a>

<br />

<div class="clear"></div>

<br />

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Available Forms</a></li>
    <li><a href="#tabs-2">Available Lists</a></li>
  </ul>
  <div id="tabs-1">
    <h2>Content heading 1</h2>
    <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
  </div>
  <div id="tabs-2">
    <h2>Content heading 2</h2>
    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
  </div>
  
</div>

<script type="text/javascript">
	$(function(){
	 	$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    	$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		
		$('ui.ui-tabs-nav').height( $('#tabs').height() );
	});
</script>



<?php
pageFooter();
?>