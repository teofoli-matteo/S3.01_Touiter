<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class ShowFollowers extends Action {
    public function execute(): string {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $db = connexionFactory::makeConnection();

            $stmt = $db->prepare("SELECT followerId as user_id FROM user_followers WHERE idUser = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $followers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $followerNames = [];
            foreach ($followers as $follower) {
                $stmt = $db->prepare("SELECT idUser as user_id FROM users WHERE idUser = :user_id");
                $stmt->bindParam(':user_id', $follower['user_id'], PDO::PARAM_STR);
                $stmt->execute();
                $followerName = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];
                $followerNames[] = $followerName;
            }

            ob_start();
            // Stocker le contenu dans la variable $htmlContent au lieu d'utiliser echo
            $htmlContent = '<div class="followers-container">';
            $htmlContent .= "<h2>Mes Followers :</h2>";
            $htmlContent .= "<ul class='followers-list'>";
            foreach ($followerNames as $followerName) {
                $htmlContent .= "<li>{$followerName}</li>";
            }
            $htmlContent .= "</ul>";
            $htmlContent .= '<a href="menu.php" class="back-button">Retour au menu</a>';
            $htmlContent .= '</div>';

            // Récupérer et effacer le contenu du tampon
            return $htmlContent;
        } else {
            echo "Vous n'êtes pas connecté";
            header("Location: /menu.php");
            exit();
        }
    }
}
?>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background-color: grey;
        color: #1c1e21;
    }

    .followers-container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff; /* Fond de la boîte des followers */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: black;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .followers-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .followers-list li {
        background-color: #f5f8fa; /* Une nuance de gris similaire à Twitter */
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .back-button {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #666;
    }
</style>

