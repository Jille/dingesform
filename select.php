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

		function getLabelTag() {
			return DingesForm::generateTag('span', array(), $this->label);
		}
	}
?>
