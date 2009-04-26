<?php
	class DingesForm {
		private $fields = array();
		private $strings = array();

		function __construct() {
		}

		function createField($type, $name, $required, $label) {
			$class = 'Dinges'. $type .'Field';
			if(!is_subclass_of($class, 'DingesFormField')) {
				throw new DingesException($type .' is not an subclass of DingesFormField');
			}
			$field = new $class($name, $required, $label);
			$this->addField($field);
		}

		function addField($field) {
			if(!is_object($field) || !$field instanceof DingesFormField) {
				throw new DingesException('Invalid field given to addField()');
			}
			if(isset($this->fields[$field->name])) {
				throw new DingesException('There is already a field with the name: '. $field->name);
			}
			$this->fields[$field->name] = $field;
		}

		function render() {
			foreach($this->fields as $field) {
				$this->strings['element_'. $field->name] = $field->render();
				$this->strings['label_'. $field->name] = $field->label;
			}
		}

		function getStrings() {
			return $this->strings;
		}
	}

	class DingesException extends Exception {
	}
?>
