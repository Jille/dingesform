<?php
	class DingesText extends DingesInputField {
		protected $maxLength;
		
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
			$this->setAttribute('type', 'text');
			$this->setAttribute('value', $this->getEffectiveValue());
			if(isset($this->maxLength) && $this->maxLength > 0) {
				$this->setAttribute('maxlength', $this->maxLength);
			}
		}
	}
?>
