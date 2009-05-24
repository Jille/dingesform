<?php
	abstract class DingesLabelField extends DingesDefaultValueField {
		protected $label;
		protected $realLabelTag = true;

		protected $labelAttributes = array();

		function __construct($name, $label) {
			parent::__construct($name);
			$this->label = $label;
		}

		function getLabelId() {
			return $this->getId() .'_label';
		}

		function getFullLabelId() {
			return $this->form->getFieldIdPrefix() . $this->getLabelId();
		}

		function getLabelTag() {
			$attributes = $this->labelAttributes;
			if($this->realLabelTag) {
				$element = 'label';
				$attributes['for'] = $this->getFullId();
			} else {
				$element = 'span';
			}
			$attributes['id'] = $this->getFullLabelId();
			if($this->isValid() === false) {
				if(isset($attributes['class'])) {
					$attributes['class'] .= ' dingesErrorLabel';
				} else {
					$attributes['class'] = 'dingesErrorLabel';
				}
			}
			return DingesForm::generateTag($element, $attributes, $this->label);
		}

		function setLabelAttribute($name, $value, $append = false) {
			if($append && isset($this->labelAttributes[$name])) {
				$this->labelAttributes[$name] .= $value;
			} else {
				$this->labelAttributes[$name] = $value;
			}
		}

		function deleteLabelAttribute($name) {
			unset($this->labelAttributes[$name]);
		}

		function getLabelAttribute($name) {
			return $this->labelAttributes[$name];
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
