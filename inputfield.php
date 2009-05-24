<?php
	abstract class DingesInputField extends DingesLabelField {
		protected $required;
		protected $restrictions = array();

		function __construct($name, $required, $label) {
			parent::__construct($name, $label);
			$this->required = $required;
		}

		function validate($value) {
			if(($error = parent::validate($value)) !== true) {
				return $error;
			}
			if($this->required && !$value) {
				return 'ERR_EMPTY';
			}
			return true;
		}

		function fillLabelAttributes() {
			parent::fillLabelAttributes();
			if($this->required) {
				if($this->getLabelAttribute('class')) {
					$this->setLabelAttribute('class', ' dingesLabelRequired', true);
				} else {
					$this->setLabelAttribute('class', 'dingesLabelRequired');
				}
			}
		}

		function fillRestrictions() {
			if($this->required) {
				$this->setRestriction('required', 'true');
			}
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
