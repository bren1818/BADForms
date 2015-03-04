<?php
	error_reporting( E_ALL );
	
	require_once( "includes/include.php" );
	
pageHeader("Bad Forms Dashboard");	
?>
<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
<h1>Brens Awesome Dynamic Forms</h1>

<a class="btn" href="/views/form/createForm.php"><i class="fa fa-list-alt"></i> Create New Form</a>
<a class="btn" href="/views/list/buildList.php"><i class="fa fa-sort-amount-desc"></i> Build Data List</a>
<a class="btn" href="/views/admin/logout.php"><i class="fa fa-power-off"></i> Log Out</a>

<br />

<div class="clear"></div>

<br />

<style>
a.pickList{
	display: none;
}
</style>

<div id="tabs">
  <ul>
    <li><a href="/views/form/listForms.php"><i class="fa fa-list-alt"></i> Available Forms</a></li>
    <li><a href="/views/list/listLists.php"><i class="fa fa-list"></i> Available Lists</a></li>
    <li><a href="/views/group/listGroups.php"><i class="fa fa-indent"></i> Available Form Groups</a></li>
    <!-- Re-useable Form Items -->
  </ul>
  <!--<div id="tabs-1">
    --Tabs--
  </div>-->
</div>

<script type="text/javascript">
	$(function(){
	 	$( "#tabs" ).tabs({
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html("Couldn't load this item..." );
				});
			}
		});
	});
</script>



<?php
pageFooter();
?>