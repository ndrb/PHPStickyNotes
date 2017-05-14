<?php
	/* Logout script */
	session_start();	
	if (!isset($_SESSION['username']))
	{
		header("Location: ../index.html");
	}
	
	else
	{
		$_SESSION = array();
		$params = session_get_cookie_params();
		setCookie(session_name(), '', time() -50000, $params['path'],$params['domain'] );
		session_destroy();
		
		header("Location: ../index.html");
	}
?>