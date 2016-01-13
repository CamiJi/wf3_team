<?php
    session_start();

    require(__DIR__.'/config/db.php');

    // 1. Vérifier que le form a bien été soumis
    if(isset($_POST['action'])) {
        //2. Affecter une variable à l'email récupéré, (faire trim et htmlentities)
        $email = trim(htmlentities($_POST['email']));

        //3. Initialisation d'un tableau d'erreurs $errors
        $errors = [];
        // Tableau de messages notifications
        $notifications = [];

        //4. Check du champs email (pas vide, format email et inférieur à 60 caractères)
        if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
            $errors['email'] = "Wrong email.";
        }
        elseif (strlen($email) > 60) {
            $errors['email'] = "Email too long";
        }

        // S'il n'y a pas d'erreurs sur l'email
        if(empty($errors)) {
            // 5. Récupération de l'utilisateur dans la bdd
            $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $resultUser = $query->fetch();

            if($resultUser) {
                // 6. Génération du Token
                $token = md5(uniqid(mt_rand(), true));

                // 7. Date d'expiration du Token
                $expireToken = date("Y-m-d H:i:s", strtotime('+ 1 day'));

                // 8. Updater le user dans la bdd grâce à ces nouvelles informations
                $query = $pdo->prepare('UPDATE users 
                                        SET token = :token, expire_token = :expire_token, updated_at = NOW() 
                                        WHERE id = :id');
                $query->bindValue(':token', $token, PDO::PARAM_STR);
                $query->bindValue(':expire_token', $expireToken, PDO::PARAM_STR);
                $query->bindValue(':id', $resultUser['id'], PDO::PARAM_INT);
                $query->execute();

                // Equivalent à http://localhost/php/38/wf3_session/resetPassword.php?token=*****&email=*******
                $resetLink = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/resetPassword.php?token='.$token.'&email='.$email;
                //mail('edwin.polycarpe@gmail.com', 'Forgot Password', $resetLink);

                // Instance de phpmailer
                $mail = new PHPMailer;

                // Paramètre envoi e-mail
                $mail->setFrom('no-reply@wf3.com', 'WF3');
                $mail->addAddress($email); // 
                $mail->addAddress('edwin.polycarpe@gmail.com'); // A retirer en prod 

                // Format HTML
                $mail->isHTML(true);

                // Sujet de l'email
                $mail->Subject = 'Forgot your password ?';

                // Message de l'email
                $mail->Body    = '<p>Vous avez oublié votre mot de passe ? <br />
                <a href="'.$resetLink.'">Cliquez ici pour créer un nouveau mot de passe</a>
                </p>';

                // Envoi de l'email
                if($mail->send()) {
                    // Echo de resetLink car l'envoie de mail ne fonctionne pas :(
                    $notifications['email'] = "Email sent, check your email box ! $resetLink";
                }
                else {
                    $errors['email'] = "Application error. Email doesn't sent. $resetLink";
                }


            }
            else {
                $errors['user'] = "User not found.";    
            }
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
        <title>Récupération de mot de passe</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->



    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" id="header">
      <div class="container">
        <a href="index.php"><img src="img/Steam-icon.png"></a>
        <h1>Gameloc</h1>


      </div>
    </div>
            <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3>Envoyer un email de récupération de mot de passe</h3>
                    <hr/>

                    <?php if(!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $keyError => $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($notifications)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($notifications as $keyNotif => $notif) : ?>
                                <p><?php echo $notif; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                          <label for="email">Entrer votre adresse</label>
                          <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>

                        <button type="submit" name="action" class="btn btn-default">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>










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
