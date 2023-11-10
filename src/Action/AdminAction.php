<?php

namespace src\Action;

use src\Db\connexionFactory;
use PDO;

Class AdminAction{
    public function execute(): string{



        $idUser = $_COOKIE['user_id'];
        if (!isset($_COOKIE['user_id'])) {
            return "Veuillez vous connecter pour voir votre profil.";

        }
        try {
            $pdo = connexionFactory::makeConnection();

            $stmt = $pdo->prepare("SELECT role from users WHERE idUser = :idUser");
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();

        } catch (\PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }

        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($role['role'] != '1') {
            return "Vous n'êtes pas administrateur";
        }

        // requete sql qui récupère les 5 users avec le plus de followers (attributs nbFollower dans la table users)
        $stmt = $pdo->prepare("SELECT * FROM users ORDER BY nbFollower DESC LIMIT 5");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // organise $users par ordre croissant
        usort($users, function ($a, $b) {
            return $a['nbFollower'] <=> $b['nbFollower'];
        });


        // requete sql qui récupère les 5 tags les plus utilisés (attributs nbTag dans la table listetouites_tag)
        $stmt = $pdo->prepare("SELECT libelle, COUNT(lt.idTAG) AS nbMentions FROM listetouites_tag lt INNER JOIN tagtest ON lt.idTAG = tagtest.idTAG GROUP BY libelle ORDER BY COUNT(lt.idTAG) DESC LIMIT 5");
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // organise $tags par ordre croissant
        usort($tags, function ($a, $b) {
            return $a['nbMentions'] <=> $b['nbMentions'];
        });
        ob_start();
        $html = '<h1>Administration</h1><h2>Utilisateurs avec le plus de followers</h2>';
        $html .= '<div class="influenceurs">';
        $html .= '<ul>';
        //affichage des 5 users avec le plus de followers par ordre croissant
        foreach ($users as $user) {
            $html .= '<li class="listes">';
            $html .= '<strong> Pseudo : ' . htmlspecialchars($user['idUser']) . '</strong>';
            $html .= '<p> nombres de  : ' . htmlspecialchars($user['nbFollower']) . '</p>';
            $html .= '</li>';
        }
        $html .= '</ul>';

        $html .= '<h2>Tendances</h2>';
        $html .= '<div class="tendances">';
        $html .= '<ul>';
        foreach ($tags as $tag) {
            $html .= '<li class="listes">';
            $html .= '<strong> Tag : ' . htmlspecialchars($tag['libelle']) . '</strong>';
            $html .= '<p> nombre de mentions : ' . htmlspecialchars($tag['nbMentions']) . '</p>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
        ob_clean();
    }
}
?>


<link rel="stylesheet" href="css/sections.css">
