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

		function addField(DingesField $field) {
			if(isset($this->fields[$field->getName()])) {
				throw new DingesException('There is already a field with the name: '. $field->getName());
			}
			$this->fields[$field->getName()] = $field;
			$field->_setForm($this);

			if($this->isSubmitted) {
				if(isset($_POST[$field->getName()])) {
					$field->_setValue($_POST[$field->getName()]);
				}
			}
		}

		function validate() {
			foreach($this->fields as $field) {
				if(($error = $field->validate($field->getValue())) !== true) {
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
			if($this->isSubmitted() && !is_array($this->validationErrors)) {
				$this->validate();
			}
			$this->strings['form_open'] = '<form method="POST" action=".">';
			$this->strings['form_close'] = '</form>';

			foreach($this->fields as $field) {
				if($field instanceof DingesLabelField) {
					$this->strings['label_'. $field->getName()] = $field->getLabelTag();
				}
				if($field instanceof DingesMultipleElement) {
					$this->strings = array_merge($this->strings, $field->render());
				} else {
					$this->strings['element_'. $field->getName()] = $field->render();
					$this->strings['id_'. $field->getName()] = $this->fieldIdPrefix . $field->getId();
				}
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
