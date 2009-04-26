<?php
	abstract class DingesField {
		private $name;
		private $label;

		private $value = NULL;
		private $defaultValue = NULL;

		private $element = 'input';
		private $attributes = array();

		private $required;

		function __construct($name, $required, $label) {
			$this->name = $name;
			$this->required = $required;
			$this->label = $label;
		}

		function __get($key) {
			return $this->$key;
		}

		function __set($key, $value) {
			if(in_array($key, array('defaultValue'))) {
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
?>
