<?php
namespace src\Dispatcher;

use src\Action\RegisterAction;
use src\Action\SigninAction;
use src\Action\DisplayTweetsAction;
use src\Action\PostTweetAction;
use src\Action\DeleteTweetAction;
use src\Action\ListTagAction;
use src\Action\FollowUserAction;
use src\Action\ProfileAction;


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
            case 'listTag':
                $listTag = new ListTagAction();
                $this->renderPage($listTag->execute());
                break;
            case 'followUser':
                $followUser = new FollowUserAction();
                $this->renderPage($followUser->execute());
                break;
            case 'profileAction':
                $profileUser = new ProfileAction();
                $this->renderPage($profileUser->execute());
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
