<?php

	abstract class DingesInputField extends DingesField {
		private $required;

		function __construct($name, $required, $label) {
			parent::__construct($name, $label);
			$this->required = $required;
		}
	}

?>
