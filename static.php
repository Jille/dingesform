<?php
	class DingesStatic extends DingesLabelField {
		function render() {
			return DingesForm::generateTag('span', array('id' => $this->f->fieldIdPrefix . $this->id), $this->getDefaultValue());
		}

		function getLabelTag() {
			return DingesForm::generateTag('span', array('id' => $this->f->fieldIdPrefix .'label_'. $this->id), $this->label);
		}
	}
?>
