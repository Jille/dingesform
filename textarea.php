<?php

	class DingesTextarea extends DingesInputField {

		protected $maxLength;
		protected $cols = 60;
		protected $rows = 4;

		protected $element = 'textarea';
		
		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
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

		function fillAttributes() {
			parent::fillAttributes();
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
			$this->setAttribute('cols', $this->cols);
			$this->setAttribute('rows', $this->rows);
		}

		function generateHTML() {
			$content = '';
			if($this->getValue()) {
				$content = $this->getValue();
			}
			return DingesForm::generateTag($this->element, $this->attributes, $content);
		}
	}

?>
