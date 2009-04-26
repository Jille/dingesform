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

		function generateFieldsHTML() {
			// XXX deze hele functie mist escaping
			foreach($this->fields as $field) {
				$this->strings['element_'. $field->name] = '<'. $field->element;
				foreach($field->attributes as $attribute => $value) {
					$this->strings['element_'. $field->name] .= ' '. $attribute .'="'. $value .'"';
				}
				if($field->content) { // XXX iets met (default)value
					$this->strings['element_'. $field->name] .= '>'. $this->content .'</'. $field->element .'>';
				} else {
					$this->strings['element_'. $field->name] .= ' />';
				}

				$this->strings['label_'. $field->name] = '<label for="'. $field->id .'">'. $field->label .'</label>';
			}
		}
	}

	class DingesException {
	}
?>
