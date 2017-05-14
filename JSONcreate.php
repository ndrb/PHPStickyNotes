<?php
	/* Script that prepares data to be sent to the PDO class
	in order to instantiate a new sticky note object */
	require_once('php/PDOInterface.php');
	require_once('php/PDOClass.php');
	$pd = new PDOClass;

	$username = htmlentities($_POST['username']);	
	$title = "";
	$subject = "";
	$x = 100;
	$y = 100;
	$z = 100;
	
	$pdo = $pd->createNewSticky($username, $title, $subject, $x, $y, $z); 
	

	$id  = $pdo->lastInsertId();
	$data = [
	'id' => htmlentities($id),
	'username' => htmlentities($username),
	'title' => htmlentities($title),
	'subject' => htmlentities($subject),
	'x' => htmlentities($x),
	'y' => htmlentities($y),
	'z' => htmlentities($z)
	];
	
	echo json_encode($data);
?>