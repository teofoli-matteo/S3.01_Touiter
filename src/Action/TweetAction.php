<?php

namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class TweetAction {
    public function execute(): string {
        session_start();

        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: /login.php");
            exit();
        }

        // Récupère l'id de l'utilisateur connecté
        $idUser = $_SESSION['user_id'];

        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
            // Récupère le message du tweet depuis le formulaire
            $message = $_POST['message'];

            // Connexion à la base de données
            $db = connexionFactory::makeConnection();

            // Requête SQL pour insérer le nouveau tweet dans la base de données
            $sql = "INSERT INTO Touite (idUser, dateTouite, message) VALUES (:idUser, NOW(), :message)";

            // Prépare la requête SQL
            $stmt = $db->prepare($sql);

            // Lie les valeurs aux paramètres de la requête
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);

            // Exécute la requête SQL
            $stmt->execute();

            // Redirige vers la page principale après l'ajout du tweet
            header("Location: /index.php");
            exit();
        }

        // Si le formulaire n'a pas été soumis, retourne une chaîne vide
        return '';
    }
}
