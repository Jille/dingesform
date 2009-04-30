<?php
	class DingesRadioButton extends DingesInputField implements DingesMultipleElement {
		protected $options = array();
		protected $realLabelTag = false;

		function addItem($value, $content, $escape_html = true) {
			$this->options[$value] = array('value' => $value, 'content' => htmlspecialchars($content, ENT_NOQUOTES, NULL, false), 'id' => $this->f->getFieldIdPrefix() .'id_radiobutton_'. $this->name .'_'. $value);
		}

		function validate($value) {
			$valid = parent::validate($value);
			if($valid !== true) {
				return $valid;
			}
			if($value !== NULL && !isset($this->options[$value])) {
				return 'ERR_UNKNOWN_OPTION';
			}
			return true;
		}

		function render() {
			$this->fillAttributes();
			$strings = array();
			foreach($this->options as $option) {
				$strings['radiobutton_'. $this->name .'_'. $option['value']] = $this->generateHTML($option);
				$strings['label_radiobutton_'. $this->name .'_'. $option['value']] = $this->getRadioLabelTag($option);
			}
			return $strings;
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'radio');
		}

		function generateHTML($option) {
			$this->setAttribute('id', $option['id']);
			$this->setAttribute('value', $option['value']);
			if($option['value'] == $this->getEffectiveValue()) {
				$this->setAttribute('checked', 'checked');
			} else {
				$this->deleteAttribute('checked');
			}
			return DingesForm::generateTag('input', $this->attributes);
		}

		function getRadioLabelTag($option) {
			$attributes = array();
			$attributes['for'] = $option['id'];
			$attributes['id'] = $this->f->getFieldIdPrefix() .'label_'. $this->id .'_'. $option['value'];
			return DingesForm::generateTag('label', $attributes, $option['content']);
		}
	}
?>
