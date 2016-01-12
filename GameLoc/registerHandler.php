<?php
	session_start();

	require(__DIR__.'/config/db.php');


	// on appelle les fonctions dont Geoloc dans un fichier à part
	include(__DIR__.'/functions.php');


	// Vérifie que le button submit a été cliqué
	if(isset($_POST['action'])) {
		// Affecte une variable à chaque valeur clé de $_POST
		$email = trim(htmlentities($_POST['formEmail']));
		$password = trim(htmlentities($_POST['formPassword']));
		$passwordConfirm = trim(htmlentities($_POST['formPasswordConfirme']));
		$nom = trim(htmlentities($_POST['formNom']));
		$prenom = trim(htmlentities($_POST['formPrenom']));
		$adresse = trim(htmlentities($_POST['formAdresse']));
		$codePostal = trim(htmlentities($_POST['formCodePostal']));
		$ville = trim(htmlentities($_POST['formVille']));
		$phone = trim(htmlentities($_POST['formPhone']));

		// Initialisation d'un tableau d'erreurs
		$errors = [];

		// Check du champs email
		if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
			$errors['email'] = "Email incorrect";
		}
		elseif(strlen($email) > 60) {
			$errors['email'] = "Email trop long.";
		}
		else {
			// Je vérifie que l'email n'existe pas déjà dans ma bdd
			$query = $pdo->prepare('SELECT email FROM users WHERE email = :email');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			// Je récupère le résultat sql
			$resultEmail = $query->fetch();

			if($resultEmail['email']) {
				$errors['email'] = "Email existant, connectez vous";
			}
		}

		// Check du champs password
		// 1. Vérifier que les 2 passwords sont identiques
		// 2. Vérifier que le passwords ne fasse moins de 6 caractères
		// 3. Conditions de caractères dans le password

		if($password != $passwordConfirm) {
			$errors['password'] = "Mot de passe différent";
		}
		elseif(strlen($password) <= 6) {
			$errors['password'] = "Password trop court (7 caractère minimum - 1 chiffre - 1 caractère spécial)";
		}
		else {
			// Le password contient au moins une lettre ?
			$containsLetter = preg_match('/[a-zA-Z]/', $password);
			// Le password contient au moins un chiffre ?
			$containsDigit  = preg_match('/\d/', $password);
			// Le password contient au moins un autre caractère ?
			$containsSpecial= preg_match('/[^a-zA-Z\d]/', $password);

			// Si une des conditions n'est pas remplie ... erreur
			if(!$containsLetter || !$containsDigit || !$containsSpecial) {
				$errors['password'] = "Choisissez un password plus complexe (7 caractère minimum - 1 chiffre - 1 caractère spécial)";
			}
		}


		// Check du champs nom
		
		$nameRegex = preg_match('/[a-zA-Z]{4,14}/', $nom);
			// Le password contient au moins un chiffre ?
		$containsDigit  = preg_match('/\d/', $nom);
			// Le password contient au moins un autre caractère ?
		$containsSpecial= preg_match('/[^a-zA-Z\d]/', $nom);

			// Si une des conditions n'est pas remplie ... erreur
			if($containsDigit || $containsSpecial) {
				$errors['nom'] = "Le nom ne peut pas contenir de chiffre ou de caractères spéciaux.";
			}
			elseif (!$nameRegex) {
				$errors['nom'] = "Le nom doit être composé de 4 à 14 caractères alpha.";
			}
		



		// Check du champs prénom
		
		$firstNameRegex = preg_match('/[a-zA-Z]{4,14}/', $prenom);
			// Le password contient au moins un chiffre ?
		$containsDigit  = preg_match('/\d/', $prenom);
			// Le password contient au moins un autre caractère ?
		$containsSpecial= preg_match('/[^a-zA-Z\d]/', $prenom);

			// Si une des conditions n'est pas remplie ... erreur
			if($containsDigit || $containsSpecial) {
				$errors['prenom'] = "Le prénom ne peut pas contenir de chiffre ou de caractères spéciaux.";
			}
			elseif (!$firstNameRegex) {
				$errors['prenom'] = "Le prénom doit être composé de 4 à 14 caractères alpha.";
			}



		// Check du champs code Postale
		
		$postalRegex = preg_match("/^[0-9]{5}$/", $codePostal);


			// Si une des conditions n'est pas remplie ... erreur
			if(!$postalRegex) {
				$errors['codePostal'] = "Entrez un code postale valide";
			}


		// Check du champs ville
		
		$cityRegex = preg_match('/[a-zA-Z]{4,14}/', $ville);
			// Le password contient au moins un chiffre ?
		$containsDigit  = preg_match('/\d/', $ville);

			// Si une des conditions n'est pas remplie ... erreur
			if($containsDigit) {
				$errors['ville'] = "Le ville ne peut pas contenir de chiffre ou de caractères spéciaux.";
			}
			elseif (!$cityRegex) {
				$errors['ville'] = "Le ville doit être composé de 4 à 14 caractères alpha.";
			}


		// Check du champs code Postale
		
		$postalRegex = preg_match("/^[0-9]{10}$/", $phone);


			// Si une des conditions n'est pas remplie ... erreur
			if(!$postalRegex) {
				$errors['phone'] = "Entrez un numéro de téléphone valide";
			}





		// S'il a pas d'erreurs, j'enregistre l'utilisateur en bdd
		if(empty($errors)) {

			// on concatène les éléments pour former une variable adresse

			$completeAdresse = $adresse." ".$codePostal." ".$ville;

			//on appelle la fonction Geoloc, on lui donne $completeAdresse comme  attribut et on stock le resultat

			$resultGeoCode = geocode($completeAdresse);


			// on récupère chaque valeur latitude et longitude que l'on stocke dans une variable

			$lat=$resultGeoCode['lat'];
			$lng=$resultGeoCode['lng'];



			// On insère les données dans la BDD

			$query = $pdo->prepare('INSERT INTO users(email, password, created_at, updated_at, name, firstname, address, zipcode, city, tel, lat, lng) 
									VALUES(:email, :password, NOW(), NOW(), :name, :firstname, :address, :zipcode, :city, :tel, :lat, :lng)');
			$query->bindValue(':email', $email, PDO::PARAM_STR);

			// Hash du password pour la sécurité
			// Attention, PHP 5.5 ou plus !!! - Sinon, depuis 5.3.7 : https://github.com/ircmaxell/password_compat
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);


			$query->bindValue(':name', $nom, PDO::PARAM_STR);
			$query->bindValue(':firstname', $prenom, PDO::PARAM_STR);
			$query->bindValue(':address', $adresse, PDO::PARAM_STR);
			$query->bindValue(':zipcode', $codePostal, PDO::PARAM_STR);
			$query->bindValue(':city', $ville, PDO::PARAM_STR);
			$query->bindValue(':tel', $phone, PDO::PARAM_STR);
			$query->bindValue(':lat', $lat, PDO::PARAM_STR);
			$query->bindValue(':lng', $lng, PDO::PARAM_STR);


			$query->execute();

			// L'utilisateur a t-il été bien inséré en bdd ?
			if($query->rowCount() > 0) {
				// Récupération de l'utilisateur depuis la bdd 
				// pour l'affecter à une variable de session
				$query = $pdo->prepare('SELECT * FROM users WHERE id = :id');
				$query->bindValue(':id', $pdo->lastInsertId(), PDO::PARAM_INT);
				$query->execute();
				$resultUser = $query->fetch();

				// On stocke le user en session et on retire le password avant (pas très grave)
				unset($resultUser['password']);
				$_SESSION['user'] = $resultUser;

				// On redirige l'utilisateur vers la page protégé formulaire.php
				header("Location: formulaire.php");
				die();
			}
		}
		else {
			// On stocke toutes les erreurs en session
			$_SESSION['registerErrors'] = $errors;

			// On redirige dans l'index
			header("Location: formulaire.php");
			die();
		}


	}
?>