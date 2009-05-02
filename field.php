<?php
	abstract class DingesField {
		protected $form;

		protected $name;
		protected $id;

		protected $value = NULL;
		protected $defaultValue = NULL;

		protected $element = 'input';
		protected $attributes = array();

		protected $valid = NULL;

		protected $keepValue = true;

		protected $validationCallbacks = array();
		protected $validationRegexes = array();

		function __construct($name) {
			$this->name = $name;

			$this->id = $name;
		}

		function validate($value) {
			foreach($this->validationRegexes as $regex) {
				if(!preg_match($regex[0], $value)) {
					return $regex[1];
				}
			}
			foreach($this->validationCallbacks as $callback) {
				$error = call_user_func_array($callback, array($value, $this));
				if($error !== true) {
					return $error;
				}
			}
			return true;
		}

		function fillAttributes() {
			$this->setAttribute('id', $this->form->getFieldIdPrefix() . $this->id);
			$this->setAttribute('name', $this->name);
			if($this->isValid() === false) {
				$this->setAttribute('class', 'dingesError');
			}
		}

		function generateHTML() {
			return DingesForm::generateTag($this->element, $this->attributes);
		}

		function render() {
			$this->fillAttributes();
			return $this->generateHTML();
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

		function getEffectiveValue() {
			if($this->form->isSubmitted() && $this->keepValue) {
				return $this->value;
			} else {
				return $this->defaultValue;
			}
		}

		function _setForm($form) {
			$this->form = $form;
		}

		function _setValue($value) {
			$this->value = $value;
		}

		function _setValid($bool) {
			$this->valid = $bool;
		}

		function isValid() {
			return $this->valid;
		}

		function addValidationRegex($regex, $errorCode = 'ERR_INVALID') {
			$this->validationRegexes[] = array($regex, $errorCode);
		}

		function clearValidationRegexes() {
			$this->validationRegexes = array();
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

		/* Simple getters and setters */
		function getName() {
			return $this->name;
		}

		function getId() {
			return $this->id;
		}

		function setId($value) {
			$this->id = $value;
		}

		function getValue() {
			return $this->value;
		}

		function getDefaultValue() {
			return $this->defaultValue;
		}

		function setDefaultValue($value) {
			$this->defaultValue = $value;
		}

		function getKeepValue() {
			return $this->keepValue;
		}

		function setKeepValue($value) {
			$this->keepValue = $value;
		}
	}

	interface DingesMultipleElement {
	}
?>
