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
            echo '<div class="followers-container">';
            echo "<h2 id='titre-noir'>Mes Followers :</h2>";
            echo "<ul class='followers-list'>";
            foreach ($followerNames as $followerName) {
                echo "<li>{$followerName}</li>";
            }
            echo "</ul>";
            echo '<a href="index.php?action=profileAction" class="back-button">Retour</a>';
            echo '</div>';
            return ob_get_clean();
        } else {
            echo "Vous n'êtes pas connecté";
            header("Location: /menu.php");
            exit();
        }
    }
}
?>

<link rel="stylesheet" href="css/sections.css">