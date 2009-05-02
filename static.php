<?php
	class DingesStatic extends DingesLabelField {
		function render() {
			return DingesForm::generateTag('span', array('id' => $this->form->getFieldIdPrefix() . $this->id), $this->getDefaultValue());
		}

		function getLabelTag() {
			return DingesForm::generateTag('span', array('id' => $this->form->getFieldIdPrefix() .'label_'. $this->id), $this->label);
		}
	}
?>
