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

                return "Abonnement au tag réussi !";
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
                    $html .= '<form action="index.php?action=listTag" method="post">';
                    $html .= '<input type="hidden" name="idTag" value="' . $tag['idTag'] . '">';
                    $html .= '<button type="submit">S\'abonner</button>';
                    $html .= '</form>';
                    $html .= '</li>';
                }
                $html .= '</ul>';

                return $html;
            } catch (PDOException $e) {
                return "Erreur lors de la récupération des tags: " . $e->getMessage();
            }
        }
    }
}
