<?php
	class DingesCheckbox extends DingesInputField {
		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function parseInput($value) {
			return !is_null($value);
		}

		function fillAttributes() {
			parent::fillAttributes();

			$this->setAttribute('type', 'checkbox');
			if($this->getEffectiveValue()) {
				$this->setAttribute('checked', 'checked');
			}
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
		}
	}
?>
