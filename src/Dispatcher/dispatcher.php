<?php

namespace src\Dispatcher;

//use iutnc\deefy\action\AddUserAction;
//use iutnc\deefy\action\SigninAction;
//use iutnc\deefy\action\DisplayPlaylistAction;
// use iutnc\deefy\action\AddPlaylistAction;

use src\Action\RegisterAction;
use src\Action\DisplayTweetsAction;




class Dispatcher {
    private $action;

    public function __construct($action) {
        $this->action = $action;
    }

    public function run(): void {
        include('menu.html');
        switch ($this->action) {
            case 'register':
            $reg = new RegisterAction();
            $this->renderPage($reg->execute());
            break;

            case 'displayTweets':
                $displayTweets = new DisplayTweetsAction();
                $this->renderPage($displayTweets->execute());
                break;
            default:
                // Page par défaut, par exemple, afficher les tweets à l'entrée
                $this->displayDefaultPage();
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
    }
}
