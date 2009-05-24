<?php
	class DingesForm {
		protected $fields = array();
		// XXX moet protected worden!
		public $strings = array();

		protected $fieldIdPrefix = '';

		protected $posted;

		protected $attributes = array();

		protected $validationErrors;
		protected $validated = false;

		protected $autoFocus = false;

		protected $preValidationHooks = array();
		protected $validationCallbacks = array();

		protected $errorMessages = array();

		function __construct() {
			$this->posted = (count($_POST) > 0);
			$this->setAttribute('id', 'dingesForm'); // XXX niet multiform compatible
			$this->setAttribute('method', 'POST');
			$this->setAttribute('action', '.');
			$this->setDefaultErrorMessages();
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
				if($field instanceof DingesFile) {
					if(isset($_FILES[$field->getName()])) {
						$field->_setValue($_FILES[$field->getName()]);
					}
				} else {
					if(isset($_POST[$field->getName()])) {
						$field->_setValue($_POST[$field->getName()]);
					}
				}
			}
		}

		private function validate() {
			assert('$this->posted');
			assert('!$this->validated');

			foreach($this->preValidationHooks as $callback) {
				call_user_func_array($callback, array($this));
			}

			foreach($this->fields as $field) {
				if(($error = $field->validate($field->getValue())) !== true) {
					$field->_setValid(false, $error);
					$this->validationErrors[] = array('field' => $field, 'message' => $error);
				} else {
					$field->_setValid(true);
				}
			}

			foreach($this->validationCallbacks as $callback) {
				if(($error = call_user_func_array($callback, array($this))) !== true) {
					$this->validationErrors[] = array('message' => $error);
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
			return $this->errorMessages[$this->validationErrors[0]['message']];
		}

		function getValidationErrors() {
			if(!$this->validated) {
				$this->validate();
			}
			$errors = array();
			foreach($this->validationErrors as $error) {
				$errors[] = $this->errorMessages[$error['message']];
			}
			return $errors;
		}

		function setAttribute($name, $value, $append = false) {
			if($append && isset($this->attributes[$name])) {
				$this->attributes[$name] .= $value;
			} else {
				$this->attributes[$name] = $value;
			}
		}

		function deleteAttribute($name) {
			unset($this->attributes[$name]);
		}

		function getAttribute($name) {
			return $this->attributes[$name];
		}

		function render() {
			if($this->posted && !$this->validated) {
				$this->validate();
			}
			$this->strings['form_open'] = '<form';
			foreach($this->attributes as $name => $value) {
				$this->strings['form_open'] .= ' '. $name .'="'. htmlspecialchars($value) .'"';
			}
			$this->strings['form_open'] .= '>';
			$this->strings['form_close'] = '</form>';
			$this->strings['form_init_code'] = "var df = new DingesForm(document.getElementById('dingesForm'));";

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
				$renderedStrings = $field->render();
				$this->strings = array_merge($this->strings, $renderedStrings);
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

		function addValidationCallback($callback) {
			if(!is_callable($callback)) {
				throw new DingesException("Invalid callback given to addValidationCallback");
			}
			$this->validationCallbacks[] = $callback;
		}

		function clearValidationCallbacks() {
			$this->validationCallbacks = array();
		}

		function addPreValidationHook($callback) {
			if(!is_callable($callback)) {
				throw new DingesException("Invalid callback given to preValidationHook");
			}
			$this->preValidationHooks[] = $callback;
		}

		function clearPreValidationHooks() {
			$this->preValidationHooks = array();
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

		function setDefaultErrorMessages() {
			$this->errorMessages['ERR_INVALID'] = 'De waarde van dit veld is niet correct';
			$this->errorMessages['ERR_EMPTY'] = 'Dit veld is verplicht';
			$this->errorMessages['ERR_NON_INTEGER'] = 'De waarde in dit veld is niet numeriek';
			$this->errorMessages['ERR_UNDER_MIN'] = 'De ingevulde waarde is te laag';
			$this->errorMessages['ERR_OVER_MAX'] = 'De ingevulde waarde is te hoog';
			$this->errorMessages['ERR_OVER_MAXLENGTH'] = 'De ingevulde waarde is te lang';
			$this->errorMessages['ERR_UNKNOWN_OPTION'] = 'De gekozen optie bestaat niet';
			$this->errorMessages['ERR_FILE_TECHNICAL'] = 'Er is iets misgegaan bij het oversturen van het bestand';
			$this->errorMessages['ERR_FILE_TOO_BIG'] = 'Het overgestuurde bestand is te groot';
			$this->errorMessages['ERR_FILE_TOO_SMALL'] = 'Het overgestuurde bestand is te klein';
			$this->errorMessages['ERR_UNSAFE'] = 'Uw wachtwoord mag niet geblijk zijn aan uw gebruikersnaam';
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
