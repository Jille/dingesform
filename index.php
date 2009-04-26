<?php
	error_reporting(E_ALL);
	require('form.php');
	require('field.php');
	require('textfield.php');

	$f = new DingesForm();
	$name = $f->createField('text', 'name', true, 'Naam');

	$f->render();

	$strings = $f->getStrings();
?>
<html>
	<head>
		<title>DingesForm - test</title>
	</head>
	<body>
		<table>
			<tr>
				<td><?= $strings['label_name'] ?></td>
				<td><?= $strings['element_name'] ?></td>
			</tr>
		</table>
		Strings:
		<ul>
<?php foreach(array_keys($strings) as $key) { ?>
			<li><?= $key ?></li>
<?php } ?>
		</ul>
	</body>
</html>
