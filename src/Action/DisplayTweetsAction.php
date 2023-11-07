<?php
namespace src\Action;

use src\Db\connexionFactory; 
use PDO;

class DisplayTweetsAction {
    public function execute() {
        $db = connexionFactory::makeConnection();

        // Récupérer le tag de l'URL, si présent
        $tagFilter = isset($_GET['tag']) ? urldecode($_GET['tag']) : null;

        // Requête SQL pour récupérer les tweets filtrés par tag
        $sql = "SELECT t.idTouite, t.idUser, t.dateTouite, t.message, t.nbLike, t.nbDislike, ta.libelle AS tag_libelle, i.url AS image_url
                FROM Touite t
                LEFT JOIN Tag ta ON t.idTouite = ta.IdTouite
                LEFT JOIN Image i ON t.idTouite = i.IdTouite";

        // Ajouter le filtre par tag à la requête si un tag est sélectionné
        if ($tagFilter !== null) {
            $sql .= " WHERE ta.libelle = :tag";
        }

        $sql .= " ORDER BY t.dateTouite DESC";

        // Préparez la requête SQL
        $stmt = $db->prepare($sql);

        // Liez le paramètre du tag si un tag est sélectionné
        if ($tagFilter !== null) {
            $stmt->bindParam(':tag', $tagFilter, PDO::PARAM_STR);
        }

        // Exécutez la requête SQL
        $stmt->execute();

        ob_start(); 
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Liste des Tweets</title>
            <link rel="stylesheet" href="src/Action/test.css">
        </head>
        <body>
            <h1>Liste des touites</h1>
            <ul>
                <?php
                if ($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='tweet'><strong>Utilisateur:</strong> <a href='javascript:void(0);' class='user-link'>" . $row["idUser"]. "</a> <br><strong>Message:</strong> " . $row["message"]. " <br><strong>#Tag:</strong> <a href='?tag=" . urlencode($row["tag_libelle"]) . "'>" . $row["tag_libelle"] . "</a> " . "<div class='tweet-details'><strong>Date:</strong> " . $row["dateTouite"]. " <br><strong>Image:</strong> " . $row["image_url"]. "<br><strong>Like:</strong> " . $row["nbLike"]. " <br><strong>Dislike:</strong> " . $row["nbDislike"] ."</div></li><br>";
                    }
                } else {
                    echo "Aucun tweet trouvé.";
                }
                ?>
            </ul>

            <button onclick="window.location.href='menu.html';">Retour au menu</button>

            <script>
                var tweets = document.querySelectorAll('.tweet');
                var userLinks = document.querySelectorAll('.user-link');

                tweets.forEach(function(tweet, index) {
                    tweet.addEventListener('click', function() {
                        var tweetDetails = this.querySelector('.tweet-details');
                        
                        if (tweetDetails.style.display === 'none' || tweetDetails.style.display === '') {
                            tweetDetails.style.display = 'block';
                        } else {
                            tweetDetails.style.display = 'none';
                        }
                    });

                    userLinks[index].addEventListener('click', function(event) {
                        var selectedUser = this.innerText;
                        tweets.forEach(function(tweet) {
                            if (tweet.querySelector('.user-link').innerText !== selectedUser) {
                                tweet.style.display = 'none';
                            } else {
                                tweet.style.display = 'block';
                            }
                        });
                        event.stopPropagation();
                    });
                });
            </script>
        </body>
        </html>
        <?php

        return ob_get_clean();
    }
}
?>
