<?php

    session_start();

    require_once(__DIR__.'/config/db.php');
    require_once(__DIR__.'/functions.php');


    checkLoggedIn();
    checkAdmin();

    $pageActive = 'admin';

    //Ici on va faire afficher la liste des utilisateurs
    $query = $pdo->query('SELECT COUNT(*) AS total FROM users');
    $countUsers = $query->fetch();
    $totalUsers = $countUsers['total'];



    $limitUsers=100;

    $pageUsers = ceil($totalUsers / $limitUsers);



    if (isset($_GET['page'])) {
        $pageActiveUser = $_GET['page'];
    }
    else{
        $pageActiveUser = 1;
    }

    $offsetUser = ($pageActiveUser - 1 ) * $limitUsers;

    $query = $pdo->prepare('SELECT * FROM users LIMIT :limit OFFSET :offset');  
    $query->bindValue(':limit', $limitUsers, PDO::PARAM_INT);
    $query->bindValue(':offset', $offsetUser, PDO::PARAM_INT);
    $query->execute();

    $users = $query->fetchAll();

    $prcentUser = ceil ((($offsetUser+1) / $totalUsers) * 100) + 1;

?>



<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Admnistrateur</title>
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
        <h1>Administration</h1>


      </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-md-12">

                
            </div>
            
        </div>




        <div class="row">

            <div class="col-md-12" id="tableUsers">

            <h2>Utilisateurs inscrits</h2>
            <hr/>

            <div class="alert alert-info">
                <p>Id des utilisateurs du <?php echo $offsetUser +1 ?> au <?php echo $offsetUser + $limitUsers - 1 ?> sur un total de <?php echo $totalUsers ?> utilisateurs</p>
                <br>    
            

                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $prcentUser?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $prcentUser ?>%">
                        <p><?php echo $prcentUser ?>%   </p>
                    </div>
                </div>
            </div>

                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Tel.</th>
                        <th>Role</th>
                        <th>Membre depuis</th>

                    </tr>

                    <?php foreach ($users as $keyUsers => $user) : ?>
                    <tr>
                        <td><?php echo $user['id'];?></td>
                        <td><?php echo $user['firstname'];?></td>
                        <td><?php echo $user['name'];?></td>
                        <td><?php echo $user['email'];?></td>
                        <td><?php echo $user['address']." ".$user['city']." ".$user['zipcode'] ;?></td>
                        <td><?php echo $user['tel'];?></td>
                        <td><?php echo $user['role'];?></td>
                        <td><?php echo $user['created_at'];?></td>
                    </tr>
                    <?php endforeach; ?>

                </table>

                    <ul class="pagination">

                        <?php if($pageActiveUser > 1) : ?>
                                <li> <a href="index.php?page=<?php echo $pageActiveUser - 1 ; ?>"><</a></li>
                        <?php endif ; ?>


                        <?php for($i=1 ; $i <= $pageUsers ; $i++): ?>
                                <li class="<?php if($pageActiveUser == $i) echo 'active' ?>"> <a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>

                        <?php if($pageActiveUser < $pageUsers ): ?>
                                <li> <a href="index.php?page=<?php echo $pageActiveUser + 1 ; ?>">></a></li>
                        <?php endif ; ?>        

                    </ul>
            </div>

            <div class="col-md-2">
                
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
