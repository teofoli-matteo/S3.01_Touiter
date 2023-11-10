<?php

namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class ProfileAction {
    public function execute(): string {
        $idUser = $_COOKIE['user_id'];
        if (!isset($_COOKIE['user_id'])) {
            return "Veuillez vous connecter pour voir votre profil.";
        }

        try {
            $pdo = connexionFactory::makeConnection();

            // Récupérer les touites de l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM touite WHERE idUser = :idUser ORDER BY dateTouite DESC");
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();

            $myTouites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les touites des personnes que l'utilisateur suit
            $stmt = $pdo->prepare("SELECT t.* FROM touite t
                                    JOIN user_followers uf ON t.idUser = uf.idUser
                                    WHERE uf.followerId = :idUser
                                    ORDER BY dateTouite DESC");
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();

            $followedTouites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les touites mentionnant un tag auquel l'utilisateur est abonné
            $stmt = $pdo->prepare("SELECT t.* FROM touite t
                                    JOIN listetouites_tag ltt ON t.idTouite = ltt.idTouite
                                    JOIN user_tag ut ON ltt.idTag = ut.idTag
                                    WHERE ut.idUser = :idUser
                                    ORDER BY dateTouite DESC");
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();

            $taggedTouites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $scoreAction = new CalculerScoreMoyenAction();
            $averageScore = $scoreAction->execute();

            // specifier le chemin vers le fichier css
            $html = '<h1>Mon profil</h1>';
            $html .= '<a href="index.php?action=followers" class="followers-button">Mes Abonnés</a>';
            $html .= '<a href="index.php?action=tweetForm"><img src="img/toui.png" alt="Touiter"></a>';

            $html .= '<h2>Score moyen</h2>';
            $html .= '<div class="score">';
            $html .= '<p>' . $averageScore . '</p>';
            $html .= '</div>';

            $html .= '<h2>Mes Touites</h2><ul>';
            foreach ($myTouites as $touite) {
                $html .= '<li>';
                $html .= '<strong>' . htmlspecialchars($touite['idUser']) . '</strong>';
                $html .= '<p>' . htmlspecialchars($touite['message']) . '</p>';
                $html .= '<small>' . htmlspecialchars($touite['dateTouite']) . '</small>';
                $html .= '<form class="redbutton" method="post" action="index.php?action=delete-tweet">';
                $html .= '<input type="hidden" name="idTouite" value="' . htmlspecialchars($touite['idTouite']) . '">';
                $html .= '<input type="submit" value="Supprimer">';
                $html .= '</form>';
                $html .= '</li>';
            }
            $html .= '</ul>';

            $html .= '<h2>Touites des personnes que je suis</h2><ul>';
            foreach ($followedTouites as $touite) {
                $html .= '<li>';
                $html .= '<strong>' . htmlspecialchars($touite['idUser']) . '</strong>';
                $html .= '<p>' . htmlspecialchars($touite['message']) . '</p>';
                $html .= '<small>' . htmlspecialchars($touite['dateTouite']) . '</small>';
                $html .= '</li>';
            }
            $html .= '</ul>';

            $html .= '<h2>Touites contenant les tags auxquels je suis abonné</h2><ul>';
            foreach ($taggedTouites as $touite) {
                $html .= '<li>';
                $html .= '<strong>' . htmlspecialchars($touite['idUser']) . '</strong>';
                $html .= '<p>' . htmlspecialchars($touite['message']) . '</p>';
                $html .= '<small>' . htmlspecialchars($touite['dateTouite']) . '</small>';
                $html .= '</li>';
            }
            $html .= '<a href="menu.php" class="back-button">Retour au menu</a>';

            $html .= '</ul>';
            $html .= '<script>
                        // JavaScript pour actualiser la page après la suppression dun touite
                        function refreshPage() {
                        location.reload(true);
                        }
                        </script>';

            return $html;
        } catch (PDOException $e) {
            return "Erreur lors de la récupération des touites: " . $e->getMessage();
        }
    }
}
?>

<link rel="stylesheet" href="css/sections.css">