<?php
    session_start();

    require(__DIR__.'/config/db.php');


    // Vérifie que le button submit a été cliqué
    if(isset($_POST['action'])) {
        // Affecte une variable à chaque valeur clé de $_POST
        $email = trim(htmlentities($_POST['email']));
        $password = trim(htmlentities($_POST['password']));
        $passwordConfirm = trim(htmlentities($_POST['passwordConfirme']));

    // Initialisation d'un tableau d'erreurs
     $errors = [];

    // Check du champs email
    if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
            $errors['email'] = "Wrong email.";
    }

    elseif(strlen($email) > 60) {
            $errors['email'] = "Email too long.";
    }

    else {
            // Je vérifie que l'email existe pas déjà dans ma bdd
            $query = $pdo->prepare('SELECT email FROM users WHERE email = :email');
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();
            // Je récupère le résultat sql
            $resultEmail = $query->fetch();

    if($resultEmail['email']) {
                $errors['email'] = "Email already exists.";
    }
}    

    // Check du champs password
        // 1. Vérifier que les 2 passwords sont identiques
        // 2. Vérifier que le passwords ne fasse moins de 6 caractères
        // 3. Conditions de caractères dans le password

        if($password != $passwordConfirm) {
            $errors['password'] = "Not same passwords.";
        }
        elseif(strlen($password) <= 6) {
            $errors['password'] = "Password too short.";
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
                $errors['password'] = "Choose a best password with at least one letter, one number and one special character.";
            }
        }

// S'il a pas d'erreurs, j'enregistre l'utilisateur en bdd
        if(empty($errors)) {
            $query = $pdo->prepare('INSERT INTO users(email, password, created_at, updated_at) VALUES(:email, :password, NOW(), NOW())');
            $query->bindValue(':email', $email, PDO::PARAM_STR);

            // Hash du password pour la sécurité
            // Attention, PHP 5.5 ou plus !!! - Sinon, depuis 5.3.7 : https://github.com/ircmaxell/password_compat
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
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

                // On redirige l'utilisateur vers la page protégé profile.php
                header("Location: profile.php");
                die();
            }
        }
        else {
            // On stocke toutes les erreurs en session
            $_SESSION['registerErrors'] = $errors;

            // On redirige dans l'index
            header("Location: index.php");
            die();
        }


    }        


?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main_form.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Exemple d'Input de connexion "Email" + "Password" -->
        <!-- <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form> -->

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" id="header">
      <div class="container">
        <a href="index.php"><img src="img/Steam-icon.png"></a>
        <h1>Gameloc</h1>

      </div>
    </div>


 

<div class = "container">
<form id="formInscription">
    <div class="form-group">
        <label for="formEmail1">Email</label>
        <input type="email" class="form-control" id="formEmail" name="formEmail" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="formPassword">Mot de passe</label>
        <input type="password" class="form-control" id="formPassword" name="formPassword" placeholder="Password">
    </div>

    <div class="form-group">
        <label for="formPasswordConfirme">Confirmer mot de passe</label>
        <input type="password" class="form-control" id="formPasswordConfirme" name="formPasswordConfirme" placeholder="Confirmer mot de passe">
    </div>

    <div class="form-group">
        <label for="formName">Nom</label>
        <input type="text" class="form-control" id="formNom" name="formNom" placeholder="Nom">
    </div>

    <div class="form-group">
        <label for="formPrenom">Prénom</label>
        <input type="prenom" class="form-control" id="formPrenom" name="formPrenom" placeholder="Prénom">
    </div>

    <div class="form-group">
        <label for="formAdresse">Adresse</label>
        <input type="text" class="form-control" id="formAdresse" name="formAdresse" placeholder="Adresse">
    </div>

    <div class="form-group">
        <label for="formCodePostal">Code postal</label>
        <input type="number" class="form-control" id="formCodePostal" name="formCodePostal" placeholder="Code postal">
    </div>

    <div class="form-group">
        <label for="formVille">Ville</label>
        <input type="text" class="form-control" id="formVille" name="formVille" placeholder="Ville">
    </div>

    <div class="form-group">
        <label for="formPhone">Téléphone</label>
        <input type="number" class="form-control" id="formPhone" name="formPhone" placeholder="Téléphone">
    </div>

    <button type="submit" class="btn btn-primary" name="action">Valider</button>
    

</form>
</div> <!-- Fin du container -->






      <!-- Démarrage et chargement des scripts -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='http://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
