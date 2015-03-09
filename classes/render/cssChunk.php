<?php
class cssChunk{	
	private $formObject;
	
	/*Constructor*/
	function __construct($formObject=null){
		$this->formObject = $formObject;
	}
	
	function getJS(){
		return "";
	}
	
	function hasReturnValue(){
		return 0;
	}
	
	function render(){
		echo '<style type="text/css">';
		echo $this->formObject->getGenericUseText();
		echo '</style>';
	}
}
?>