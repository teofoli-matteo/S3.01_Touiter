<?php
namespace src\Action;

use src\Db\connexionFactory;

class PostTweetAction extends Action {
    public function execute(): string {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && !empty($_POST['message']) && isset($_SESSION['user_id'])) {
            $tweet = $_POST['message'];
            $userId = $_SESSION['user_id'];
            $imageUrl = null;

            // Vérifiez si un fichier a été téléchargé
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'src/Action/uploads/'; // Répertoire de téléchargement des images
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);

                // Déplacez le fichier téléchargé vers le répertoire d'uploads
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Fichier téléchargé avec succès, vous pouvez enregistrer le chemin d'accès dans la variable $imageUrl
                    $imageUrl = $uploadFile;
                } else {
                    // Erreur lors du téléchargement du fichier
                    echo "Erreur lors du téléchargement du fichier.";
                    exit();
                }
            }

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

                // Insérer l'image associée au tweet dans la table img si elle existe
                if (!is_null($imageUrl)) {
                    $stmt = $pdo->prepare("INSERT INTO image (idTouite, url) VALUES (:tweetId, :imageUrl)");
                    $stmt->bindParam(':tweetId', $tweetId);
                    $stmt->bindParam(':imageUrl', $imageUrl);
                    $stmt->execute();
                }

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

                // apres avoir ajouter un tweet, on pop un message de succes
                $_SESSION['success'] = "Votre tweet a été publié avec succès !";
                header("Location: /index.php");

            } catch (\PDOException $e) {
                echo "Erreur lors de l'ajout du tweet : " . $e->getMessage();
            }
        }

        // En cas d'erreur ou d'accès direct, rediriger l'utilisateur vers la page principale
        header("Location: /index.php");
        exit();
    }
}
?>
