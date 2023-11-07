<?php

namespace src\Dispatcher;

//use iutnc\deefy\action\AddUserAction;
//use iutnc\deefy\action\SigninAction;
//use iutnc\deefy\action\DisplayPlaylistAction;
// use iutnc\deefy\action\AddPlaylistAction;

use src\Action\RegisterAction;
use src\Action\SigninAction;
use src\Action\DisplayTweetsAction;


class Dispatcher {
    private $action;

    public function __construct($action) {
        $this->action = $action;
    }

    public function run(): void {
        // include('menu.html');
        switch ($this->action) {
            case 'register':
            $reg = new RegisterAction();
            $this->renderPage($reg->execute());
            break;
            case 'login':
            $log = new SigninAction();
            $this->renderPage($log->execute());
            break;
            case 'displayTweets':
                $displayTweets = new DisplayTweetsAction();
                $this->renderPage($displayTweets->execute());
                break;
            default:
                 $this->renderPage(file_get_contents('menu.html'));
                break;
        
        }
    }

      private function displayDefaultPage(): void {
        // Affiche les tweets à l'entrée sur le site web
        $displayTweets = new DisplayTweetsAction();
        $this->renderPage($displayTweets->execute());
    }

    private function renderPage(string $html): void {
        echo $html;

        /*echo <<<END
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Menu HTML</title>
            <link rel="stylesheet" href="style.css">
            <!-- Lien vers le CDN Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
            <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        </head>
        <body>
            <div id="menu">
                <div id="logo">
                    <img src="logo.png" alt="Logo">
                    <h4>Touiter.app</h4>
                </div>
                <ul>
                    <li class="element_menu"><i class="bi bi-person-lines-fill"></i> <a href="index.php?action=register">Register</a></li>
                    <li class="element_menu"><i class="bi bi-box-arrow-in-right"></i> <a href="index.php?action=login">Log-in</a></li>
                    <li class="element_menu"><i class="bi bi-person-square"></i> Profile</li>
                </ul>
                <div id="deconnexion">
                    <li class="element_menu"><i class="bi bi-box-arrow-in-left"></i> Deconnexion</li>
                </div>
            </div>
        </body>
        </html>
        END;*/
    }
}
