<?php
	class DingesFieldValidationException extends Exception {
		public $field;

		function __construct($field, $message) {
			parent::__construct($message);
			$this->field = $field;
		}
	}
?>
