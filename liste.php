<?php
    require_once 'config.php';

    session_start();

    if(!isset($_SESSION['usager'])){
        header("Location: login.php");
        exit;
    }

    // Trouver tous les niveaux
    $sqlCommandeNiveaux = "SELECT * FROM levels";
    $stmt = $pdo->prepare($sqlCommandeNiveaux);
    $stmt->execute();
    $niveaux = $stmt->fetchAll();

    // Trouver le nombre de niveaux
    $sqlCommandeNombreNiveau = "SELECT COUNT(*) FROM levels";
    $stmt = $pdo->prepare($sqlCommandeNombreNiveau);
    $stmt->execute();
    $nombreNiveau = $stmt->fetchColumn();

    // Trouver tous les locations
    $sqlCommandeLieux = "SELECT * FROM locations";
    $stmt = $pdo->prepare($sqlCommandeLieux);
    $stmt->execute();
    $lieux = $stmt->fetchAll();

    // Trouver le nombre de locations
    $sqlCommandeNombreLieu = "SELECT COUNT(*) FROM locations";
    $stmt = $pdo->prepare($sqlCommandeNombreLieu);
    $stmt->execute();
    $nombreLieu = $stmt->fetchColumn();

    // Trouver tous les coachs
    $sqlCommandeCoachs = "SELECT * FROM coaches";
    $stmt = $pdo->prepare($sqlCommandeCoachs);
    $stmt->execute();
    $coachs = $stmt->fetchAll();

    // Trouver le nombre de coach
    $sqlCommandeNombreCoach = "SELECT COUNT(*) FROM coaches";
    $stmt = $pdo->prepare($sqlCommandeNombreCoach);
    $stmt->execute();
    $nombreCoach = $stmt->fetchColumn();

    // Trouver tous les jours
    $sqlCommandeJours = "SELECT DISTINCT schedule_day FROM activities";
    $stmt = $pdo->prepare($sqlCommandeJours);
    $stmt->execute();
    $jours = $stmt->fetchAll();

    // Trouver le nombre de jour
    $nombreJour = count($jours);

    // // Pour les filtres on va utiliser les values
    // if($_SERVER["REQUEST_METHOD"] == "POST"){
    //     $niveauFiltre = $_POST['niveau'] ?? ''; 
    //     $lieuFiltre = $_POST['lieu'] ?? '';
    //     $coachFiltre = $_POST['coach'] ?? '';
    //     $jourFiltre = $_POST['jour'] ?? '';

    // }

    // Récupération des filtres depuis le formulaire
$niveauFiltre = $_POST['niveau'] ?? ''; 
$lieuFiltre = $_POST['lieu'] ?? '';
$coachFiltre = $_POST['coach'] ?? '';
$jourFiltre = $_POST['jour'] ?? '';

// Construire la requête SQL avec les filtres
$sqlActivites = "SELECT a.*, l.name as lieu, c.name as coach, lv.name as niveau 
                 FROM activities a
                 LEFT JOIN locations l ON a.location_id = l.id
                 LEFT JOIN coaches c ON a.coach_id = c.id
                 LEFT JOIN levels lv ON a.level_id = lv.id
                 WHERE 1"; // WHERE 1 pour permettre d'ajouter dynamiquement des conditions

$params = [];

// Appliquer les filtres seulement si des valeurs sont sélectionnées
if (!empty($niveauFiltre)) {
    $sqlActivites .= " AND a.level_id = :niveau";
    $params['niveau'] = $niveauFiltre;
}

if (!empty($lieuFiltre)) {
    $sqlActivites .= " AND a.location_id = :lieu";
    $params['lieu'] = $lieuFiltre;
}

if (!empty($coachFiltre)) {
    $sqlActivites .= " AND a.coach_id = :coach";
    $params['coach'] = $coachFiltre;
}

if (!empty($jourFiltre)) {
    $sqlActivites .= " AND a.schedule_day = :jour";
    $params['jour'] = $jourFiltre;
}

