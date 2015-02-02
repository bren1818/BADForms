<?php
	/* Functions - depends on privateKeys */
	
	function logMessage($message, $logFile = "logs.txt", $script = __FILE__, $line = __LINE__){
		$logFile = LOG_DIR.DIRECTORY_SEPARATOR.$logFile;
		$time = date(TIMESTAMP_FORMAT_LOG, time() );
		$preface = PHP_EOL.$time." -- Script: ".basename($script)." -- Line: ".$line." -- ";
		file_put_contents($logFile, $preface.$message, FILE_APPEND);
	}

	function isPostback(){
		if ( (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') ){
			return true;
		}else{
			return false;
		}
	}
	
	function pa( $arr ){
		echo '<pre>'.print_r($arr,true).'</pre>';
	}
?>