<?php
	class DingesForm {
		protected $fields = array();
		protected $strings = array();

		protected $fieldIdPrefix = '';

		protected $posted;

		protected $validationErrors;
		protected $validated = false;

		protected $autoFocus = false;

		function __construct() {
			$this->posted = (count($_POST) > 0);
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

			if($this->posted) {
				if(isset($_POST[$field->getName()])) {
					$field->_setValue($_POST[$field->getName()]);
				}
			}
		}

		private function validate() {
			assert('$this->posted');
			assert('!$this->validated');
			foreach($this->fields as $field) {
				if(($error = $field->validate($field->getValue())) !== true) {
					$field->_setValid(false);
					$this->validationErrors[] = array('field' => $field, 'message' => $error);
				} else {
					$field->_setValid(true);
				}
			}
			$this->validated = true;
		}

		function isSubmitted() {
			if($this->posted) {
				return $this->isValid();
			}
			return false;
		}

		function isPosted() {
			return $this->posted;
		}

		function isValid() {
			if(!$this->validated) {
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
			if(!$this->validated) {
				$this->validate();
			}
			$errors = array();
			foreach($this->validationErrors as $error) {
				$errors[] = $error['message'];
			}
			return $errors;
		}

		function render() {
			if($this->posted && !$this->validated) {
				$this->validate();
			}
			$this->strings['form_open'] = '<form method="POST" action=".">';
			$this->strings['form_close'] = '</form>';

			$focusFirst = $this->autoFocus;

			if($focusFirst && $this->posted && count($this->validationErrors) > 0) {
				$this->validationErrors[0]['field']->setAttribute("focus", "true");
				$focusFirst = false;
			}

			foreach($this->fields as $field) {
				if($focusFirst) {
					$field->setAttribute("focus", "true");
					$focusFirst = false;
				}
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

		function getFields() {
			return $this->fields;
		}

		function getField($name) {
			if(!isset($this->fields[$name])) {
				throw new DingesException('There is no a field with the name: '. $name);
			}
			return $this->fields[$name];
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

		/* Simple getters and setters */
		function getFieldIdPrefix() {
			return $this->fieldIdPrefix;
		}

		function setFieldIdPrefix($value) {
			$this->fieldIdPrefix = $value;
		}

		function getAutoFocus() {
			return $this->autoFocus;
		}

		function setAutoFocus($value) {
			$this->autoFocus = $value;
		}
	}

	class DingesException extends Exception {
	}
?>
