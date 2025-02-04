<?php
    session_start();
    session_unset();  
    session_destroy();

    // Redirige vers la page de connexion
    header("Location: login.php");
    exit;
?>