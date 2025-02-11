<?php

    require_once(__DIR__.'/router.php');

    require 'config.php';
    require './src/controllers/ActivitiesController.php';

    // Vérifier si le paramètre n'est pas "filter" avant d'interpréter comme un ID
    get('/api/activities/$param', function($param){
        if ($param === "filter") {
            ActivitiesController::getFiltredActivities($_GET);
        } else {
            ActivitiesController::getInfoActivity($param);
        }
    });

    put('/api/activities/$id', function($id){
        ActivitiesController::updateActivity($id);
    });

    //Pour retourner tous les activites (GET /api/activities)
    get('/api/activities', function(){
       ActivitiesController::getAllActivities();
    });

    // Pour retourner 4 activiter random (GET /api/activities/random)
    get('/api/activities/random', function(){
        ActivitiesController::get4RandomActivities();
    });

    // Pour retourner les lieux (GET /api/locations)
    get('/api/locations', function() {
        ActivitiesController::getLocations();
    });

    // Pour retourner les coaches (GET /api/coaches)
    get('/api/coaches', function(){
        ActivitiesController::getCoaches();
    });

    // Pour retourner les niveaux (GET /api/niveaux)
    get('/api/levels', function(){
        ActivitiesController::getNiveaux();
    });

    

    // route par défaut pour les erreurs 404
    any('/404', function() {
        http_response_code(404);
        echo json_encode(["error" => "route not found"]);
    });
    
?>
