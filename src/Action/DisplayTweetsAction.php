<?php
namespace src\Action;

use src\Db\connexionFactory; 
use PDO;

class DisplayTweetsAction {
    public function execute() {
        $db = connexionFactory::makeConnection();

        // Requête SQL pour récupérer les tweets du plus récents au plus anciens
        $sql = "SELECT t.idTouite, t.idUser, t.dateTouite, t.message, t.nbLike, t.nbDislike, ta.libelle AS tag_libelle, i.url AS image_url
                FROM Touite t
                LEFT JOIN Tag ta ON t.idTouite = ta.IdTouite
                LEFT JOIN Image i ON t.idTouite = i.IdTouite
                ORDER BY t.dateTouite DESC";

        $result = $db->query($sql);

        ob_start(); 

        ?>
        <h1>Liste des Tweets</h1>
        <ul>
            <?php
            if ($result->rowCount() > 0) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li class='tweet'><strong>Utilisateur:</strong> <a href='javascript:void(0);' class='user-link'>" . $row["idUser"]. "</a> <br><strong>Message:</strong> " . $row["message"]. " <br><strong>Tag:</strong> " . $row["tag_libelle"]. 
                        "<div class='tweet-details'><strong>Date:</strong> " . $row["dateTouite"]. " <br><strong>Image:</strong> " . $row["image_url"]. "<br><strong>Like:</strong> " . $row["nbLike"]. " <br><strong>Dislike:</strong> " . $row["nbDislike"] ."</div></li><br>";
                }
            } else {
                echo "Aucun tweet trouvé.";
            }
            ?>
        </ul>

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
        <?php


        return ob_get_clean();
    }
}
