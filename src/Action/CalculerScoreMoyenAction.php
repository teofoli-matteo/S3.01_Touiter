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
            if ($totalLike == $totalDislike)
            $averageScore = 0;
            else if ($totalDislike == 0)
                $averageScore = $totalLike;
            else if ($totalLike == 0)
                $averageScore = -$totalDislike;
            else if ($totalLike > $totalDislike)
                $averageScore = $totalLike - $totalDislike;
            else if ($totalLike < $totalDislike)
                $averageScore = $totalLike - $totalDislike;

            return "Le score moyen de mes touites est : " . $averageScore;
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers le menu
            // alerte d'erreur comme quoi l'on est pas connecté et redirection vers le menu
            echo '<script>
                    window.location.href = "index.php?action=menu";
                    alert("Vous devez être connecté pour accéder à cette page !");
                </script>';
            exit();
        }
    }
}
?>
