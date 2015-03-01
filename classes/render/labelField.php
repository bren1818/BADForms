<?php
class labelField{	
	private $formObject;
	
	/*Constructor*/
	function __construct($formObject=null){
		$this->formObject = $formObject;
	}
	
	function getJS(){
		return "";
	}
	
	function render(){
		?>
		<div class="formRowLabel">
			<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
				<span class="labelText"><?php echo $this->formObject->getGenericUseText(); ?></span>
			</label>
		</div>
		<?php
	}
}
?>