<?php
	abstract class DingesLabelField extends DingesField {
		protected $label;
		protected $realLabelTag = true;

		function __construct($name, $label) {
			parent::__construct($name);
			$this->label = $label;
		}

		function getLabelTag() {
			$attributes = array();
			if($this->realLabelTag) {
				$element = 'label';
				$attributes['for'] = $this->f->fieldIdPrefix . $this->id;
			} else {
				$element = 'span';
			}
			$attributes['id'] = $this->f->fieldIdPrefix .'label_'. $this->id;
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
