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
    }
}
