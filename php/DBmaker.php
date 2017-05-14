<?php
    //Instantiates a PDO object with the necessary parameters.
    //And retrieves the table building SQL script and runs it.
    $pdo = new PDO('mysql:host=localhost', 'root', '');
		$sql = file_get_contents('sql/keepr.sql');
		$pdo->exec($sql);
?>