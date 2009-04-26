<?php
	class DingesForm {
		protected $fields = array();
		protected $strings = array();

		protected $fieldIdPrefix = '';

		protected $isSubmitted;

		protected $validationErrors;

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
					$field->_setValue($_POST[$field->name]);
				}
			}
		}

		function validate() {
			foreach($this->fields as $field) {
				if(($error = $field->validate($field->value)) !== true) {
					$field->_setValid(false);
					$this->validationErrors[] = array('field' => $field, 'message' => $error);
				} else {
					$field->_setValid(true);
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
			if(!is_array($this->validationErrors)) {
				$this->validate();
			}
			$this->strings['form_open'] = '<form method="POST" action=".">';
			$this->strings['form_close'] = '</form>';

			foreach($this->fields as $field) {
				$this->strings['element_'. $field->name] = $field->render();
				$this->strings['label_'. $field->name] = $field->getLabelTag();
				$this->strings['id_'. $field->name] = $this->fieldIdPrefix . $field->id;
			}
		}

		function getStrings() {
			return $this->strings;
		}

		static function generateTag($element, $attributes = array(), $content = NULL) {
			$out = '<'. $element;
			foreach($attributes as $name => $value) {
				$out .= ' '. $name .'="'. htmlspecialchars($value) .'"';
			}
			if($content !== NULL) {
				$out .= '>'. $content .'</'. $element .'>';
			} else {
				$out .= ' />';
			}
			return $out;
		}

		function __get($key) {
			$func = 'get'. $key;
			return $this->$func();
		}

		/* Simple getters and setters */
		function getFieldIdPrefix() {
			return $this->fieldIdPrefix;
		}

		function setFieldIdPrefix($value) {
			$this->fieldIdPrefix = $value;
		}
	}

	class DingesException extends Exception {
	}
?>
