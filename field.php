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
			if(in_array($key, array('defaultValue', 'id'))) {
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

		function parseInput($value) {
			$this->value = $value;
		}

		function fillAttributes() {
			$this->setAttribute('id', $this->f->fieldIdPrefix . $this->id);
			$this->setAttribute('name', $this->name);
		}

		/**
		 * generateHTML - genereert een tag zonder inhoud
		 */
		function generateHTML() {
			$out = '<'. $this->element .' ';
			foreach($this->attributes as $name => $value) {
				$out .= $name .'="'. $value .'" ';
			}
			$out .= '/>';
			return $out;
		}

		abstract function render();
	}

	class DingesFieldValidationException extends Exception {
		protected $field;

		function __construct($field, $message) {
			parent::__construct($message);
			$this->field = $field;
		}

		function getField() {
			return $this->field;
		}
	}
?>
