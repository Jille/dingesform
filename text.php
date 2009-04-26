<?php

	class DingesText extends DingesInputField {

		protected $maxLength;
		
		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
		}

		function fillAttributes() {
			$this->setAttribute('type', 'text');
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
			if(isset($this->maxLength) && $this->maxLength > 0) {
				$this->setAttribute('maxlength', $this->maxLength);
			}
		}
	}

?>
