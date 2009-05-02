<?php
	class DingesHidden extends DingesField {
		function fillAttributes() {
			parent::fillAttributes();
			$this->setAttribute('type', 'hidden');
			$this->setAttribute('value', $this->getEffectiveValue());
		}
	}
?>
