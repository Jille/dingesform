<?php
	class DingesStatic extends DingesLabelField {
		function render() {
			return DingesForm::generateTag('span', array('id' => $this->f->getFieldIdPrefix() . $this->id), $this->getDefaultValue());
		}

		function getLabelTag() {
			return DingesForm::generateTag('span', array('id' => $this->f->getFieldIdPrefix() .'label_'. $this->id), $this->label);
		}
	}
?>
