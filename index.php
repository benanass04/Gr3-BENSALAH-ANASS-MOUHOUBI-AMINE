<?php
    require_once 'config.php';

    session_start();

    if(!isset($_SESSION['usager'])){
        header("Location: login.php");
        exit;
    }

    $userFirstName = $_SESSION['usager']['first_name'];

    // Trouver tous les activites
    $sqlCommandePourTousLesActivites = "SELECT * FROM activities";
    $stmt = $pdo->prepare($sqlCommandePourTousLesActivites);
    $stmt->execute();
    $activites = $stmt->fetchAll();

    // On va afficher juste 4 activites
    $nombreActivites = 4;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./resources/css/normalize.css">
        <link rel="stylesheet" href="./resources/css/index.css">
        <!-- <script src="./resources/javascript/data.js" defer></script> -->
        <title>Centre sportif DN</title>
    </head>
    <body class="conteneur">

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

            <h2>Bienvenue au Centre Sportif DN, <?= $userFirstName ?>!</h2>

            <p class="description">
                Ici, ça bouge, ça transpire, ça s'amuse, et surtout, ça se sent bien ! <br>
                Venez découvrir nos activités pour rester en forme, améliorer votre santé et repartir avec le plein d'énergie. <br>
                <strong>CENTRE SPORTIF DN</strong>, c'est le rendez-vous du bien-être physique et mental.
            </p>

            <h3>Nos activités populaires</h3>

            <div class="grid-container">

                <!-- Exemple d'activite populaire -->
                <!-- <div class="container">
                    <img src="./resources/images/football.png" class="image-sport">
                    <p>
                        Apprends les bases du soccer tout en t’amusant: dribbles, passes et tirs, dans un esprit d’équipe!
                    </p>
                </div> -->
                <?php for($i = 0; $i < $nombreActivites; $i++):
                    $activite = $activites[$i];
                    ?>

                    <div class="container">
                        <img src="<?= htmlspecialchars($activite['image']); ?>" class="image-sport">
                        <p>
                            <?= htmlspecialchars($activite['description']); ?>
                        </p>
                    </div>
                <?php endfor ?>

            </div>

            <div class="div-bouton-plus">
                <a href="liste.php">
                    <button class="bouton-plus">Voir toutes les activités</button>
                </a>
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