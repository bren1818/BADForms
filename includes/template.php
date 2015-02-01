<?php
	function pageHeader(){
		?>
		<html>
			<head>
				<title>B.A.D Forms</title>
				<?php
					getCSSIncludes();
					getScriptIncludes();
				?>
			</head>
			<body>
		<?php
	}
	
	function getScriptIncludes(){
		$CMPATH = JS_DIR.'/codemirror-4.0';
	?>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	
		<script src="<?php echo JS_DIR.'/scripts.js'; ?>"></script>
		<script src="<?php echo JS_DIR.'/builder.js'; ?>"></script>
		
		<script src="<?php echo $CMPATH; ?>/lib/codemirror.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/hint/show-hint.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/hint/xml-hint.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/hint/html-hint.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/xml/xml.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/javascript/javascript.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/css/css.js"></script>
		<script src="<?php echo $CMPATH; ?>/mode/htmlmixed/htmlmixed.js"></script>
		<script src="<?php echo $CMPATH; ?>/addon/display/fullscreen.js"></script>
	<?php
	}
	
	function getCSSIncludes(){
		$CMPATH = JS_DIR.'/codemirror-4.0';
	?>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $CMPATH; ?>/lib/codemirror.css">
		<link rel="stylesheet" href="<?php echo $CMPATH; ?>/addon/hint/show-hint.css">
		<link rel="stylesheet" href="<?php echo $CMPATH; ?>/addon/display/fullscreen.css">
		<link rel="stylesheet" href="<?php echo CSS_DIR.'/styles.css'; ?>">
		<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>">
		<style>
			
		</style>
	<?php	
	}
	
	
	
	
	
	function pageFooter(){
	?>
		</body>
		</html>
	<?php
	}
?>