// Exécuter la commande
$stmt = $pdo->prepare($sqlActivites);
$stmt->execute($params);
$activites = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="./resources/css/normalize.css">
        <link rel="stylesheet" href="./resources/css/liste.css">
        <!-- <script src="./resources/javascript/data.js" defer></script> -->
        <title>Centre sportif DN</title>
    </head>
    <body>
        
        <!-- ========== HEADER ============== -->
        <header class="header">

            <div class="div-logo">
                <img class="logo" src="./resources/images/logo.png">
            </div>

            <nav>
                <div class="menu-bouton">
                    <a href="index.php">
                        <p>MENU</p>
                    </a>
                </div>

                <div class="liste-bouton">
                    <a href="liste.php">
                        <p>TOUS NOS ACTIVITÉS</p>
                    </a>
                </div>

                <div class="ajout-bouton">
                    <a href="modifOuAjout.php">
                        <p>AJOUTER UNE ACTIVITÉ</p>
                    </a>
                </div>

                <div class="deconnexion-bouton">
                    <a href="logout.php">
                        <p>SE DÉCONNECTER</p>
                    </a>
                </div>

            </nav>

        </header>
        <!-- ========== /HEADER ============== -->

        <!-- ========== FILTREUR ============== -->
        <header class="filter">

            <h3>Filtrer les activités</h3>
                <!-- Exemple de filtre -->
                <!-- <div class="filtre">
                    <label>Niveau: </label>
                    <select class="niveauDiff">
                        <option>Tous niveaux</option>
                        <option>Débutant</option>
                        <option>Intermédiaire</option>
                        <option>Avancé</option>
                    </select>
                </div> -->

                <form method="POST" action="liste.php" class="blockFilter">
                    <div class="filtre">
                        <label>Niveau: </label>
                        <select name="niveau" class="niveauDiff">
                            <option value="">Tous les niveaux</option>
                            <?php for($i = 0; $i < $nombreNiveau; $i++):
                                $niveau =  $niveaux[$i]; ?>
                                <option value="<?= htmlspecialchars($niveau['id']); ?>">
                                    <?= htmlspecialchars($niveau['name']); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="filtre">
                        <label>Lieu: </label>
                        <select name="lieu" class="lieuDiff">
                            <option value="">Tous les lieux</option>
                            <?php for($i = 0; $i < $nombreLieu; $i++):
                                $lieu =  $lieux[$i]; ?>
                                <option value="<?= htmlspecialchars($lieu['id']); ?>">
                                    <?= htmlspecialchars($lieu['name']); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="filtre">
                        <label>Entraîneur: </label>
                        <select name="coach" class="coachDiff">
                            <option value="">Tous les coachs</option>
                            <?php for($i = 0; $i < $nombreCoach; $i++):
                                $coach =  $coachs[$i]; ?>
                                <option value="<?= htmlspecialchars($coach['id']); ?>">
                                    <?= htmlspecialchars($coach['name']); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="filtre">
                        <label>Jours: </label>
                        <select name="jour" class="jourDiff">
                            <option value="">Tous les jours</option>
                            <?php for($i = 0; $i < $nombreJour; $i++):
                                $jour =  $jours[$i]['schedule_day']; ?>
                                <option value="<?= htmlspecialchars($jour); ?>">
                                    <?= htmlspecialchars($jour); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <button type="submit" id="appliquerFiltres">Appliquer</button>
                </form>

            

        </header>
        <!-- ========== /FILTREUR ============== -->

        <!-- ========== MAIN ============== -->
        <main class="main">


            <div class="liste">
                <!-- Exemple de bloc activite -->
                <!-- <div>
                    <img src="./resources/images/football.png" class="image-sport">
                    <div class="description">
                        <h3>Football</h3>
                        <p>Apprends les bases du soccer tout en t’amusant: dribbles, passes et tirs, dans un esprit d’équipe!</p>
                        <p><strong>Horaire: </strong> Samedi</p>
                        <p><strong>Niveau: </strong> Tous niveaux</p>
                        <p><strong>Responsable: </strong> Martin</p>
                        <p><strong>Lieu: </strong> Extérieur</p>
                    </div>
                    <button class="modifier" data-id="1">Modifier l'activité</button>
                </div> -->

                <?php foreach ($activites as $activite): ?>
                    <div>
                        <img src="<?= htmlspecialchars($activite['image']); ?>" class="image-sport">
                        <div class="description">
                            <h3><?= htmlspecialchars($activite['name']); ?></h3>
                            <p><?= htmlspecialchars($activite['description']); ?></p>
                            <p><strong>Horaire :</strong> <?= htmlspecialchars($activite['schedule_day']); ?></p>
                            <p><strong>Niveau :</strong> <?= htmlspecialchars($activite['level_id']); ?></p>
                            <p><strong>Responsable :</strong> <?= htmlspecialchars($activite['coach']); ?></p>
                            <p><strong>Lieu :</strong> <?= htmlspecialchars($activite['lieu']); ?></p>
                        </div>
                        <a href="modifOuAjout.php?id=<?= $activite['id']; ?>">
                            <button class="modifier">Modifier l'activité</button>
                        </a>

                    </div>
                <?php endforeach; ?>
            </div>

            <button class="ajouter">
                Ajouter une activité
            </button>

        </main>
        <!-- ========== /MAIN ============== -->

        <!-- ========== FOOTER ============== -->
        <footer class="footer">

            <div>

                <div>
                    <h4>
                        Nous contacter
                    </h4>
                    <p>
                        Adresse : 123 Rue du Sport, Montréal, QC <br>
                        Téléphone: (123) 456-7890
                    </p>
                </div>

                <div>
                    <h4>Proposer un cours</h4>
                    <p>
                        Joignez notre équipe et contribuez à inspirer le bien-être à travers cos compétences sportifs
                    </p>
                </div>

                <div>
                    <h4>Suivez-nous</h4>
                    <a href="https://www.facebook.com">
                        <img class="lien-footer facebook" src="./resources/images/facebook.png" >
                    </a>

                    <a href="https://www.instagram.com">
                        <img class="lien-footer instagram" src="./resources/images/instagram.png">
                    </a>

                    <a href="https://www.youtube.com">
                        <img class="lien-footer youtube" src="./resources/images/youtube.png">
                    </a>

                </div>

            </div>

            <p>
                &copy; Le Centre Sportif DN, tous droits réservés.
            </p>

        </footer>
        <!-- ========== /FOOTER ============== -->
        
    </body>
</html>