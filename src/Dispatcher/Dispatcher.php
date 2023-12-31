<?php
namespace src\Dispatcher;

use src\Action\AdminAction;
use src\Action\CalculerScoreMoyenAction;
use src\Action\RegisterAction;
use src\Action\ShowFollowers;
use src\Action\SigninAction;
use src\Action\DisplayTweetsAction;
use src\Action\PostTweetAction;
use src\Action\DeleteTweetAction;
use src\Action\ListTagAction;
use src\Action\FollowUserAction;
use src\Action\ProfileAction;
use src\Action\LikeDislikeAction;



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
                $html = returnHTML();
                $this->renderPage($html);
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
            case 'followers':
                $showF = new ShowFollowers();
                $this->renderPage($showF->execute());
                break;
            case 'scoreMoy':
                $calculerScoreMoy = new CalculerScoreMoyenAction();
                $this->renderPage($calculerScoreMoy->execute());
                break;
            case 'ListeTweets':
                $liketweet = new LikeDislikeAction();
                $this->renderPage($liketweet->execute());
                break;
            case 'Administration':
                $admin = new AdminAction();
                $this->renderPage($admin->execute());
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
