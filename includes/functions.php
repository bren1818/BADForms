<?php
	/* Functions - depends on privateKeys */
	
	function logMessage($message, $logFile = "logs.txt", $script = __FILE__, $line = __LINE__){
		$logFile = LOG_DIR.DIRECTORY_SEPARATOR.$logFile;
		$time = date(TIMESTAMP_FORMAT_LOG, time() );
		$preface = PHP_EOL.$time." -- Script: ".basename($script)." -- Line: ".$line." -- ";
		file_put_contents($logFile, $preface.$message, FILE_APPEND);
	}	
?>