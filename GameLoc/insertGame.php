<?php 

    // Mise en place de la logique de session utilisateur

    session_start();

    require_once(__DIR__.'/config/db.php');
    require_once(__DIR__.'/functions.php');

    checkLoggedIn();

    $imagesDir = 'uploads/';

$images = glob($imagesDir.'*');

if (isset($_POST['action'])){

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";


    // echo "Le poids de la photo est de : ".$_FILES['photo']['size']." kilo octets.";
    // echo "<br />";

    // echo "Ce fichier est une ".$_FILES['photo']['type'];


        // Je range ces données dans des variables pour les réutiliser ultérieurement!
    $nom = trim(htmlentities($_POST["nom"]));
    $photo = $_FILES["photo"];

    $nomPhoto = $_FILES['photo']["name"];
    $uploadFileType = $_FILES['photo']['type'];
    $uploadFilesSize = $_FILES['photo']['size'];

        // Je vérifie qu'aucune données ne manque et indique un message d'erreur si elles sont manquantes
        //  Je vérifie la validité des données 
        // nom et prénom = chaine de caractères de longueur min 2 max 10 
        // photo = size > 0 et type = jpeg || png || gif



            // 2. On vérifie le nom
        if(empty($nom)) {
            $erreur_nom = "<span class='bg-danger'>Le nom est obligatoire !</span>";
        }
        elseif(strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 255) {
            $erreur_nom_lenght = "<span class='bg-danger'>Vérifiez la longueur du nom du jeu ! </span>" ;
        }

            // 3. On vérifie la photo
        if(empty($photo)) {
            $erreur_photo = "<span class='bg-danger'>Une photo est obligatoire !</span>";
        }
        elseif($uploadFilesSize < 1) {
            $erreur_photo = "<span class='bg-danger'>Il n'y a pas d'image !</span>";
        }
        elseif(!strstr($uploadFileType, 'jpg') && !strstr($uploadFileType, 'jpeg') && !strstr($uploadFileType, 'png') && !strstr($uploadFileType, 'gif')){

            $erreurTypeFile = "<span class='bg-danger'>Seuls les fichiers Jpeg, Png et Gif sont acceptés!</span>";
        }
        // Si tout va bien on upload la photo ;) et on envoie l'admission
    else{
        $admission = "<span class='bg-info'>Merci pour votre jeu, retrouvez-le dans le catalogue ou soumettez d'autres jeux !</span>";
        move_uploaded_file($_FILES['photo']['tmp_name'], './uploads/'.$_FILES['photo']['name']);
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
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php require_once(__DIR__.'/nav.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" id="header">
      <div class="container">
        <a href="index.php"><img src="img/Steam-icon.png"></a>
        <h1>Ajoutez un jeu au catalogue</h1>
      </div>
    </div>



    <div class="container">
        <div class="row" id="sendIt">

                <div class="col-md-6 col-md-offset-2">
                    <h4>Remplissez soigneusement le formulaire ci-dessous</h4>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nom">Nom du jeux</label>
                            <input class="form-control" type="text" id="nom" name ="nom" placeholder="Nom" >                        
                            <?php if(isset($erreur_nom)) echo $erreur_nom ?>
                            <?php if(isset($erreur_nom_lenght)) echo $erreur_nom_lenght ?>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" id="photo" name="photo">
                            <p class="help-block">L'image doit être inférieure à 1 Mo, sinon elle ne sera pas traité.<br/>
                            Extension acceptées *.jpg, *.png, *.gif</p>
                            <?php if(isset($erreurTypeFile)) echo $erreurTypeFile ?>
                            <?php if(isset($erreur_photo)) echo $erreur_photo ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="action" class="btn btn-default">Envoyer</button>
                        </div>
                        <h4><?php if(isset($admission)) echo $admission ?></h4>
                    </form>
                </div>      

        </div>

        
        <?php if (isset($admission)) : ?>
            <div class="row" id="data">
                
                <div class="col-md-8 col-md-offset-3" id="lastPic">

                    <h3>Le dernier jeu envoyé:</h3>

                    <?php echo "<img class='img-thumbnail' height='320' width='180' src='uploads/".$nomPhoto."''>" ?>

                </div>
                
            </div>  
        <?php endif; ?>

    </div><!-- Fin du container -->










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
