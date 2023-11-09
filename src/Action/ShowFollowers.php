<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class ShowFollowers extends Action {
    public function execute(): string {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $db = connexionFactory::makeConnection();

            // Récupérer les followers de l'utilisateur connecté
            $stmt = $db->prepare("SELECT idSuivi FROM abonnement WHERE idSuiveur = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $followers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les noms des utilisateurs qui suivent l'utilisateur connecté
            $followerNames = [];
            foreach ($followers as $follower) {
                $stmt = $db->prepare("SELECT idUser FROM users WHERE idUser = :user_id");
                $stmt->bindParam(':user_id', $follower['user_id'], PDO::PARAM_STR);
                $stmt->execute();
                $followerName = $stmt->fetch(PDO::FETCH_ASSOC)['username'];
                $followerNames[] = $followerName;
            }

            // Afficher les followers
            ob_start();
            echo "<h2>Vos Followers :</h2>";
            echo "<ul>";
            foreach ($followerNames as $followerName) {
                echo "<li>{$followerName}</li>";
            }
            echo "</ul>";
            echo " Les followers sont bien affichés";
            return ob_get_clean();
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers le menu
            echo "Vous n'êtes pas connecté";
            header("Location: /menu.php");
            exit();
        }
    }
}
?>