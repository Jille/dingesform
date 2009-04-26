<?php
	abstract class DingesField {
		private $f;

		protected $name;
		protected $label;
		protected $id;

		protected $value = NULL;
		protected $defaultValue = NULL;

		protected $element = 'input';
		protected $attributes = array();

		function __construct($name, $label) {
			$this->name = $name;
			$this->label = $label;

			$this->id = $name;
		}

		function _setForm($f) {
			$this->f = $f;
		}

		function __get($key) {
			return $this->$key;
		}

		function __set($key, $value) {
			if(in_array($key, array('defaultValue', 'value', 'id', 'min', 'max', 'maxLength'))) {
				$this->$key = $value;
				return;
			}
			throw new DingesException('You cannot change this property');
		}

		function setAttribute($name, $value, $append = false) {
			if($append && isset($this->attributes[$name])) {
				$this->attributes[$name] .= $value;
			} else {
				$this->attributes[$name] = $value;
			}
		}

		function getValue() {
			if($this->f->isSubmitted()) {
				return $this->value;
			} else {
				return $this->defaultValue;
			}
		}

		function parseInput($value) {
			return $value;
		}

		function validate($value) {
			return $value;
		}

		function fillAttributes() {
			$this->setAttribute('id', $this->f->fieldIdPrefix . $this->id);
			$this->setAttribute('name', $this->name);
		}

		function generateHTML() {
			return DingesForm::generateTag($this->element, $this->attributes);
		}

		abstract function render();
	}

	class DingesFieldValidationException extends Exception {
		protected $type;
		protected $field;

		function __construct($type, $field, $message) {
			parent::__construct($message);
			$this->type = $type;
			$this->field = $field;
		}

		function getField() {
			return $this->field;
		}

		function getType() {
			return $this->type;
		}
	}
?>
