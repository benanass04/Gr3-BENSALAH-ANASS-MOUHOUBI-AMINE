<?php

class ActivitiesController {

    public static function getAllActivities(){
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {
            $stmt = $pdo->query('SELECT * FROM activities');
            $activities = $stmt->fetchAll();
            echo json_encode($activities);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}

?>