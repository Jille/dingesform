<?php
	class DingesTextarea extends DingesInputField {
		protected $maxLength;
		protected $cols = 60;
		protected $rows = 4;

		protected $element = 'textarea';
		
		function validate($value) {
			if(($error = parent::validate($value)) !== true) {
				return $error;
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
		}

		function generateHTML() {
			if(!$content = $this->getEffectiveValue()) {
				$content = '';
			}
			return DingesForm::generateTag($this->element, $this->attributes, htmlspecialchars($content, ENT_NOQUOTES));
		}
	}
?>
