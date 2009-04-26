<?php
	class DingesSelect extends DingesInputField {
		protected $element = 'select';
		protected $options = array();

		function addItem($value, $content, $escape_html = true) {
			$this->options[] = array('value' => $value, 'content' => htmlspecialchars($content, ENT_NOQUOTES, NULL, false));
		}

		function generateHTML() {
			$value = $this->getEffectiveValue();
			$options = '';
			foreach($this->options as $option) {
				$attributes = array('value' => $option['value']);
				if($option['value'] == $value) {
					$attributes['selected'] = 'selected';
				}
				$options .= DingesForm::generateTag('option', $attributes, $option['content']);
			}
			return DingesForm::generateTag($this->element, $this->attributes, $options);
		}

		// IE (iig 6) selecteert het eerste element als je op het label klikt
		function getLabelTag() {
			$attributes = array();
			$attributes['for'] = $this->id;
			$attributes['id'] = 'label_'. $this->id;
			if(!$this->valid) {
				$attributes['class'] = 'dingesErrorLabel';
			}
			return DingesForm::generateTag('span', $attributes, $this->label);
		}
	}
?>
