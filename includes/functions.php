<?php
	/* Functions - depends on privateKeys */
	
	function logMessage($message, $logFile = "logs.txt", $script = __FILE__, $line = __LINE__){
		$logFile = LOG_DIR.DIRECTORY_SEPARATOR.$logFile;
		$time = date(TIMESTAMP_FORMAT_LOG, time() );
		$preface = PHP_EOL.$time." ".($script != "" ? " -- Script: ".basename($script) : "").($line != "" ? " -- Line: ".$line." -- " : "");
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
	
	function getCurrentDateTime(){
		return (string)date('Y-m-d H:i:s', time());
	}
	
	function getdatetime($dateString){
			return date('Y-m-d H:i:s', strtotime($dateString) );
	}
	
	function getinputdate($datetime){
		if( $datetime == "" || $datetime == "0000-00-00 00:00:00"){
			return "";
		}else{
			return date('m/d/Y H:i a',strtotime($datetime) );
		}
	}
	
	function getUniqueID(){
		return filter_var(microtime(true), FILTER_SANITIZE_NUMBER_INT);
	}
	
	function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
	function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}
?>