<?php

namespace src\Dispatcher;

//use iutnc\deefy\action\AddUserAction;
//use iutnc\deefy\action\SigninAction;
//use iutnc\deefy\action\DisplayPlaylistAction;
// use iutnc\deefy\action\AddPlaylistAction;

use src\Action\RegisterAction;
use src\Action\SigninAction;
use src\Action\DisplayTweetsAction;
use src\Action\PostTweetAction;
use src\Action\DeleteTweetAction;



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
            case 'signin':
            $log = new SigninAction();
            $this->renderPage($log->execute());
            break;
            case 'displayTweets':
                $displayTweets = new DisplayTweetsAction();
                $this->renderPage($displayTweets->execute());
                break;
            case 'postTweet':
                $postTweet = new PostTweetAction();
                $postTweet->execute();
                break;
        
               case 'delete-tweet':
        $deleteTweet = new DeleteTweetAction();
        $this->renderPage($deleteTweet->execute());
        break;
                case 'tweetForm':
    include 'src/User/tweetForm.php';
    break;




            default:
                 $this->renderPage(file_get_contents('menu.php'));
                break;
        
        }
    }

      private function displayDefaultPage(): void {
        $displayTweets = new DisplayTweetsAction();
        $this->renderPage($displayTweets->execute());
    }

    private function renderPage(string $html): void {
        echo $html;
    }
}
