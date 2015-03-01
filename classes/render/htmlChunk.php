<?php
class htmlChunk{	
	private $formObject;
	
	/*Constructor*/
	function __construct($formObject=null){
		$this->formObject = $formObject;
	}
	
	function getJS(){
		return "";
	}
	
	function render(){
		echo $this->formObject->getGenericUseText(); 
	}
}
?>