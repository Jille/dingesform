<?php
	error_reporting(E_ALL);
	require('form.php');
	require('field.php');
	require('inputfield.php');
	require('text.php');
	require('checkbox.php');
	require('submit.php');
	require('select.php');
	require('textarea.php');
	require('integer.php');

	$f = new DingesForm();
	$name = $f->createInputField('text', 'name', true, 'Naam');
	$name->setDefaultValue('Henk');
	$bla = $f->createInputField('checkbox', 'bla', false, 'Bla');
	$bla->setDefaultValue(true);
	$boink = $f->createInputField('select', 'boink', false, 'Boink');
	$boink->addItem('bla', 'bla');
	$boink->addItem('schaap', 'schaap');
	$boink->addItem('50', '&euro; 50,-');
	$piet = $f->createInputField('textarea', 'piet', false, 'Piet');
	$int = $f->createInputField('integer', 'int', true, 'Int');
	$int->setMin(10);
	$int->setMax(100);
	$subm = new DingesSubmit('subm', 'Opsturen');
	$f->addField($subm);

	$f->render();

	$strings = $f->getStrings();
?>
<html>
	<head>
		<title>DingesForm - test</title>
	</head>
	<body>
<?php if($f->isSubmitted() && !$f->isValid()) { ?>
		<ul style="color: red">
<?php foreach($f->getValidationErrors() as $error) { ?>
			<li><?= $error ?></li>
<?php } ?>
		</ul>
<?php } elseif($f->isSubmitted()) { ?>
		<div style="color: green">OK!</div>
<?php } ?>
		<?= $strings['form_start'] ?>
		<table>
			<tr>
				<td><?= $strings['label_name'] ?></td>
				<td><?= $strings['element_name'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_bla'] ?></td>
				<td><?= $strings['element_bla'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_boink'] ?></td>
				<td><?= $strings['element_boink'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_piet'] ?></td>
				<td><?= $strings['element_piet'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_int'] ?></td>
				<td><?= $strings['element_int'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?= $strings['element_subm'] ?></td>
			</tr>
		</table>
		<?= $strings['form_end'] ?>
		Strings:
		<ul>
<?php foreach(array_keys($strings) as $key) { ?>
			<li><?= $key ?></li>
<?php } ?>
		</ul>
	</body>
</html>
