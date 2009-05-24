<?php
	class DingesText extends DingesInputField {
		protected $maxLength;
		protected $minLength;
		
		function validate($value) {
			if(($error = parent::validate($value)) !== true) {
				return $error;
			}
			if($this->maxLength && strlen($value) > $this->maxLength) {
				return 'ERR_OVER_MAXLENGTH';
			}
			if($this->minLength && strlen($value) < $this->minLength) {
				return 'ERR_UNDER_MINLENGTH';
			}
			return true;
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'text');
			$this->setAttribute('value', $this->getEffectiveValue());
			if(isset($this->maxLength) && $this->maxLength > 0) {
				$this->setAttribute('maxlength', $this->maxLength);
			}
		}

		function fillRestrictions() {
			parent::fillRestrictions();
			if(isset($this->maxLength) && $this->maxLength > 0) {
				$this->setRestriction('maxLength', $this->maxLength);
			}
			if(isset($this->minLength) && $this->minLength > 0) {
				$this->setRestriction('minLength', $this->minLength);
			}
		}

		function setMaxLength($length) {
			if($length !== NULL) {
				$this->maxLength = intval($length);
			} else {
				$this->maxLength = NULL;
			}
		}

		function setMinLength($length) {
			if($length !== NULL) {
				$this->minLength = intval($length);
			} else {
				$this->minLength = 0;
			}
		}
	}
?>
