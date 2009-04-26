<?php

	class DingesCheckbox extends DingesInputField {

		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'checkbox');
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
		}
	}

?>
