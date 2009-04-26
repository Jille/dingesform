<?php

	class DingesSelect extends DingesInputField {

		protected $element = 'select';
		public $options = array();

		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
		}

		function parseInput($value) {
			return !is_null($value);
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'checkbox');
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
		}

		function generateHTML() {
			$options = '';
			foreach($this->options as $option) {
				$options .= DingesForm::generateTag('option', array('value' => $option), $option);
			}
			return DingesForm::generateTag($this->element, $this->attributes, $options);
		}
	}

?>
