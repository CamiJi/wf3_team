<?php
	session_start();

	require(__DIR__.'/config/db.php');

	// Vérifie que le button submit a été cliqué
	if(isset($_POST['action'])) {
		$email = trim(htmlentities($_POST['inputEmail1']));
		$password = trim(htmlentities($_POST['inputPassword']));

		// Initialisation d'un tableau d'erreurs
		$errors = [];

		// 1. Récupération de l'utilisateur dans la bdd grâce à son email
		$query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$resultUser = $query->fetch();

		// Si l'utilisateur a été trouvé
		if($resultUser) {
			// Compare un password en clair avec un password haché
			// Attention, PHP 5.5 ou plus !!! - Sinon, depuis 5.3.7 : https://github.com/ircmaxell/password_compat
			$isValidPassword = password_verify($password, $resultUser['password']);

			if($isValidPassword) {
				// On stocke le user en session et on retire le password avant (pas très grave)
				unset($resultUser['password']);
				$_SESSION['user'] = $resultUser;

				// On redirige l'utilisateur vers la page protégé profile.php
				header("Location: catalogue.php");
				die();
			}
			else {
				$errors['password'] = "Mauvais mot de passe";
			}
		}
		else {
			$errors['user'] = "Email inconnu";
		}

		$_SESSION['loginErrors'] = $errors;
		
		header("Location: connexion.php");
		die();
	}
?>