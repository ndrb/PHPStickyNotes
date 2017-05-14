<?php
	/* Script that retreives all sticky notes associated with a particular user */
	require_once('php/PDOInterface.php');
	require_once('php/PDOClass.php');
	$pd = new PDOClass;

	$username = htmlentities($_POST['username']);	
	
	$pdo = $pd->retreiveStickies($username); 
	
	echo json_encode($pdo);
?>