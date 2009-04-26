<?php
	class DingesSubmit extends DingesField {
		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'submit');
			$this->setAttribute('value', $this->label);
		}
	}
?>
