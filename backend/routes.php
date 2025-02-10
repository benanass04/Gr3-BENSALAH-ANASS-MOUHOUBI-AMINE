<?php

    require_once(__DIR__.'/router.php');

    require 'config.php';
    require './src/controllers/ActivitiesController.php';

    //Pour retourner tous les activites
    get('/api/activities', function(){
       ActivitiesController::getAllActivities();
    });

    
?>
