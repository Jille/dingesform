<?php
	class DingesForm {
		protected $fields = array();
		protected $strings = array();

		protected $fieldIdPrefix = '';

		function __construct() {
		}

		function createInputField($type, $name, $required, $label) {
			$class = 'Dinges'. $type;
			if(!is_subclass_of($class, 'DingesInputField')) {
				throw new DingesException($type .' is not an subclass of DingesInputField');
			}
			$field = new $class($name, $required, $label);
			$this->addField($field);
		}

		function addField($field) {
			if(!is_object($field) || !$field instanceof DingesField) {
				throw new DingesException('Invalid field given to addField()');
			}
			if(isset($this->fields[$field->name])) {
				throw new DingesException('There is already a field with the name: '. $field->name);
			}
			$this->fields[$field->name] = $field;
			$field->_setForm($this);
		}

		function parseSubmittedData() {
			foreach($this->fields as $field) {
				if(isset($_POST[$field->name])) {
					$field->parseInput($_POST[$field->name]);
				} else {
					$field->parseInput(NULL);
				}
			}
		}

		function render() {
			$this->strings['form_start'] = '<form method="POST" action=".">';
			$this->strings['form_end'] = '</form>';

			foreach($this->fields as $field) {
				$this->strings['element_'. $field->name] = $field->render();
				$this->strings['label_'. $field->name] = $field->label;
				$this->strings['id_'. $field->name] = $this->fieldIdPrefix . $field->id;
			}
		}

		function getStrings() {
			return $this->strings;
		}
	}

	class DingesException extends Exception {
	}
?>
