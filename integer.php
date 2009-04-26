<?php

	class DingesInteger extends DingesTExt {

		protected $min;
		protected $max;

		function __construct($name, $required, $label) {
			parent::__construct($name, $required, $label);
		}

		function parseInput($value) {
			try {
				parent::parseInput($value);
			} catch(DingesFieldValidationException $e) {
				throw($e);
			}
			if(!ctype_digit($value)) {
				throw new DingesFieldValidationException('FIELD_NON_INTEGER', $this, $this->label .' should be an integer');
			}
			if($this->min && $value > $this->min) {
				throw new DingesFieldValidationException('FIELD_OVER_MIN', $this, $this->label .' should be at least '. $this->min);
			}
			if($this->max && $value > $this->max) {
				throw new DingesFieldValidationException('FIELD_OVER_MAX', $this, $this->label .' should be at most '. $this->max);
			}
			return $value;
		}
	}

?>
