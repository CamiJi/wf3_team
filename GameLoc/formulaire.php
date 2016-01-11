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
        <input type="email" class="form-control" id="formEmail1" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="formPassword1">Mot de passe</label>
        <input type="password" class="form-control" id="formPassword1" placeholder="Password">
    </div>

    <div class="form-group">
        <label for="formPassword1">Confirmer mot de passe</label>
        <input type="password" class="form-control" id="formPassword1" placeholder="Confirmer mot de passe">
    </div>

    <div class="form-group">
        <label for="formName">Nom</label>
        <input type="text" class="form-control" id="formNom" placeholder="Nom">
    </div>

    <div class="form-group">
        <label for="formPrenom">Prénom</label>
        <input type="prenom" class="form-control" id="formPrenom" placeholder="Prénom">
    </div>

    <div class="form-group">
        <label for="formAdresse">Adresse</label>
        <input type="text" class="form-control" id="formAdresse" placeholder="Adresse">
    </div>

    <div class="form-group">
        <label for="formCodePostal">Code postal</label>
        <input type="number" class="form-control" id="formCodePostal" placeholder="Code postal">
    </div>

    <div class="form-group">
        <label for="formVille">Ville</label>
        <input type="text" class="form-control" id="formVille" placeholder="Ville">
    </div>

    <div class="form-group">
        <label for="formPhone">Téléphone</label>
        <input type="number" class="form-control" id="formPhone" placeholder="Téléphone">
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>
    

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