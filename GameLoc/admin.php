<?php 

	session_start();

	require(__DIR__.'/config/db.php');
	require(__DIR__.'/functions.php');




	checkLoggedIn();

	// Ici l'utilisateur est connecté

	if ($_SESSION['user']['role'] != 'admin') {
		header("HTTP/1.0 403 Forbidden");
		die();
	}



?>