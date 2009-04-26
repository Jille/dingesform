<?php
	class DingesForm {
		private $fields = array();
		private $strings = array();

		function __construct() {
		}

		function createField($type, $name, $required, $label) {
			$class = 'DingesFormField'. $type;
			$field = new $class($name, $required, $label);
			$this->addField($field);
		}

		function addField($field) {
			if(isset($this->fields[$field->name])) {
				throw new DingesException('There is already a field with the name: '. $field->name);
			}
			$this->fields[$field->name] = $field;
		}


		function getStrings() {
			return $this->strings;
		}
	}

	class DingesException {
	}
?>
