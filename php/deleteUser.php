<?php		
	/* Script that deletes the user */
	require_once('PDOInterface.php');
	require_once('PDOClass.php');
	$pd = new PDOClass;
	
	
	session_start();	
	if (!isset($_SESSION['username']))
	{
		header("Location: ../index.html");
	} 
	
	else
	{
		$u = $_SESSION['username'];		
		$result = $pd->deleteUser($u);
		header("Location: ../index.html");	
	}
?>