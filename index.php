<?php
	error_reporting(E_ALL);
	require('form.php');
	require('magic.php');
	require('field.php');
	require('defaultvaluefield.php');
	require('labelfield.php');
	require('inputfield.php');
	require('text.php');
	require('checkbox.php');
	require('submit.php');
	require('select.php');
	require('textarea.php');
	require('integer.php');
	require('password.php');
	require('radiobutton.php');
	require('static.php');
	require('checklist.php');
	require('multiplesubmit.php');
	require('hidden.php');
	require('submitimage.php');
	require('file.php');

	$f = new DingesForm();
	$f->setFieldIdPrefix('blaat_');

	$name = $f->createInputField('text', 'name', true, 'Naam');
	//$name->setDefaultValue('Henk"ie"');
	$name->setMaxLength(20);
	$name->addValidationRegex('/^\S+$/');

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
	$bier->addItem('heineken', '<s>Heineken</s>', 'slootwater');
	$bier->addItem('leffe', 'Leffe');
	$bier->addItem('latrappe', 'La Trappe');
	$bier->setAttribute('size', 4);
	$bier->setAttribute('multiple', 'multiple');

	$pass = $f->createInputField('password', 'pass', false, 'Wachtwoord');

	function notEqualsName($value) {
		global $name;
		if($name->getValue() == $value) {
			return 'ERR_UNSAFE';
		}
		return true;
	}
	$pass->addValidationCallback('notEqualsName');

	$jaofnee = $f->createInputField('radiobutton', 'jaofnee', false, 'Ja of Nee');
	$jaofnee->addItem('ja', 'Ja');
	$jaofnee->addItem('nee', 'Nee');

	$watdanwel = $f->createInputField('text', 'watdanwel', false, 'Wat dan wel?');

	$f->addPreValidationHook('watdanwel_bla');
	$jaofnee->setAttribute('onClick', 'watdanwel_bla();');

	function watdanwel_bla($f) {
		$f->getField('watdanwel')->setRequired($f->getField('jaofnee')->getValue() == 'nee');
	}

	$favbier = new DingesStatic('favbier', 'Favoriete bier');
	$favbier->setDefaultValue('Hertog Jan');
	$f->addField($favbier);

	$klikjerot = $f->createInputField('checklist', 'klikjerot', false, 'Klik je rot');
	foreach(range('a', 'f') as $i) {
		$klikjerot->addItem($i, strtoupper($i));
	}

	$fileup = $f->createInputField('file', 'fileup', false, 'Pr0n');
	$fileup->setMaxFileSize(1024*1024);

	$subm = new DingesSubmit('subm', 'Opst"uren');
	$f->addField($subm);

	$subimg = new DingesSubmitImage('subimg', 'opslaan.png');
	$f->addField($subimg);

	$what = new DingesMultipleSubmit('what');
	$what->addItem('bier', 'Ik wil bier');
	$what->addItem('wodka', 'Ik wil wodka');
	$f->addField($what);

	$hide = new DingesHidden('hide');
	$hide->setDefaultValue('and seek');
	$f->addField($hide);

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
		<script type="text/javascript" src="js/forms.js"></script>
		<script type="text/javascript">
			function watdanwel_bla() {
				document.getElementById('watdanwel_tr').style.display = document.getElementById('blaat_id_radiobutton_jaofnee_nee').checked ? '' : 'none';
				// XXX setRequired('watdanwel');
			}

			function page_init() {
				<?= $strings['form_init_code'] ?>
				watdanwel_bla();
			}
		</script>
	</head>
	<body onload="page_init();">
<?php if($f->isSubmitted()) { ?>
		<div style="color: green">OK!</div>
<?php
	var_dump($bla->getValue());
?>
<?php } elseif($f->isPosted()) { ?>
		<ul style="color: red">
<?php foreach($f->getValidationErrors() as $error) { ?>
			<li><?= $error ?></li>
<?php } ?>
		</ul>
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
				<td><?= $strings['label_jaofnee'] ?></td>
				<td><?= $strings['radiobutton_jaofnee_ja'] .' '. $strings['label_radiobutton_jaofnee_ja'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?= $strings['radiobutton_jaofnee_nee'] .' '. $strings['label_radiobutton_jaofnee_nee'] ?></td>
			</tr>
			<tr id="watdanwel_tr">
				<td><?= $strings['label_watdanwel'] ?></td>
				<td><?= $strings['element_watdanwel'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_favbier'] ?></td>
				<td><?= $strings['element_favbier'] ?></td>
			</tr>
			<tr>
				<td><?= $strings['label_klikjerot'] ?></td>
				<td><?= $strings['element_klikjerot_a'] ?> <?= $strings['label_klikjerot_a'] ?></td>
			</tr>
<?php foreach(range('b', 'f') as $i) { ?>
			<tr>
				<td></td>
				<td><?= $strings['element_klikjerot_'. $i] ?> <?= $strings['label_klikjerot_'. $i] ?></td>
			</tr>
<?php } ?>
			<tr>
				<td><?= $strings['label_fileup'] ?></td>
				<td><?= $strings['element_fileup'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?= $strings['element_subm'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?= $strings['element_subimg'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?= $strings['element_what_bier'] ?> <?= $strings['element_what_wodka'] ?></td>
			</tr>
		</table>
		<?= $strings['element_hide'] ?>
		<?= $strings['form_close'] ?>
		Strings:
		<ul>
<?php foreach(array_keys($strings) as $key) { ?>
			<li><?= $key ?></li>
<?php } ?>
		</ul>
	</body>
</html>
