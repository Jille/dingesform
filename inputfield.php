<?php
	abstract class DingesInputField extends DingesField {
		protected $required;

		function __construct($name, $required, $label) {
			parent::__construct($name, $label);
			$this->required = $required;
		}

		function validate($value) {
			if($this->required && !$value) {
				return 'ERR_EMPTY';
			}
			return true;
		}

		/* Simple getters and setters */
		function getRequired() {
			return $this->required;
		}

		function setRequired($value) {
			$this->required = $value;
		}
	}
?>