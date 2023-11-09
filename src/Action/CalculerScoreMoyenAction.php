<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class CalculerScoreMoyenAction extends Action {
    public function execute(): string {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $db = connexionFactory::makeConnection();


            // Récupérer les likes et dislikes de tous les tweets de l'utilisateur connecté
            $stmt = $db->prepare("SELECT nbLike, nbDislike FROM Touite WHERE idUser = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialiser les compteurs
            $totalLikes = 0;
            $totalDislikes = 0;

            // Calculer les totaux
            foreach ($scores as $score) {
                $totalLike += $score['nbLike'];
                $totalDislike += $score['nbDislike'];
            }

            // Calculer le score moyen
            $averageScore = $totalLike - $totalDislike;

            return "Le score moyen de vos tweets est : " . $averageScore;
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers le menu
            echo "Vous n'êtes pas connecté";
            header("Location: /menu.php");
            exit();
        }
    }
}
?>
