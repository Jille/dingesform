<?php
	class DingesStatic extends DingesField {
		function render() {
			return DingesForm::generateTag('span', array('id' => $this->id), $this->getDefaultValue());
		}
	}
?>
