<?php
	class DingesCheckList extends DingesInputField implements DingesMultipleElement {
		protected $options = array();

		function addItem($value, $content) {
			$this->options[] = array('value' => $value, 'content' => htmlspecialchars($content, ENT_NOQUOTES, NULL, false));
		}

		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('name', $this->name .'[]');
			$this->setAttribute('multiple', 'multiple');
			$this->setAttribute('type', 'checkbox');
		}

		function generateHTML() {
			$value = $this->getEffectiveValue();
			$strings = array();
			foreach($this->options as $i=>$option) {
				$attributes = $this->attributes;
				$attributes['id'] = $this->f->fieldIdPrefix . $this->id .'_'. $option['value'];
				$attributes['value'] = $option['value'];
				if($value && in_array($option['value'], $value)) {
					$attributes['checked'] = 'checked';
				}
				$strings['element_'. $this->name .'_'. $option['value']] = DingesForm::generateTag('input', $attributes);
				$strings['label_'. $this->name .'_'. $option['value']] = $this->getCheckBoxLabelTag($option);
			}
			return $strings;
		}

		function getCheckBoxLabelTag($option) {
			$attributes = array();
			$attributes['id'] = $this->f->fieldIdPrefix .'label_'. $this->id .'_'. $option['value'];
			$attributes['for'] = $this->f->fieldIdPrefix . $this->id .'_'. $option['value'];
			if($this->isValid() === false) {
				$attributes['class'] = 'dingesErrorLabel';
			}
			return DingesForm::generateTag('label', $attributes, $option['content']);
		}
	}
?>
