<?php
	
	define("ROOT_DIR", 		realpath(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
	define("LOG_DIR", 		ROOT_DIR."logs");
	define("TEMP_DIR", 		ROOT_DIR."temp");
	define("CACHE_DIR", 	ROOT_DIR."cache");
	define("CLASSES_DIR", 	ROOT_DIR."classes");
	define("INCLUDES_DIR",	ROOT_DIR."includes");
	define("CSS_DIR",		'/'."css");
	define("JS_DIR",		'/'."js");
	
	define("DATABASE_MODE", 1 );
	
	/*Local Database : Mode 1*/
	define("LOCAL_DATABASE_USER", 	"root");
	define("LOCAL_DATABASE_PASS", 	"");
	define("LOCAL_DATABASE", 		"badforms");
	define("LOCAL_HOST", 			"localhost");
	
	/*Staging Database : Mode 2*/
	define("STAGING_DATABASE_USER",	"");
	define("STAGING_DATABASE_PASS",	"");
	define("STAGING_DATABASE", 		"");
	define("STAGING_HOST", 			"");
	
	/*Production Database : Mode 3*/
	define("PRODUCTION_DATABASE_USER",	"");
	define("PRODUCTION_DATABASE_PASS",	"");
	define("PRODUCTION_DATABASE", 		"");
	define("PRODUCTION_HOST", 			"");
	
	define("TIMESTAMP_FORMAT_LOG", "Y-m-d H:i:s A");
	
	define("CREATE_GITIGNORE", true);	//create gitIgnore Files in Directory (Cache, Log, Temp)
	
	if( DATABASE_MODE == 1 ){
		define("DATABASE_NAME", LOCAL_DATABASE);
	}else if( DATABASE_MODE == 2 ){
		define("DATABASE_NAME", STAGING_DATABASE);
	}else if( DATABASE_MODE == 3){
		define("DATABASE_NAME", PRODUCTION_DATABASE);
	}else{
		define("DATABASE_NAME", "");
	}
	
	
	/*System Checks*/
	if( !file_exists( LOG_DIR) ){
		mkdir( LOG_DIR );
	}
		
	if(!file_exists(LOG_DIR.DIRECTORY_SEPARATOR.".gitignore") && CREATE_GITIGNORE){	
		file_put_contents(LOG_DIR.DIRECTORY_SEPARATOR.".gitignore", "*");
	}
	
	if( !file_exists( TEMP_DIR) ){
		mkdir( TEMP_DIR );
	}
	
	if(!file_exists(TEMP_DIR.DIRECTORY_SEPARATOR.".gitignore") && CREATE_GITIGNORE){	
		file_put_contents(TEMP_DIR.DIRECTORY_SEPARATOR.".gitignore", "*");
	}

	if( !file_exists( CACHE_DIR) ){
		mkdir( CACHE_DIR );
	}
	
	if(!file_exists(CACHE_DIR.DIRECTORY_SEPARATOR.".gitignore") && CREATE_GITIGNORE){	
		file_put_contents(CACHE_DIR.DIRECTORY_SEPARATOR.".gitignore", "*");
	}
	
	/*End System Checks*/
?>