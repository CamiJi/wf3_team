<?php
session_start();

require(__DIR__.'/config/db.php');
require(__DIR__.'/functions.php');
require(__DIR__.'/vendor/autoload.php');


    // verifier le form submit
if(isset($_POST['action'])) {
        // recuperation de l'email
    $email = trim(htmlentities($_POST['email']));

    $errors = [];

    if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL) === false)) {
        $errors['email'] = "Erreur email.";
    }

    if(empty($errors)) {
        $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $resultUser = $query->fetch();

        // Si j'ai bien un user en bdd
        if ($resultUser) {
            // generation du token
            $token = md5(uniqid(mt_rand(), true));

            // date d'ecpiration du token
            $expireToken = date("Y-m-d H:i:s", strtotime("+ 1 day"));

            // recup de l'adresse ip du demandeur
            $ip = $_SERVER['REMOTE_ADDR'];

            // Sauvegarder les 3 elements ci-dessus dans notre bdd
            $query = $pdo->prepare('UPDATE users 
                SET token = :token, expire_token = :expire_token, ip = :ip
                WHERE id = :id');
            $query->bindValue(':token', $token, PDO::PARAM_STR);
            $query->bindValue(':expire_token', $expireToken, PDO::PARAM_STR);
            $query->bindValue(':ip', $ip, PDO::PARAM_STR);
            $query->bindValue(':id', $resultUser['id'], PDO::PARAM_INT);

            $query->execute();


            // si mise a jour Ok
            if($query->rowCount() > 0) {
                // generation du lien pour reset le password
                $resetLink = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'resetPassword.php?token='.$token.'&email='.$email;

                // echo $resetLink; die();

                // envoi un email à utilisateur
                $mail = new PHPMailer;




$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'postmaster@sandbox504c3f44050c4ee3aa785151b4924429.mailgun.org';                 // SMTP username
$mail->Password = '5af02be0e52d7990ab876526bae4ba3e';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('no-reply@aego.fr', 'Mailer');
$mail->addAddress($email);               // Name is optional

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Mot de passe oublié';
$mail->Body    = '<a href="'.$resetLink.'">Cliquez sur le lien suivant pour reset le password</a>';
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}   

// Terminer le resetPassword.php avec le modèle dans wf3_session             
}


}

else {
    $errors['email'] = "Cette adresse email n'est pas dans la bdd.";

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
