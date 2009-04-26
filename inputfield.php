<?php

	abstract class DingesInputField extends DingesField {
		protected $required;

		function __construct($name, $required, $label) {
			parent::__construct($name, $label);
			$this->required = $required;
		}

		function parseInput($value) {
			if($this->required && !$value) {
				throw new DingesInputFieldEmptyException($this);
			}
			$this->value = $value;
		}
	}

	class DingesInputFieldEmptyException extends DingesFieldValidationException {
		function __construct($field) {
			parent::__construct($field, $field->name.' is required');
		}
	}
?>
