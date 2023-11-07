<?php

// namespace iutnc\deefy\dispatch;
 // use iutnc\deefy\action\SigninAction;

class Dispatcher {
    private $action;

    public function __construct($action) {
        $this->action = $action;
    }

    public function run(): void {
      default:
                $this->renderPage(file_get_contents('index.html'));
                break;
    }

  private function renderPage(string $html): void {
        echo $html;
    }
}
