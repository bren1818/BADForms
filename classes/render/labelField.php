<?php
class labelField{	
	private $formObject;
	
	/*Constructor*/
	function __construct($formObject=null){
		$this->formObject = $formObject;
	}
	
	function hasReturnValue(){
		return 0;
	}
	
	function getJS(){
		return "";
	}
	
	function render(){
		?>
		<div class="formRowLabel">
			<p class="labelField" id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
				<?php echo $this->formObject->getGenericUseText(); ?>
			</p>
		</div>
		<?php
	}
}
?>