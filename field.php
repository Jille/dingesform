<?php
	class DingesFormField {
		private $name;
		private $required;
		private $label;

		private $value = NULL;
		private $defaultValue = NULL;

		private $element = 'input';
		private $attributes = array();

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
			throw new DingesException('You can not change this property');
		}

		function setAttribute($name, $value, $append = false) {
			if($append && isset($this->attributes[$name])) {
				$this->attributes[$name] .= $value;
			} else {
				$this->attributes[$name] = $value;
			}
		}
	}
?>
