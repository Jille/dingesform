<?php
	require('form.php');
	require('field.php');

	$f = new DingesForm();
	$name = $f->createField('text', 'name', true, 'Naam');
?>
