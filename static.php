<?php
	class DingesStatic extends DingesField {
		function render() {
			return DingesForm::generateTag('span', array('id' => $this->f->fieldIdPrefix . $this->id), $this->getDefaultValue());
		}

		function getLabelTag() {
			return DingesForm::generateTag('span', array('id' => $this->f->fieldIdPrefix .'label_'. $this->id), $this->getDefaultValue());
		}
	}
?>
