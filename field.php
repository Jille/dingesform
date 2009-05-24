<?php
	abstract class DingesField {
		protected $form;

		protected $name;
		protected $id;

		protected $value = NULL;

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
				if(!preg_match($regex['regex'], $value)) {
					return $regex['errorCode'];
				}
			}
			foreach($this->validationCallbacks as $callback) {
				if(($error = call_user_func_array($callback, array($value, $this))) !== true) {
					return $error;
				}
			}
			return true;
		}

		function fillAttributes() {
			$this->setAttribute('id', $this->getFullId());
			$this->setAttribute('name', $this->name);
			if($this->isValid() === false) {
				$this->setAttribute('class', 'dingesError');
			}
		}

		function generateHTML() {
			$tag = DingesForm::generateTag($this->element, $this->attributes);
			$comment = '<!-- ';
			if(isset($this->restrictions)) {
				foreach($this->restrictions as $k => $v) {
					$comment .= $k .'='. $v .' ';
				}
			}
			$comment .= '-->';
			return $tag . $comment;
		}

		function render() {
			$this->fillAttributes();
			$this->fillFormInitCode();
			if(isset($this->restrictions)) {
				$this->fillRestrictions();
			}
			$strings = array(
				'element_'. $this->name => $this->generateHTML(),
				'id_'. $this->name => $this->getFullId(),
			);
			return $strings;
		}

		function fillFormInitCode() {
			$this->form->strings['form_init_code'] .= "\ndf.fields['". $this->getAttribute('id') ."'] = new DingesFormField(document.getElementById('". $this->getAttribute('id') ."'));";
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

		function setRestriction($name, $value, $append = false) {
			if($append && isset($this->restrictions[$name])) {
				$this->restrictions[$name] .= $value;
			} else {
				$this->restrictions[$name] = $value;
			}
		}

		function deleteRestriction($name) {
			unset($this->restrictions[$name]);
		}

		function getRestriction($name) {
			return $this->restrictions[$name];
		}

		function getEffectiveValue() {
			if($this->form->isPosted() && $this->keepValue) {
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
			$this->validationRegexes[] = array('regex' => $regex, 'errorCode' => $errorCode);
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

		function getFullId() {
			return $this->form->getFieldIdPrefix() . $this->getId();
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

		function getKeepValue() {
			return $this->keepValue;
		}

		function setKeepValue($value) {
			$this->keepValue = $value;
		}
	}
?>
