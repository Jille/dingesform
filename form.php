<?php
	class DingesForm {
		protected $fields = array();
		protected $strings = array();

		protected $fieldIdPrefix = '';

		protected $isSubmitted;

		private $validationErrors;

		function __construct() {
			$this->isSubmitted = (count($_POST) > 0);
		}

		function createInputField($type, $name, $required, $label) {
			$class = 'Dinges'. $type;
			if(!is_subclass_of($class, 'DingesInputField')) {
				throw new DingesException($type .' is not an subclass of DingesInputField');
			}
			$field = new $class($name, $required, $label);
			$this->addField($field);
			return $field;
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

			if($this->isSubmitted) {
				if(isset($_POST[$field->name])) {
					$field->value = $field->parseInput($_POST[$field->name]);
				} else {
					$field->value = $field->parseInput(NULL);
				}
			}
		}

		function validate() {
			foreach($this->fields as $field) {
				if(($error = $field->validate($field->value)) !== true) {
					$this->validationErrors[] = array('field' => $field, 'message' => $eerror());
				}
			}
		}

		function isSubmitted() {
			return $this->isSubmitted;
		}

		function isValid() {
			if(!is_array($this->validationErrors)) {
				$this->validate();
			}
			return (count($this->validationErrors) == 0);
		}

		function getFirstValidationError() {
			if(!$this->validationErrors) {
				return false;
			}
			return $this->validationErrors[0]['message'];
		}

		function getValidationErrors() {
			if($this->validationErrors === NULL) {
				return false;
			}
			$errors = array();
			foreach($this->validationErrors as $error) {
				$errors[] = $error['message'];
			}
			return $errors;
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

		function __get($key) {
			if(in_array($key, array('fieldIdPrefix'))) {
				return $this->$key;
			}
			throw new DingesException('You cannot read this property');
		}

		static function generateTag($element, $attributes = array(), $content = NULL) {
			// XXX escaping
			$out = '<'. $element;
			foreach($attributes as $name => $value) {
				$out .= ' '. $name .'="'. $value .'"';
			}
			if($content !== NULL) {
				$out .= '>'. $content .'</'. $element .'>';
			} else {
				$out .= ' />';
			}
			return $out;
		}
	}

	class DingesException extends Exception {
	}
?>
