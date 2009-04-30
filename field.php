<?php
	abstract class DingesField {
		protected $f;

		protected $name;
		protected $label;
		protected $id;

		protected $value = NULL;
		protected $defaultValue = NULL;

		protected $element = 'input';
		protected $attributes = array();

		protected $valid = NULL;

		protected $keepValue = true;

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
			if($this->isValid() === false) {
				$this->setAttribute('class', 'dingesError');
			}
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

		function deleteAttribute($name) {
			unset($this->attributes[$name]);
		}

		function getAttribute($name) {
			return $this->attributes[$name];
		}

		function getEffectiveValue() {
			if($this->f->isSubmitted() && $this->keepValue) {
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

		function getLabelTag() {
			$attributes = array();
			$attributes['for'] = $this->f->fieldIdPrefix . $this->id;
			$attributes['id'] = $this->f->fieldIdPrefix .'label_'. $this->id;
			if($this->isValid() === false) {
				$attributes['class'] = 'dingesErrorLabel';
			}
			return DingesForm::generateTag('label', $attributes, $this->label);
		}

		function _setValid($bool) {
			$this->valid = $bool;
		}

		function isValid() {
			return $this->valid;
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

		function getKeepValue() {
			return $this->keepValue;
		}

		function setKeepValue($value) {
			$this->keepValue = $value;
		}
	}

	interface DingesMultipleElement {
	}
?>
