<?php
	error_reporting(E_ALL);
	require('form.php');
	require('field.php');
	require('textfield.php');

	$f = new DingesForm();
	$name = $f->createField('text', 'name', true, 'Naam');
	$subm = $f->createField('submit', 'subm', 'Opsturen');

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
