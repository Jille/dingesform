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

		function parseInput($value) {
			return $value;
		}

		function validate($value) {
			return true;
		}

		function fillAttributes() {
			$this->setAttribute('id', $this->f->fieldIdPrefix . $this->id);
			$this->setAttribute('name', $this->name);
		}

		function generateHTML() {
			return DingesForm::generateTag($this->element, $this->attributes);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
		}

		function setAttribute($name, $value, $append = false) {
			if($append && isset($this->attributes[$name])) {
				$this->attributes[$name] .= $value;
			} else {
				$this->attributes[$name] = $value;
			}
		}

		function getAttribute($name) {
			return $this->attributes[$name];
		}

		function getEffectiveValue() {
			if($this->f->isSubmitted()) {
				return $this->value;
			} else {
				return $this->defaultValue;
			}
		}

		function _setForm($f) {
			$this->f = $f;
		}

		function _setValue($value) {
			$this->value = $value;
		}

		function __get($key) {
			$func = 'get'. $key;
			return $this->$func();
		}

		/* Simple getters and setters */
		function getName() {
			return $this->name;
		}

		function getLabel() {
			return $this->label;
		}

		function setLabel($value) {
			$this->label = $value;
		}

		function getId() {
			return $this->id;
		}

		function setId($value) {
			$this->id = $value;
		}

		function getValue() {
			return $this->value;
		}

		function getDefaultValue() {
			return $this->defaultValue;
		}

		function setDefaultValue($value) {
			$this->defaultValue = $value;
		}
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
