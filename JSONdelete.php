<?php
	/* Script that send in the id of the sticky to be deleted */
	require_once('php/PDOInterface.php');
	require_once('php/PDOClass.php');
	$pd = new PDOClass;

	$ident = $_POST['ident'];	
	
	$pd->deleteSticky($ident);
?>