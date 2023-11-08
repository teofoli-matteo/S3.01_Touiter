<?php
namespace src\Action;

use src\Db\connexionFactory; 
use PDO;

class DisplayTweetsAction {
    public function execute() {
        $db = connexionFactory::makeConnection();

        // Récupérer le tag associé de l'URL, si présent
        $tagFilter = isset($_GET['tag']) ? urldecode($_GET['tag']) : null;

        // Requête SQL pour récupérer les tweets avec les tags associés
        $sql = "SELECT t.idTouite, t.idUser, t.dateTouite, t.message, t.nbLike, t.nbDislike, ta.libelle AS tag_libelle, i.url AS image_url, tt.libelle AS tag_associated
                FROM Touite t
                LEFT JOIN Tag ta ON t.idTouite = ta.IdTouite
                LEFT JOIN Image i ON t.idTouite = i.IdTouite
                LEFT JOIN ListeTouites_Tag lt ON t.idTouite = lt.idTouite
                LEFT JOIN tagtest tt ON lt.idTag = tt.idTag";

        // Ajouter le filtre par tag associé à la requête si un tag est sélectionné
        if ($tagFilter !== null) {
            $sql .= " WHERE tt.libelle = :tag";
        }

        $sql .= " ORDER BY t.dateTouite DESC";

        // Préparez la requête SQL
        $stmt = $db->prepare($sql);

        // Liez le paramètre du tag associé si un tag est sélectionné
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
            <style>
                .tweet-tags {
                    display: none;
                    margin-top: 5px;
                }
            </style>
        </head>
        <body>
            <h1>Liste des touites</h1>
            <ul>
                <?php
                if ($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='tweet'><strong>Utilisateur:</strong> <a href='javascript:void(0);' class='user-link'>" . $row["idUser"]. "</a> <br><strong>Message:</strong> " . $row["message"]. "</a> ";
                        
                        // Afficher les tags associés à ce tweet
                        if (!empty($row["tag_associated"])) {
                            $tags = explode(',', $row["tag_associated"]);
                            echo "<div class='tweet-tags'><strong>#:</strong> ";
                            foreach ($tags as $tag) {
                                echo "<a href='?tag=" . urlencode($tag) . "'>" . $tag . "</a> ";
                            }
                            echo "</div>";
                        }
                        
                        echo "<div class='tweet-details'><strong>Date:</strong> " . $row["dateTouite"]. " <br><strong>Image:</strong> " . $row["image_url"]. "<br><strong>Like:</strong> " . $row["nbLike"]. " <br><strong>Dislike:</strong> " . $row["nbDislike"] ."</div></li><br>";
                    }
                } else {
                    echo "Aucun tweet trouvé.";
                }
                ?>
            </ul>

            <button onclick="window.location.href='menu.php';">Retour au menu</button>

            <script>
                var tweets = document.querySelectorAll('.tweet');
var userLinks = document.querySelectorAll('.user-link');

tweets.forEach(function(tweet) {
    var tags = tweet.querySelector('.tweet-tags');

    tweet.addEventListener('click', function() {
        var tweetDetails = this.querySelector('.tweet-details');

        if (tweetDetails.style.display === 'none' || tweetDetails.style.display === '') {
            tweetDetails.style.display = 'block';
            tags.style.display = 'block';
        } else {
            tweetDetails.style.display = 'none';
            tags.style.display = 'none';
        }
    });

    userLinks.forEach(function(userLink) {
        userLink.addEventListener('click', function(event) {
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
});

            </script>
        </body>
        </html>
        <?php

        return ob_get_clean();
    }
}
?>
