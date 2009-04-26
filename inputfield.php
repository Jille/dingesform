<?php

	abstract class DingesInputField extends DingesField {
		protected $required;

		function __construct($name, $required, $label) {
			parent::__construct($name, $label);
			$this->required = $required;
		}
	}

?>
