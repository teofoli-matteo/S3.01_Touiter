<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class ListTagAction {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idTag = $_POST['idTag'];

            $idUser = $_COOKIE['user_id'];
                        if (!isset($_COOKIE['user_id'])) {
                return "Veuillez vous connecter pour vous abonner à un tag.";
            }

            try {
                $pdo = connexionFactory::makeConnection();

                $stmt = $pdo->prepare("INSERT INTO user_tag (idUser, idTag) VALUES (:idUser, :idTag)");
                $stmt->bindParam(':idUser', $idUser);
                $stmt->bindParam(':idTag', $idTag);
                $stmt->execute();

                // script pour rafraichir la page après l'abonnement au tag et affiche une alerte de confirmation
                echo '<script>
                        window.location.href = "index.php?action=listTag";
                        alert("Vous êtes maintenant abonné à ce tag !");
                    </script>';

            } catch (PDOException $e) {
                return "Erreur d'abonnement au tag: " . $e->getMessage();
            }
        } else {
            try {
                $pdo = connexionFactory::makeConnection();

                $stmt = $pdo->prepare("SELECT * FROM tagtest 
                                        WHERE idTag not in (SELECT idTag from user_tag
                                                            WHERE idUser = :idUser)");
                $stmt->bindParam(':idUser',$_COOKIE['user_id'] );
                $stmt->execute();

                $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $html = '<h1>Liste des tags</h1><ul>';
                foreach ($tags as $tag) {
                    $html .= '<li>';
                    $html .= htmlspecialchars($tag['libelle']);
                    $html .= '<form class="tag-form" action="index.php?action=listTag" method="post">';
                    $html .= '<input type="hidden" name="idTag" value="' . $tag['idTag'] . '">';
                    $html .= '<button type="submit">S\'abonner</button>';
                    $html .= '</form>';
                    $html .= '</li>';
                }
                $html .= '</ul>';

                $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
                $html .= '<script>';
                $html .= '$(document).ready(function() {';
                $html .= '    $(".tag-form").on("submit", function(e) {';
                $html .= '        e.preventDefault();';
                $html .= '';
                $html .= '        $.ajax({';
                $html .= '            type: "post",';
                $html .= '            url: $(this).attr("action"),';
                $html .= '            data: $(this).serialize(),';
                $html .= '            success: function(response) {';
                $html .= '                alert(response);';
                $html .= '                location.reload();';
                $html .= '            },';
                $html .= '            error: function(err) {';
                $html .= '                console.log(err);';
                $html .= '            }';
                $html .= '        });';
                $html .= '    });';
                $html .= '});';
                $html .= '</script>';

                $html .= '<a href="menu.php" class="back-button">Retour au menu</a>';

                return $html;
            } catch (PDOException $e) {
                return "Erreur lors de la récupération des tags: " . $e->getMessage();
            }
        }
    }
}

?>

<link rel="stylesheet" href="css/sections.css">