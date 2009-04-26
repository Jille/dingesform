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
	require('password.php');
	require('static.php');

	$f = new DingesForm();

	$name = $f->createInputField('text', 'name', true, 'Naam');
	$name->setDefaultValue('Henk"ie"');

	$bla = $f->createInputField('checkbox', 'bla', false, 'Bla');
	$bla->setDefaultValue(true);

	$boink = $f->createInputField('select', 'boink', false, 'Bo&iuml;nk');
	$boink->addItem('"bla"', '"bla"');
	$boink->addItem('schaap', 'scha&euml;p');
	$boink->addItem('50', '&euro; 50,-');

	$piet = $f->createInputField('textarea', 'piet', false, 'Piet"je"');
	$piet->setDefaultValue("lalala, \"BIER!\" <br>\n</textarea>");

	$int = $f->createInputField('integer', 'int', true, 'Int<br>eger');
	$int->setMin(10);
	$int->setMax(100);

	$bier = $f->createInputField('select', 'bier', true, 'Bieren');
	$bier->addItem('hertogjan', 'Hertog Jan');
	$bier->addItem('heineken', '<s>Heineken</s>');
	$bier->addItem('leffe', 'Leffe');
	$bier->addItem('latrappe', 'La Trappe');
	$bier->setAttribute('size', 4);

	$pass = $f->createInputField('password', 'pass', false, 'Wachtwoord');

	$favbier = new DingesStatic('favbier', 'Favoriete bier');
	$favbier->setDefaultValue('Hertog Jan');
	$f->addField($favbier);

	$subm = new DingesSubmit('subm', 'Opst"uren');
	$f->addField($subm);

	$f->render();

	$strings = $f->getStrings();
?>
<html>
	<head>
		<title>DingesForm - test</title>
		<style type="text/css">
			.dingesError {
				border: 1px dotted red;
			}
			.dingesErrorLabel {
				color: red;
			}
		</style>
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
		<?= $strings['form_open'] ?>
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
				<td><?= $strings['label_bier'] ?></td>
				<td><?= $strings['element_bier'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_pass'] ?></td>
				<td><?= $strings['element_pass'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_favbier'] ?></td>
				<td><?= $strings['element_favbier'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?= $strings['element_subm'] ?></td>
			</tr>
		</table>
		<?= $strings['form_close'] ?>
		Strings:
		<ul>
<?php foreach(array_keys($strings) as $key) { ?>
			<li><?= $key ?></li>
<?php } ?>
		</ul>
	</body>
</html>
