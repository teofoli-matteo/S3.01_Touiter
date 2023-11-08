<?php
namespace src\Action;

use src\Db\connexionFactory;

class PostTweetAction extends Action {
    public function execute(): string {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && !empty($_POST['message']) && isset($_SESSION['user_id'])) {
            $tweet = $_POST['message'];
            $userId = $_SESSION['user_id'];

            // Trouver les hashtags dans le message
            preg_match_all('/#(\w+)/', $tweet, $hashtags);
            $tags = $hashtags[1]; // Tableau de hashtags

            try {
                $pdo = connexionFactory::makeConnection();
                $stmt = $pdo->prepare("INSERT INTO Touite (idUser, dateTouite, message, nbLike, nbDislike) VALUES (:user_id, NOW(), :tweet, 0, 0)");
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':tweet', $tweet);
                $stmt->execute();

                // Récupérer l'ID du dernier tweet inséré
                $tweetId = $pdo->lastInsertId();

                // Enregistrer les hashtags dans la table tagtest
                foreach ($tags as $tag) {
                    $stmt = $pdo->prepare("INSERT INTO tagtest (libelle, description) VALUES (:tag, '')");
                    $stmt->bindParam(':tag', $tag);
                    $stmt->execute();

                    // Récupérer l'ID du dernier tag inséré
                    $tagId = $pdo->lastInsertId();

                    // Associer le tag au tweet dans la table de liaison ListeTouites_Tag
                    $stmt = $pdo->prepare("INSERT INTO ListeTouites_Tag (idTouite, idTag) VALUES (:tweetId, :tagId)");
                    $stmt->bindParam(':tweetId', $tweetId);
                    $stmt->bindParam(':tagId', $tagId);
                    $stmt->execute();
                }

                // Rediriger l'utilisateur vers la page principale après avoir tweeté
                header("Location: /index.php");
                exit();
            } catch (\PDOException $e) {
                echo "Erreur lors de l'ajout du tweet : " . $e->getMessage();
            }
        }

        // En cas d'erreur ou d'accès direct, rediriger l'utilisateur vers la page principale
        header("Location: /index.php");
        exit();
    }
}
