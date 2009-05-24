<?php
	class DingesTextarea extends DingesInputField {
		protected $maxLength;
		protected $minLength;
		protected $cols = 60;
		protected $rows = 4;

		protected $element = 'textarea';
		
		function validate($value) {
			if(($error = parent::validate($value)) !== true) {
				return $error;
			}
			if($this->minLength && strlen($value) < $this->minLength) {
				return 'ERR_UNDER_MINLENGTH';
			}
			if($this->maxLength && strlen($value) > $this->maxLength) {
				return 'ERR_OVER_MAXLENGTH';
			}
			return true;
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('cols', $this->cols);
			$this->setAttribute('rows', $this->rows);
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

		function generateHTML() {
			if(!$content = $this->getEffectiveValue()) {
				$content = '';
			}
			return DingesForm::generateTag($this->element, $this->attributes, htmlspecialchars($content, ENT_NOQUOTES)) . $this->getRestrictionComment();
		}

		function setMaxLength($length) {
			$this->maxLength = intval($length);
		}

		function setMinLength($length) {
			$this->minLength = intval($length);
		}

		function setCols($nr) {
			if(intval($nr) > 0) {
				$this->cols = intval($nr);
			}
		}

		function setRows($nr) {
			if(intval($nr) > 0) {
				$this->rows = intval($nr);
			}
		}
	}
?>
