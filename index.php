<?php
	require_once( "includes/include.php" );
	pageHeader("Building Block Forms");	
?>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
	<h1><i class="fa fa-puzzle-piece"></i> Building Block Forms</h1>
	
	<div class="clear"></div>
		<br />
		<style>
			a.pickList{
				display: none;
			}
		</style>
		<p>Welcome to Building Block Forms. You're looking at the home screen right now. Pretty simple isn't it? Well, thats the point. Lets keep this easy and user friendly.<p>
		<p>Below you'll find three tabs, &ldquo;Available Forms&rdquo;, &ldquo;Available Lists&rdquo; and &ldquo;Available Groups&rdquo;. These tabs will show the most recent items that are yours and or public.<p>
		
		<div id="tabs">
		  <ul>
			<li><a href="/views/form/listForms.php"><i class="fa fa-list-alt"></i> Available Forms</a></li>
			<li><a href="/views/list/listLists.php"><i class="fa fa-list"></i> Available Lists</a></li>
			<li><a href="/views/group/listGroups.php"><i class="fa fa-indent"></i> Available Form Groups</a></li>
			
			<!--<li><a href="/views/"><i class="fa fa-files-o"></i> File Manager</a></li>-->
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