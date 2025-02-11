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

    // Fix this function pls
    public static function getInfoActivity($id){
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try{
            $sqlInfo = 'SELECT * FROM activities WHERE id = :id';
            $stmt = $pdo->prepare($sqlInfo);
            $stmt->execute(['id' => $id]);
            $informations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($informations);
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

    public static function getFiltredActivities() {
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        // Récupérer les paramètres GET envoyés par le frontend
        $level = $_GET['level'] ?? null;
        $lieu = $_GET['location'] ?? null;
        $coach = $_GET['coach'] ?? null;

        try {
            // Construire la requête SQL avec WHERE 1=1
            $sqlCommande = "SELECT a.*
                            FROM activities a
                            JOIN coaches c ON a.coach_id = c.id
                            JOIN levels l ON a.level_id = l.id
                            JOIN locations loc ON a.location_id = loc.id
                            WHERE 1=1";

            $paramsQuery = [];

            // Ajout des filtres dynamiquement
            if (!empty($coach)) {
                $sqlCommande .= " AND c.name = :coach";
                $paramsQuery['coach'] = $coach;
            }
            if (!empty($level)) {
                $sqlCommande .= " AND l.name = :level";
                $paramsQuery['level'] = $level;
            }
            if (!empty($lieu)) {
                $sqlCommande .= " AND loc.name = :location";
                $paramsQuery['location'] = $lieu;
            }

            // Préparer et exécuter la requête
            $stmt = $pdo->prepare($sqlCommande);
            $stmt->execute($paramsQuery);
            $filtredActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retourner la réponse en JSON
            echo json_encode($filtredActivities);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function updateActivity($id) {
        global $pdo;
        header('Content-Type: application/json');
    
        try {
            // Récupérer les données envoyées par le frontend
            $data = json_decode(file_get_contents("php://input"), true);
    
            // Préparer la requête SQL
            $sql = "UPDATE activities SET 
                        name = :name, 
                        description = :description, 
                        image = :image, 
                        level_id = :level_id, 
                        location_id = :location_id, 
                        coach_id = :coach_id 
                    WHERE id = :id";
    
            $stmt = $pdo->prepare($sql);
    
            // Exécuter la requête avec les valeurs reçues
            $stmt->execute([
                ':name' => $data['name'],
                ':description' => $data['description'],
                ':image' => $data['image'],
                ':level_id' => $data['level_id'],
                ':location_id' => $data['location_id'],
                ':coach_id' => $data['coach_id'],
                ':id' => $id
            ]);
    
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    

}

?>