<?php
	class DingesRadioButton extends DingesInputField {
		protected $options = array();

		function addItem($value, $content, $escape_html = true) {
			$this->options[$value] = array('value' => $value, 'content' => htmlspecialchars($content, ENT_NOQUOTES, NULL, false));
		}

		function validate($value) {
			$valid = parent::validate($value);
			if($valid !== true) {
				return $valid;
			}
			if(!isset($this->options[$value])) {
				return 'ERR_UNKNOWN_OPTION';
			}
			return true;
		}

		function render() {
			$this->fillAttributes();
			$strings = array();
			foreach($this->options as &$option) {
				$strings['radio_'. $this->name .'_'. $option['value']] = $this->generateHTML($option);
				$strings['radio_label_'. $this->name .'_'. $option['value']] = $this->getRadioLabelTag($option);
			}
			unset($option);
			return $strings;
		}

		function fillAttributes() {
			parent::fillAttributes();

			$this->setAttribute('type', 'radio');
			if($this->required) {
				$this->setAttribute('required', 'true');
			}
		}

		function generateHTML(&$option) {
			$option['id'] = 'radio_id_'. $option['value'];
			$this->setAttribute('id', $option['id']);
			$this->setAttribute('value', $option['value']);
			if($option['value'] == $this->getEffectiveValue()) {
				$this->setAttribute('checked', 'checked');
			} else {
				$this->deleteAttribute('checked');
			}
			return DingesForm::generateTag('input', $this->attributes);
		}

		function getRadioLabelTag(&$option) {
			$attributes = array();
			$attributes['for'] = $option['id'];
			$attributes['id'] = 'label_'. $option['id'];
			if($this->isValid() === false) {
				$attributes['class'] = 'dingesErrorLabel';
			}
			return DingesForm::generateTag('label', $attributes, $option['content']);
		}

		function getLabelTag() {
			return DingesForm::generateTag('span', array('id' => 'label'. $this->id), $this->label);
		}

	}
?>
