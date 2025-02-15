<?php

    require_once(__DIR__.'/router.php');

    require 'config.php';
    require './src/controllers/ActivitiesController.php';

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

    // Pour modifier les activites (PUT /api/activities/${id})
    put('/api/activities/$id', function($id){
        ActivitiesController::modifyActivity($id);
    });

    // Pour creer une activite
    post('/api/activities', function(){
        ActivitiesController::addActivity();
    });

    // Pour retourner les activites filtrers (GET /api/activities/filter?coach=1&level=3&location=1)
    get('/api/activities/filter', function(){
        ActivitiesController::getFiltredActivities($_GET);
    });

    // route par défaut pour les erreurs 404
    any('/404', function() {
        http_response_code(404);
        echo json_encode(["error" => "route not found"]);
    });
    
?>
