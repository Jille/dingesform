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

	$f = new DingesForm();
	$name = $f->createInputField('text', 'name', true, 'Naam');
	$name->defaultValue = 'Henk';
	$bla = $f->createInputField('checkbox', 'bla', false, 'Bla');
	$bla->defaultValue = true;
	$boink = $f->createInputField('select', 'boink', false, 'Boink');
	$boink->options = array('bla', 'schaap');
	$piet = $f->createInputField('textarea', 'piet', false, 'Piet');
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
