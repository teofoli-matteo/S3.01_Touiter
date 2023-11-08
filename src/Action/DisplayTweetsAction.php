<?php
namespace src\Action;

use src\Db\connexionFactory; 
use PDO;

class DisplayTweetsAction {
    public function execute() {
        $db = connexionFactory::makeConnection();

        // Récupérer le tag associé de l'URL, si présent
        $tagFilter = isset($_GET['tag']) ? urldecode($_GET['tag']) : null;

        $sqlTotal = "SELECT COUNT(idTouite) as total FROM TOUITE";
        $stmtTotal = $db->prepare($sqlTotal);
        $stmtTotal->execute();
        $totalElements = (int) $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];


        $elementsParPage = 3;
        $nombreTotalDePages = ceil($totalElements / $elementsParPage);
        $numeroDePage = isset($_GET['page']) ? max(1, min($nombreTotalDePages, (int)$_GET['page'])) : 1;
        $offset = ($numeroDePage - 1) * $elementsParPage;

// Modifier votre requête SQL pour inclure la clause LIMIT
        $sql = "SELECT t.idTouite, t.idUser, t.dateTouite, t.message, t.nbLike, t.nbDislike, ta.libelle AS tag_libelle, i.url AS image_url, tt.libelle AS tag_associated
        FROM Touite t
        LEFT JOIN Tag ta ON t.idTouite = ta.IdTouite
        LEFT JOIN Image i ON t.idTouite = i.IdTouite
        LEFT JOIN ListeTouites_Tag lt ON t.idTouite = lt.idTouite
        LEFT JOIN tagtest tt ON lt.idTag = tt.idTag";

        if ($tagFilter !== null) {
            $sql .= " WHERE tt.libelle = :tag";
        }

        $sql .= " ORDER BY t.dateTouite DESC LIMIT $offset, $elementsParPage";

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
            $stmt = $db->prepare($sql);
            if ($tagFilter !== null) {
                $stmt->bindParam(':tag', $tagFilter, PDO::PARAM_STR);
            }
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li class='tweet'><strong>Utilisateur:</strong> <a href='javascript:void(0);' class='user-link'>" . $row["idUser"] . "</a> <br><strong>Message:</strong> " . $row["message"] . " ";

                    // Afficher les tags associés à ce tweet
                    if (!empty($row["tag_associated"])) {
                        $tags = explode(',', $row["tag_associated"]);
                        echo "<div class='tweet-tags'><strong>#:</strong> ";
                        foreach ($tags as $tag) {
                            echo "<a href='?tag=" . urlencode($tag) . "'>" . $tag . "</a> ";
                        }
                        echo "</div>";
                    }
                    $test = $row["image_url"];
                    echo "<div class='tweet-details'><strong>Date:</strong> " . $row["dateTouite"] . " <br><strong>Image:</strong> " . "<img class='img-touite' src=".$test .">" . "<br><strong>Like:</strong> " . $row["nbLike"] . " <br><strong>Dislike:</strong> " . $row["nbDislike"] . "</div></li><br>  

                    <style> 
                        img{
                            max-width: 50px;
                            max-height: 50px;
                        }
                    </style>";
                }
            } else {
                echo "Aucun tweet trouvé.";
            }
            ?>
        </ul>

        <!-- Afficher les liens de pagination -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $nombreTotalDePages; $i++) {
                echo "<a href='?page=$i'>$i</a>";
            }
            ?>
        </div>

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