<?php
    require_once 'config.php';

    $msgErreur = "";
    $prenom = "";
    $nom = "";
    $username = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        try{
            $prenom = $_POST['first-name'];
            $nom = $_POST['last-name'];
            $username = $_POST['username'];
            // $email = $_POST['courriel'];
            $motDePasse1 = $_POST['password'];
            $motDePasse2 = $_POST['password2'];

            // Verifier si les champs sont vide
            if(empty($prenom) || empty($nom) || empty($username) || empty($motDePasse1) || empty($motDePasse2)){
                throw new Exception("Veuillez remplir tous les champs");
            }

            // Verifier si le username est deja utilise
            $sqlCommandeUsername = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sqlCommandeUsername);
            $stmt->execute(['username' => $username]);
            if($stmt->fetchColumn() > 0){
                throw new Exception("Username déjà utilisé");
            }

            // Verifier si les deux mot de passe sont correcte
            if($motDePasse1 != $motDePasse2){
                throw new Exception("Les mots de passe ne correspondent pas");
            }

            // Verifier si les mots de passes ont minimums 8 characteres
            if(strlen($motDePasse1) < 8 || strlen($motDePasse2) < 8){
                throw new Exception("Le mot de passe doit avoir minimum 8 charactères");
            }

            $sqlCommande = "INSERT INTO users (first_name, last_name, username, password) VALUES (:first_name, :last_name, :username, :password)";
            $stmt = $pdo->prepare($sqlCommande);
            $stmt->execute([
                'first_name' => htmlspecialchars($prenom),
                'last_name' => htmlspecialchars($nom),
                'username' => htmlspecialchars($username),
                'password' => password_hash($motDePasse1, PASSWORD_DEFAULT),
            ]);

            header("Location: login.php");
            exit;

        }
        catch(Exception $e){
            $msgErreur = $e->getMessage();
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./resources/css/normalize.css">
        <link rel="stylesheet" href="./resources/css/register.css">
        <title>Centre sportif DN</title>
    </head>
    <body>
        <!-- ========== HEADER ============== -->
        <header class="header">

            <div class="div-logo">
                <img class="logo" src="./resources/images/logo.png">
            </div>

        </header>
        <!-- ========== /HEADER ============== -->
        
        <!-- ========== MAIN ============== -->

        <!-- Prenom, nom, username, mot de passe1, mot de passe2 -->

        <main class="main">

            <div class="container">

            <h2>
                Créer un compte
            </h2>

            <?php if(!empty($msgErreur)) : ?>

                <div class="erreurs"><?= htmlspecialchars($msgErreur); ?></div>

            <?php endif; ?>

            <form method="post" class="formulaire">

                <div class="form-group">
                    <label for="first-name">Prénom:</label>
                    <input
                    type="text"
                    id="first-name"
                    name="first-name"
                    class="form-control"
                    required
                    value = "<?= htmlspecialchars($prenom) ?? ''?>"
                    />
                </div>

                <div class="form-group">
                    <label for="last-name">Nom de famille:</label>
                    <input
                    type="text"
                    id="last-name"
                    name="last-name"
                    class="form-control"
                    required
                    value = "<?= htmlspecialchars($nom) ?? ''?>"
                    />
                </div>

                <div class="form-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    required
                    value = "<?= htmlspecialchars($username) ?? ''?>"
                    />
                </div>

                <!-- <div class="form-group">
                    <label for="email">Courriel:</label>
                    <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    required
                    />
                </div> -->

                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                    />
                </div>

                <div class="form-group">
                    <label for="password2">Confirmer mot de passe:</label>
                    <input
                    type="password"
                    id="password2"
                    name="password2"
                    class="form-control"
                    required
                    />
                </div>

                <button type="submit" class="btn btn-primary">S'inscrire</button>

            </form>

            <p>Vous avez déjà un compte? Connectez-vous <a href="login.php">ici</a>.</p>
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