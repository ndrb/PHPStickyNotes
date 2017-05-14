<?php
	/* Script that saves the new position of the sticky note whenever it is moved */
	require_once('php/PDOInterface.php');
	require_once('php/PDOClass.php');
	$pd = new PDOClass;

	$ident = $_POST['ident'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$z = $_POST['z'];
	
	$pd->modifyStickyDragg($ident, $x, $y, $z);
?>