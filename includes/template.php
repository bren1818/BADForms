<?php
	function pageHeader($title="Building Block Forms", $useSession = true){
		global $sessionManager;
		global $currentUser;
		if( $useSession ){
			if( is_object($sessionManager) ){	
				$sessionManager->setMaxLength( SESSION_LENGTH );
				$sessionManager->load();
			
				if(  $sessionManager->getExpired() ){
					//echo "Expired Session";
					$curLocation = $_SERVER["REQUEST_URI"];
					
					if( strpos($curLocation, "setup/") > 0 ||
						strpos($curLocation, "views/admin/login.php") > 0 || 
						strpos($curLocation, "views/admin/logout.php") > 0  ){
						//don't require the session
					}else{
						header("Location: /views/admin/login.php");
					}
				}else{
									
					$sessionManager->renew();
					if( $sessionManager->getCurrentUserID() != "" ){
						$conn = getConnection();
						$currentUser->setConnection($conn);
						$currentUser = $currentUser->load( $sessionManager->getCurrentUserID() );
					}
					
				}
			}
		}	
		?>
		<html>
			<head>
				<title><?php echo $title; ?></title>
				<?php
					getCSSIncludes();
					getScriptIncludes();
				?>
				<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
			</head>
			<body>
		<?php
			adminToolbar();
		?>
        <div id="CMSPage">
        <?php
	}
	
	function adminToolbar(){
		global $sessionManager;
		global $currentUser;
		
		if( isset($sessionManager) && $sessionManager->getCurrentUser() != "" && !$sessionManager->getExpired() ){
		
			?>
            <div id="adminToolbar">
            	<div id="welcome">
                	Welcome: <i class="fa fa-user"></i> <b><?php echo $sessionManager->getCurrentUser(); ?></b>
                </div>
                <div id="tools">
                	<a class='btn' href='/'><i class="fa fa-home"></i> Home</a>
                	<?php
						if( $currentUser->getUserLevel() == 1 ){
					?>
						<a class='btn' href="/views/users/manage.php"><i class="fa fa-users"></i> Manage Users</a>
						<a class='btn' href=""><i class="fa fa-list-alt"></i> Manage Forms</a>
					<?php					
						}
					?>
					<a class='btn' href="/views/admin/logout.php"><i class="fa fa-power-off"></i> Log Out</a>
                </div>
            </div>
            <?php
		}
	}
	
	
	function getScriptIncludes(){
		
	?>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	
		<script src="<?php echo JS_DIR.'/scripts.js'; ?>"></script>
		<script src="<?php echo JS_DIR.'/jquery-ui-timepicker-addon.js'; ?>"></script>
	<?php
	}
	
	function getCodeMirrorIncludes(){
		$CMPATH = JS_DIR.'/codemirror-4.0';
		?>
		<link rel="stylesheet" href="<?php echo $CMPATH; ?>/lib/codemirror.css" />
		<link rel="stylesheet" href="<?php echo $CMPATH; ?>/addon/hint/show-hint.css" />
		<link rel="stylesheet" href="<?php echo $CMPATH; ?>/addon/display/fullscreen.css" />
		<script src="<?php echo $CMPATH; ?>/lib/codemirror.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/hint/show-hint.js"></script>
		<!--<script src="<?php echo $CMPATH; ?>/addon/hint/xml-hint.js"></script>-->
		<script src="<?php echo $CMPATH; ?>/addon/hint/html-hint.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/hint/css-hint.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/hint/javascript-hint.js"></script>
		
		
		
		<script src="<?php echo $CMPATH; ?>/mode/xml/xml.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/javascript/javascript.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/css/css.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/htmlmixed/htmlmixed.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/display/fullscreen.js"></script>
		<!--<script src="<?php echo $CMPATH; ?>/addon/search/search.js"></script>
		
		<script src="<?php echo $CMPATH; ?>/addon/fold/foldcode.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/fold/foldgutter.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/fold/comment-fold.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/fold/markdown-fold.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/fold/xml-fold.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/edit/matchtags.js"></script>-->
		
		<!--<script src="<?php echo $CMPATH; ?>/addon/search/match-highlighter.js"></script>-->
		<script src="<?php echo $CMPATH; ?>/addon/search/searchcursor.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/selection/active-line.js"></script>
		<!--<script src="<?php echo $CMPATH; ?>/addon/selection/mark-selection.js"></script>-->
		<?php
	}
	
	function getWYSIWYGIncludes(){
		$WPATH = JS_DIR.'/ckEditor';
		?>
        <link rel="stylesheet" href="<?php echo CSS_DIR; ?>/jquery.cleditor.css"/>
        <script type="text/javascript" src="<?php echo $WPATH; ?>/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo $WPATH; ?>/adapters/jquery.js"></script>
        <?php
	}
	
	function initWYSIWYG($selector='textarea'){
		?>
        <script>
			$(function(){
				CKEDITOR.disableAutoInline = true;

				//http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
				$( '<?php echo $selector; ?>' ).ckeditor({toolbar: [
					[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			
					'/',
					{ name: 'styles', items : [ 'Format','FontSize' ] },
					{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },	// '/' Line break - next group will be placed in new line.
					{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] } 
				]});
			});
		</script>
        <?php
	}
	
	
	function getCSSIncludes(){
	?>
		<!--<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" /> -->
		<!--code.jquery.com/ui/[version]/themes/[theme name]/jquery-ui.css-->
		<link rel="stylesheet" href="<?php echo CSS_DIR.'/font-awesome/font-awesome.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo CSS_DIR.'/jquery-ui-timepicker-addon.css'; ?>" />
		<link rel="stylesheet" href="<?php echo CSS_DIR.'/style.css'; ?>">
		<!--<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>">-->
		
		
	<?php	
	}
	
	
	
	
	
	function pageFooter(){
	?>
    	</div>
        <div id="footerBar">
        	<i class="fa fa-puzzle-piece"></i> Building Block Forms &copy; Brendon Irwin | 2014-2015
        </div>
		</body>
		</html>
	<?php
	}
?>