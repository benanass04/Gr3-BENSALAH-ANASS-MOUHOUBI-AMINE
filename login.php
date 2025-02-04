<?php
    require_once 'config.php';

    session_start();

    $msgErreur = "";
    $username = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        try{
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Verifier si les inputs sont vide
            if(empty($username) || empty($password)){
                throw new Exception("Veuillez remplir tous les champs");
            }

            // Verifier si l'utilisateur se trouve dans la base de donnee
            $sqlCommandeUser = "SELECT id, first_name, last_name, username, password FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sqlCommandeUser);
            $stmt->execute(['username' => $username]);
            $utilisateur = $stmt->fetch();

            if(!$utilisateur){
                throw new Exception("Cet utilisateur n'existe pas");
            }

            // Verifier le password
            if(!password_verify($password, $utilisateur['password'])){
                throw new Exception("Mot de passe invalide");
            }

            $_SESSION['usager'] = [
                'id' => $utilisateur['id'],
                'first_name' => $utilisateur['first_name'],
                'last_name' => $utilisateur['last_name'],
                'username' => $utilisateur['username']
            ];

            header("Location: index.php");
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
        <link rel="stylesheet" href="./resources/css/login.css">
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

        <!-- Prenom, nom, username, email, mot de passe -->

        <main class="main">

            <div class="container">
                <h2>
                    Connexion
                </h2>

                <?php if(!empty($msgErreur)) : ?>

                    <div class="erreurs"><?= htmlspecialchars($msgErreur); ?></div>

                <?php endif; ?>

                <form method="post" class="formulaire">

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

                    <button type="submit" class="btn btn-primary">Se connecter</button>

                </form>

                <p>Vous êtes nouveau? Créer un compte <a href="register.php">ici</a>.</p>
                
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