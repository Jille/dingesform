<?php

	abstract class DingesInputField extends DingesField {
		protected $required;

		function __construct($name, $required, $label) {
			parent::__construct($name, $label);
			$this->required = $required;
		}

		function parseInput($value) {
			if($this->required && !$value) {
				throw new DingesFieldValidationException($this, 'ERR_EMPTY');
			}
			$this->value = $value;
		}
	}

?>
