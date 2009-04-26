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

		function fillAttributes() {
			parent::fillAttributes();
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
			if(isset($this->maxLength) && $this->maxLength > 0) {
				$this->setAttribute('maxlength', $this->maxLength);
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
