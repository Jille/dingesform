<?php
	error_reporting(E_ALL);
	require('form.php');
	require('field.php');
	require('inputfield.php');
	require('text.php');
	require('submit.php');

	$f = new DingesForm();
	$name = $f->createInputField('text', 'name', true, 'Naam');
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
		<?= $strings['form_start'] ?>
		<table>
			<tr>
				<td><?= $strings['label_name'] ?></td>
				<td><?= $strings['element_name'] ?></td>
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
