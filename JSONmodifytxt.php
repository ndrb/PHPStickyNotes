<?php
	/* Script that saves the new text attributes (title and subject) of the sticky note whenever they are changed */
	require_once('php/PDOInterface.php');
	require_once('php/PDOClass.php');
	$pd = new PDOClass;

	$ident = htmlentities($_POST['ident']);
	$title = htmlentities($_POST['title']);
	$subject = htmlentities($_POST['subject']);
	
	$pd->modifyStickyTxt($ident, $title, $subject);
?>