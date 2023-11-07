<?php

namespace src\Dispatcher;

//use iutnc\deefy\action\AddUserAction;
//use iutnc\deefy\action\SigninAction;
//use iutnc\deefy\action\DisplayPlaylistAction;
// use iutnc\deefy\action\AddPlaylistAction;

use src\Action\RegisterAction;



class Dispatcher {
    private $action;

    public function __construct($action) {
        $this->action = $action;
    }

    public function run(): void {
        switch ($this->action) {

            case 'register':
            $reg = new RegisterAction();
            $this->renderPage($reg->execute());
            break;
            
            default:
                $this->renderPage(file_get_contents('menu.html'));
                break;
        }
    }

    private function renderPage(string $html): void {
        echo $html;
    }
}
