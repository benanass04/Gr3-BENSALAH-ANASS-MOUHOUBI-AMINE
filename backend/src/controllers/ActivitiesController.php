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

    public static function get4RandomActivities(){
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try{
            $stmt = $pdo->query('SELECT * FROM activities ORDER BY RAND() LIMIT 4');
            $popularActivities = $stmt->fetchAll();
            echo json_encode($popularActivities);
        }
        catch (PDOException $e){
            http_response_code(500);
            echo json_encode (['error' => $e->getMessage()]);
        }
    }

    public static function getLocations(){
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try{
            $stmt = $pdo->query('SELECT * FROM locations');
            $locations = $stmt->fetchAll();
            echo json_encode($locations);
        }
        catch(PDOException $e){
            http_response_code(500);
            echo json_encode (['error' => $e->getMessage()]);
        }
    }

    public static function getCoaches(){
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try{
            $stmt = $pdo->query('SELECT * FROM coaches');
            $coaches = $stmt->fetchAll();
            echo json_encode($coaches);
        }
        catch(PDOException $e){
            http_response_code(500);
            echo json_encode (['error' => $e->getMessage()]);
        }
    }

    public static function getNiveaux(){
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try{
            $stmt = $pdo->query('SELECT * FROM levels');
            $levels = $stmt->fetchAll();
            echo json_encode($levels);
        }
        catch(PDOException $e){
            http_response_code(500);
            echo json_encode (['error' => $e->getMessage()]);
        }
    }

    public static function getFiltredActivities($filters) {
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        // Construire la requête SQL de base
        $sql = "SELECT * FROM activities WHERE 1=1";

        // Ajouter les filtres dynamiquement
        $params = [];
        if (!empty($filters['coach'])) {
            $sql .= " AND coach_id = :coach";
            $params['coach'] = $filters['coach'];
        }
        if (!empty($filters['level'])) {
            $sql .= " AND level_id = :level";
            $params['level'] = $filters['level'];
        }
        if (!empty($filters['location'])) {
            $sql .= " AND location_id = :location";
            $params['location'] = $filters['location'];
        }

        // Préparer et exécuter la requête SQL
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Récupérer les résultats
        $activities = $stmt->fetchAll();

        // Retourner les données en JSON
        header('Content-Type: application/json');
        echo json_encode($activities);
    }

    public static function addActivity() {
        global $pdo;
    
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
    
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Vérifier si tous les champs sont présents
        if (!isset($data["name"], $data["description"], $data["image"], $data["level_id"], $data["coach_id"], $data["schedule_day"], $data["schedule_time"], $data["location_id"])) {
            http_response_code(400);
            echo json_encode(["error" => "Tous les champs sont obligatoires."]);
            return;
        }
    
        try {
            $sql = "INSERT INTO activities (name, description, image, level_id, coach_id, schedule_day, schedule_time, location_id) 
                    VALUES (:name, :description, :image, :level_id, :coach_id, :schedule_day, :schedule_time, :location_id)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":name" => $data["name"],
                ":description" => $data["description"],
                ":image" => $data["image"],
                ":level_id" => $data["level_id"],
                ":coach_id" => $data["coach_id"],
                ":schedule_day" => $data["schedule_day"],
                ":schedule_time" => $data["schedule_time"],
                ":location_id" => $data["location_id"]
            ]);
    
            http_response_code(201);
            echo json_encode(["message" => "Activité ajoutée avec succès"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    public static function modifyActivity($id) {
        global $pdo;
    
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: PUT, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json; charset=utf-8');
        
        $data = json_decode(file_get_contents("php://input"), true);
        
        try {
            $sql = "UPDATE activities 
                    SET name = :name, description = :description, image = :image, 
                        level_id = :level_id, coach_id = :coach_id, 
                        schedule_day = :schedule_day, schedule_time = :schedule_time, 
                        location_id = :location_id 
                    WHERE id = :id";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":id" => intval($id),
                ":name" => $data["name"],
                ":description" => $data["description"],
                ":image" => $data["image"],
                ":level_id" => intval($data["level_id"]),
                ":coach_id" => intval($data["coach_id"]),
                ":schedule_day" => $data["schedule_day"],
                ":schedule_time" => $data["schedule_time"],
                ":location_id" => intval($data["location_id"])
            ]);
    
            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(["message" => "Activité mise à jour avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Activité non trouvée ou aucune modification apportée"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    
}
    


?>