<?php
	class DingesSubmit extends DingesLabelField {
		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'submit');
			$this->setAttribute('value', $this->label);
		}
	}
?>
