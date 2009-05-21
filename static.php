<?php
	class DingesStatic extends DingesLabelField {
		protected $realLabelTag = false;

		function generateHTML() {
			return DingesForm::generateTag('span', array('id' => $this->form->getFieldIdPrefix() . $this->id), $this->getDefaultValue());
		}
	}
?>
