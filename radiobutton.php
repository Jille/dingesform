<?php
	class DingesRadioButton extends DingesMultiInputField {
		protected $realLabelTag = false;

		function validate($value) {
			$valid = parent::validate($value);
			if($valid !== true) {
				return $valid;
			}
			if($value !== NULL && !isset($this->items[$value])) {
				return 'ERR_UNKNOWN_OPTION';
			}
			return true;
		}

		function render() {
			$this->fillAttributes();
			$value = $this->getEffectiveValue();
			$strings = array();
			foreach($this->items as $item) {
				$strings['element_'. $this->name .'_'. $item['value']] = $this->generateItemHTML($item, $value == $item['value']);
				$strings['label_'. $this->name .'_'. $item['value']] = $this->getItemLabelTag($item);
			}
			$strings['error_'. $this->name] = $this->generateErrorSpan();
			return $strings;
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'radio');
		}
	}
?>
