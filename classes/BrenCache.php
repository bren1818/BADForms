<?php
/*Returns Cached output or null*/
class bCache{

	private $cacheTime;
	private $cacheFileName;
	private $cacheFilePath;
	
	function hasExpired(){
		$file = $this->getCachePath().$this->getCacheFilename();
		$expired = 0;
		
		if(!file_exists($file)){ $expired = 1; }
		if(filemtime($file) < time() - $this->getCacheTime() * 3600){ $expired = 1;  }
		return $expired;
	}

	function setCache($content){
		$file = $this->getCachePath().$this->getCacheFilename();
		if(false !== ($f = @fopen($file, 'w'))) {
		  fwrite($f, $content);
		  fclose($f);
		}
	}

	function getCache(){
		$file = $this->getCachePath().$this->getCacheFilename();
		return  file_get_contents($file); //return cached file
	}
	
	function __construct(){
		$this->cacheFilePath = getcwd().DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR;
		$this->cacheTime = .5;
	}
	
	function setCachePath($cachePath){
		if (!file_exists($cachePath)) {
			mkdir($cachePath, 0777, true);
		}
		$this->cacheFilePath = $cachePath;
	}
	
	function getCachePath(){
		return $this->cacheFilePath;
	}

	function setCacheFilename($name){
		$this->cacheFileName = $name;
	}
	
	function getCacheFilename(){
		return $this->cacheFileName;
	}
	
	//hours
	function setCacheTime($time){
		$this->cacheTime = $time;
	}
	
	function getCacheTime(){
		return $this->cacheTime;
	}
	
}
?>