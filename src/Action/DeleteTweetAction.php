<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class DeleteTweetAction extends Action {
    public function execute(): string {
        // session_start();

        $htmlContent = ''; // Variable tampon pour stocker le contenu HTML

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $db = connexionFactory::makeConnection();

            // Vérifier si l'utilisateur a soumis le formulaire de suppression
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tweet_id'])) {
                $tweetId = $_POST['tweet_id'];

                // Vérifier si le tweet appartient à l'utilisateur connecté
                $stmt = $db->prepare("SELECT idTouite FROM Touite WHERE idTouite = :tweet_id AND idUser = :user_id");
                $stmt->bindParam(':tweet_id', $tweetId, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
                $stmt->execute();
                $tweet = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($tweet) {
                    // Supprimer le tweet de la base de données
                    $stmt = $db->prepare("DELETE FROM Touite WHERE idTouite = :tweet_id");
                    $stmt->bindParam(':tweet_id', $tweetId, PDO::PARAM_INT);
                    $stmt->execute();

                    // alerte de confirmation de suppression
                    $htmlContent .= '<script>
                            window.location.href = "index.php?action=delete-tweet";
                            alert("Votre tweet a bien été supprimé !");
                        </script>';
                } else {
                    // alerte d'erreur si le tweet n'appartient pas à l'utilisateur connecté
                    $htmlContent .= '<script>
                            window.location.href = "index.php?action=delete-tweet";
                            alert("Vous ne pouvez pas supprimer ce tweet !");
                        </script>';
                }
            }

            // Récupérer les tweets de l'utilisateur connecté
            $stmt = $db->prepare("SELECT idTouite, message FROM Touite WHERE idUser = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Afficher le formulaire de suppression avec les tweets de l'utilisateur
            $htmlContent .= "<h1>Supprimer un touite</h1>";
            $htmlContent .= '<form class="listes" method="post" action="index.php?action=delete-tweet">
                                <label for="tweetId">ID du Touite à supprimer :</label>
                                <input type="text" id="tweetId" name="tweet_id" required>
                                <button type="submit">Supprimer</button>
                            </form>';
            $htmlContent .= "<h2>Vos Tweets :</h2>";
            $htmlContent .= "<ul>";
            foreach ($tweets as $tweet) {
                $htmlContent .= "<li class='listes'><strong>ID du Tweet :</strong> " . $tweet['idTouite'] . " - <strong>Message :</strong> " . $tweet['message'] . " 
                        <form method='post' action='index.php?action=delete-tweet'>
                            <input type='hidden' name='tweet_id' value='" . $tweet['idTouite'] . "'>
                            <button type='submit'>Supprimer</button>
                        </form></li>";
            }
            $htmlContent .= "</ul>";

            return $htmlContent;
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            header("Location: /login");
            exit();
        }
    }
}
?>

<link rel="stylesheet" href="css/sections.css">