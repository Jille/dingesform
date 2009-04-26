<?php

	class DingesText extends DingesInputField {

		protected $maxLength;
		
		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function parseInput($value) {
			try {
				parent::parseInput($value);
			} catch(DingesFieldValidationException $e) {
				throw($e);
			}
			if($this->maxLength && strlen($value) > $this->maxLength) {
				throw new DingesFieldValidationException('FIELD_OVER_MAXLENGTH', $this, $this->label .' should be at most '. $this->maxLength .' characters long');
			}
			return $value;
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'text');
			$this->setAttribute('value', $this->getValue());
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
			if(isset($this->maxLength) && $this->maxLength > 0) {
				$this->setAttribute('maxlength', $this->maxLength);
			}
		}
	}

?>
