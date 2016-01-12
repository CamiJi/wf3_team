<?php 

// Mise en place de la logique de session utilisateur

    session_start();

    require_once(__DIR__.'/config/db.php');


    // Ici on va chercher à faire la PAGINATION
        // 1. Grâce à une query et la fonction SQL COUNT, récuperer le nombre total de games dans ma bdd
        $query = $pdo->query('SELECT COUNT(*) AS total FROM games');
        $countGames = $query->fetch();
        $totalGames = $countGames['total']; 

        // 2. Trouver la fonction qui arrondi une décimal à son entier supérieur et utiliser la 
        // fonction ceil
        $limitGames = 4;
        $pagesGames = ceil($totalGames / $limitGames);

        // 6. Récupérer la variable page envoyée en GET et l'affecter à $pageActiveGame
        if(isset($_GET['page'])) {
            $pageActiveGame = $_GET['page'];
        }
        else {
            $pageActiveGame = 1;
        }

        // 7. Créer la variable $offsetGames et la binder dans la requête SQL
        $offsetGames = ($pageActiveGame - 1) * $limitGames;

        // 4. Construire la requête sql pour récupérer les 100 premiers users 
        // (tester avec phpMyAdmin)
        // Requete SQL : SELECT * FROM users LIMIT 100 OFFSET 0;
        $query = $pdo->prepare('SELECT * FROM games LIMIT :limit OFFSET :offset');
        $query->bindValue(':limit', $limitGames, PDO::PARAM_INT);
        $query->bindValue(':offset', $offsetGames, PDO::PARAM_INT);
        $query->execute();

        $games = $query->fetchAll();






    //Ici on va faire inclure la liste des consoles dans la liste à puce
        $query = $pdo->prepare('SELECT * FROM platforms');
        $query->execute();
        $allPlatforms = $query->fetchAll();



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
        <link rel="stylesheet" href="css/catalogue.css">

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
        <a href="index.php"><img src="img/Steam-icon.png" ></a>
        <h1>Gameloc</h1>
        <p>Catalogue de jeux!</p>
    </div>
</div>

<div class="row" id="row1">

    <div class="col-md-3">

        <div id="searchForm">
           <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <div class="form-group">
                <label for="search">Rechercher</label>
                <input type="text" class="form-control" id="search" name="search" palceholder="titre, description..." value="<?php if(isset($_GET['search'])) echo $_GET['search'] ?>">
            </div>

            <div class="form-group">
                <label for="search">Plateforme</label>
                <select class="form-control" id="category" name="category">

                    <?php foreach ($allPlatforms as $keyplatforms => $platform): ?>
                        <option><?php echo $platform['name'] ?></option>
                    <?php endforeach; ?>

                </select>
            </div>



            <div class="checkbox">
                <label>
                  <input type="checkbox"> Disponible de suite</label>
              </div>

              <button class="btn btn-primary" action="search" value="search">Rechercher</button>

          </form>
      </div>



  </div><!-- Fin de la colonne Recherche -->


  <div class="col-md-9">

    <div class="container" id="containerGames">

        <div class="row" id="row2">


            <?php if(!empty($games)): ?>



                <?php foreach ($games as $keygames => $game): ?>

                    <div class="col-md-3" id="game<?php echo $game['id']; ?>">

                        <img src="<?php echo $game['img']; ?>" height="100%" width="100%">
                        <h4><?php echo $game['title']; ?></h4>
                        <p><?php echo $game['description']; ?></p>
                        <p>Nb d'heure max: <?php echo $game['game_time']; ?></p>
                        <p>Date de sortie: <?php echo $game['released_date']; ?></p>

                    </div><!-- Fin de la div col-md-3 Game 1-->
                <?php endforeach; ?>

            <?php else: ?>
                <div class="alert alert-danger" role="alert">Aucun jeu dispo dans notre base de données</div>

            <?php endif; ?>

        </div><!-- Fin du row 2-->

    </div><!-- Fin du container Games-->

    <div = "container"> 
        <div class="row" id="row3"></div>
            <div class=".col-xs-6 .col-md-4">   
                <ul class="pagination" id="paginationCatalogue">
                    <!-- 8. Mettre la pagination suivante > et précédente > -->
                    <?php if($pageActiveGame > 1): ?>
                        <li><a href="catalogue.php?page=<?php echo $pageActiveGame - 1; ?>"><</a></li>
                    <?php endif; ?>

                    <!-- 3. Construire la pagination pour n nombre de page $pageGames -->
                    <?php for($i=1; $i <= $pagesGames; $i++): ?> 
                        <li class="<?php if($pageActiveGame == $i) echo 'active'; ?>"><a href="catalogue.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>

                    <?php if($pageActiveGame < $pagesGames): ?>
                        <li><a href="catalogue.php?page=<?php echo $pageActiveGame + 1; ?>">></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div><!-- Fin du container Pagination-->




</div><!-- Fin de la Row1-->



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
