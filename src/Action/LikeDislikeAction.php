<?php

namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class LikeDislikeAction {
    public function execute(): string {
  
        $idUser = $_COOKIE['user_id'];

        if (!isset($idUser)) {
            return "Veuillez vous connecter pour voir votre profil.";
        }

        try {
            $pdo = connexionFactory::makeConnection();

            // Récupère les touites de tous les utilisateurs
            $stmt = $pdo->prepare("SELECT t.*, COUNT(ld.id) AS nbLikes, COUNT(dl.id) AS nbDislikes
                                   FROM touite t
                                   LEFT JOIN likes_dislikes ld ON t.idTouite = ld.idTouite AND ld.action = 1
                                   LEFT JOIN likes_dislikes dl ON t.idTouite = dl.idTouite AND dl.action = 2
                                   GROUP BY t.idTouite
                                   ORDER BY t.dateTouite DESC");

            $stmt->execute();

            $touites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $html = '<h1>Liste des touites à fav</h1><ul>';

            foreach ($touites as $t) {
                $html .= '<li class="tweet">';
                $html .= '<strong>' . htmlspecialchars($t['idUser']) . '</strong>';
                $html .= '<p>' . htmlspecialchars($t['message']) . '</p>';
                $html .= '<small>' . htmlspecialchars($t['dateTouite']) . '</small>';
                $html .= '<p>Likes: ' . htmlspecialchars($t['nbLikes']) . '</p>';
                $html .= '<p>Dislikes: ' . htmlspecialchars($t['nbDislikes']) . '</p>';
                $html .= '<button class="fav-button" data-touite-id="' . htmlspecialchars($t['idTouite']) . '">Fav</button>';
                $html .= '<button class="unfav-button" data-touite-id="' . htmlspecialchars($t['idTouite']) . '">Unfav</button>';
                $html .= '</li>';
            }

            $html .= '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
            $html .= '<script>
                        $(document).ready(function () {
                            $(".fav-button").click(function () {
                                var touiteId = $(this).data("touite-id");
                                handleAction(touiteId, "AddLike");
                            });

                            $(".unfav-button").click(function () {
                                var touiteId = $(this).data("touite-id");
                                handleAction(touiteId, "AddDislike");
                            });

                            function handleAction(touiteId, action) {
                                $.ajax({
                                    type: "POST",
                                    url: "index.php?action=" + action + "&touiteId=" + touiteId,
                                    dataType: "html",
                                    success: function (response) {
                                        // Traitez la réponse HTML ici
                                        alert("Ajout réussie" + response);
                                        document.location.replace("index.php?action=ListeTweets");
                                    },
                                    error: function (xhr, status, error) {
                                        // Gérez les erreurs
                                        alert("Erreur AJAX lors de l\'ajout de " + action.toLowerCase() + ": " + error);
                                    }
                                });
                            }
                        });
                      </script>';

            return $html;
        } catch (\PDOException $e) {
            return '<div class="error-message">Erreur lors de la récupération des touites: ' . $e->getMessage() . '</div>';
        }
    }

    public function addLike(int $touiteId): void {
        $this->performAction($touiteId, 1);
    }

    public function addDislike(int $touiteId): void {
        $this->performAction($touiteId, 2);
    }

public function performAction(int $touiteId, int $action): void {
    $idUser = $_COOKIE['user_id'];

    if (!isset($idUser)) {
        // format HTML (text/html)
        header('Content-Type: text/html');
        echo '<div class="error-message">Utilisateur non connecté</div>';
        exit;
    }

    try {
        $pdo = connexionFactory::makeConnection();

        // Vérifie si l'utilisateur a déjà effectué cette action
        $checkQuery = $pdo->prepare("SELECT id FROM likes_dislikes WHERE idTouite = :touiteId AND idUser = :idUser AND action = :action");
        $checkQuery->bindParam(':touiteId', $touiteId, PDO::PARAM_INT);
        $checkQuery->bindParam(':idUser', $idUser, PDO::PARAM_STR);
        $checkQuery->bindParam(':action', $action, PDO::PARAM_INT);
        $checkQuery->execute();

        if ($checkQuery->rowCount() === 0) {
            // Ajoute l'action
            $insertQuery = $pdo->prepare("INSERT INTO likes_dislikes (idTouite, idUser, action) VALUES (:touiteId, :idUser, :action)");
            $insertQuery->bindParam(':touiteId', $touiteId, PDO::PARAM_INT);
            $insertQuery->bindParam(':idUser', $idUser, PDO::PARAM_STR);
            $insertQuery->bindParam(':action', $action, PDO::PARAM_INT);
            $insertQuery->execute();

            // Mets à le nombre d'actions dans la table Touite
            $updateQuery = $pdo->prepare("UPDATE touite SET nbLikes = nbLikes + :addLike, nbDislikes = nbDislikes + :addDislike WHERE idTouite = :touiteId");
            $updateQuery->bindParam(':touiteId', $touiteId, PDO::PARAM_INT);

            // Si l'action est un like (action = 1), incrémente nbLikes de 1 et laisse nbDislikes inchangé
            $addLike = ($action === 1) ? 1 : 0;
            $updateQuery->bindParam(':addLike', $addLike, PDO::PARAM_INT);

            // Si l'action est un dislike (action = 2), incrémente nbDislikes de 1 et laisse nbLikes inchangé
            $addDislike = ($action === 2) ? 1 : 0;
            $updateQuery->bindParam(':addDislike', $addDislike, PDO::PARAM_INT);

            $updateQuery->execute();

            
            header('Content-Type: text/html');
            echo '<div class="success-message">Action effectuée avec succès!</div>';
        } else {
           
            header('Content-Type: text/html');
            echo '<div class="error-message">L\'utilisateur a déjà effectué cette action</div>';
        }
    } catch (\PDOException $e) {
        // Gère les erreurs liées à la base de données
        header('Content-Type: text/html');
        echo '<div class="error-message">Erreur de base de données: ' . $e->getMessage() . '</div>';
    } catch (\Exception $e) {
        // les autres erreurs
        header('Content-Type: text/html');
        echo '<div class="error-message">Erreur inattendue: ' . $e->getMessage() . '</div>';
    }
}
}
