<?php
    require_once 'config.php';

    // Vérifier si un ID est présent dans l'URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $idActivite = $_GET['id'];

        // Récupérer les données de l'activité
        $sql = "SELECT * FROM activities WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $idActivite]);
        $activite = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'activité existe
        if (!$activite) {
            die("Erreur : Activité introuvable !");
        }
    } else {
        // Si aucun ID, on considère que c'est une nouvelle activité
        $activite = [
            'name' => '',
            'description' => '',
            'image' => '',
            'level_id' => '',
            'location_id' => '',
            'coach_id' => '',
            'schedule_day' => ''
        ];
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="./resources/css/normalize.css">
        <link rel="stylesheet" href="./resources/css/modifOuAjout.css">
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

        <!-- ========== MAIN ============== -->
        <main class="main">

            <div class="container">
                <h2>Modification de l'activité</h2>
                <form class="formulaire">

                    <label>Nom de l'activité :</label>
                    <input class="nomActivite" type="text">

                    <label>Description :</label>
                    <textarea class="descActivite" type="text"></textarea>

                    <label>Image URL :</label>
                    <input class="imgActivite" type="text">

                    <label>Niveau :</label>
                    <select class="niveauDiff" id="niveauDiff">
                        <option value="Tous niveaux">Tous niveaux</option>
                        <option value="Debutant">Débutant</option>
                        <option value="Intermediaire">Intérmediaire</option>
                        <option value="Avance">Avancé</option>
                    </select>
                    
                    <label>Lieu :</label>
                    <select class="lieu" id="lieu">
                        <option value="Intérieur">Intérieur</option>
                        <option value="Extérieur">Extérieur</option>
                    </select>

                    <label>Coach :</label>
                    <select class="coachDiff" id="coachDiff">
                        <option value="Martin">Martin</option>
                        <option value="Simone">Simone</option>
                        <option value="Pierre">Pierre</option>
                    </select>

                    <label>Jour :</label>
                    <select class="jourDiff" id="jourDiff">
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select>

                </form>

                <button class="enregistrer">Enregistrer</button>
            </div>

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