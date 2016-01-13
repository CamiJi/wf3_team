<?php

// FONCTION LOG IN && ADMIN

		function checkLoggedIn(){
			if (empty($_SESSION['user'])) {
				header("Location: connexion.php");
				die();
			}
		}

		function checkAdmin(){
			if($_SESSION['user']['role'] != 'admin') {
		  		header("HTTP/1.0 403 Forbidden");
		  		die('Cette page est réservé aux administreurs');
		  	}
		}












// ***********************************************************************************************
// ***********************************************************************************************
// FONCTION GEOLOCALISATION

	// pour enregistrer en BDD :
	// champs lat: DECIMAL(10,8)
	// champs longitude: DECIMAL(11.8)

	function geocode($address){ 

	// Url de l'appli http://maps.google.com/maps/api/geocode/json?address=

	// Encodage de l'adresse pour la soumettre sur l'url par la suite
	$address = urlencode($address);

	// Url de l'API pour geocoder
	// 'http://maps.google.com/mpas/api/geocode/json?address='.$address
	$urlApi = "http://maps.google.com/maps/api/geocode/json?address=$address";

	// Appel de l'API gmap decode (en GET - reponse en JSON)
	$reponseJson = file_get_contents($urlApi);

	// Décodage du Json pour le transformer en array php associatif (2e parametre à true)
	$reponseArray = json_decode($reponseJson, true);

// 	echo '<pre>';
// 	print_r($reponseArray);
// 	echo '</pre>';

	// On prepare un tableau associatif comm réponse de cette fonction
	$reponse = [];

	// je test le statu de reponse à Ok (sinon cela signifie qu'il n'a pas de correspondance)
	if($reponseArray['status'] == 'OK') {
		$lat = $reponseArray['results'][0]['geometry']['location']['lat'];
		$lng = $reponseArray['results'][0]['geometry']['location']['lng'];

		// test les valeurs (pas indispensable)
		if($lat && $lng) {
		$reponse['lat'] = $lat;
		$reponse['lng'] = $lng;
		}
	}

	return $reponse;


}





?>