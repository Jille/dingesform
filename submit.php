<?php

	class DingesSubmit extends DingesField {

		function __construct($name, $label) {
			parent::__construct($name, $label);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
		}

		function fillAttributes() {
			$this->setAttribute('type', 'submit');
			$this->setAttribute('value', $this->label);
		}
	}

?>
