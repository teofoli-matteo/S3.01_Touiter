<?php

namespace src\Action;

use src\Db\connexionFactory;
use PDO;
class FollowUserAction {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUser = $_POST['idUser'];

            if (!isset($_COOKIE['user_id'])) {
                return "Veuillez vous connecter pour suivre un utilisateur.";
            }

            $followerId = $_COOKIE['user_id'];

            try {
                $pdo = connexionFactory::makeConnection();

                $stmt = $pdo->prepare("INSERT INTO user_followers (idUser, followerId) VALUES (:idUser, :followerId)");
                $stmt->bindParam(':idUser', $idUser);
                $stmt->bindParam(':followerId', $followerId);
                $stmt->execute();

                return "Vous suivez maintenant cet utilisateur !";
            } catch (PDOException $e) {
                return "Erreur lors de l'abonnement à l'utilisateur: " . $e->getMessage();
            }
        } else {
            try {
                $pdo = connexionFactory::makeConnection();

                $stmt = $pdo->prepare("SELECT * FROM users
                                        WHERE idUser not in (SELECT idUser FROM user_followers
                                                              WHERE followerId = :followerId)");
                $stmt->bindParam(':followerId',$_COOKIE['user_id']);
                $stmt->execute();

                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $html = '<h1>Liste des utilisateurs</h1><ul>';
                foreach ($users as $user) {
                    $html .= '<li class="follow">';
                    $html .= '<strong>' . htmlspecialchars($user['idUser']) . '</strong>';
                    $html .= '<form class="follow-form" action="index.php?action=followUser" method="post">';
                    $html .= '<input type="hidden" name="idUser" value="' . $user['idUser'] . '">';
                    $html .= '<button type="submit">Suivre</button>';
                    $html .= '</form>';
                    $html .= '</li>';
                }
                $html .= '</ul>';

                $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
                $html .= '<script>';
                $html .= '$(document).ready(function() {';
                $html .= '    $(".follow-form").on("submit", function(e) {';
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
                return "Erreur lors de la récupération des utilisateurs: " . $e->getMessage();
            }
        }
    }
}

?>
<link rel="stylesheet" href="css/sections.css">
