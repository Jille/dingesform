<?php
	abstract class DingesLabelField extends DingesDefaultValueField {
		protected $label;
		protected $realLabelTag = true;

		function __construct($name, $label) {
			parent::__construct($name);
			$this->label = $label;
		}

		function getLabelId() {
			return 'label_'. $this->getId();
		}

		function getFullLabelId() {
			return $this->form->getFieldIdPrefix() .'label_'. $this->getId();
		}

		function getLabelTag() {
			$attributes = array();
			if($this->realLabelTag) {
				$element = 'label';
				$attributes['for'] = $this->getFullId();
			} else {
				$element = 'span';
			}
			$attributes['id'] = $this->getFullLabelId();
			if($this->isValid() === false) {
				$attributes['class'] = 'dingesErrorLabel';
			}
			return DingesForm::generateTag($element, $attributes, $this->label);
		}

		/* Simple getters and setters */
		function getLabel() {
			return $this->label;
		}

		function setLabel($value) {
			$this->label = $value;
		}
	}
?>
