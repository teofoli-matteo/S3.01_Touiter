<?php
require_once 'vendor/autoload.php';
use src\Db\connexionFactory;
use src\Dispatcher\dispatcher;

connexionFactory::setConfig('db.config.ini');

session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $_SESSION['user_id'] = intval($_GET['id']);
}

$action = isset($_GET['action']) ? $_GET['action'] : 'default';

// Si l'action demandée est vide ou égale à 'default', rediriger vers DisplayTweetsAction
if (empty($action) || $action === 'default') {
    $action = 'displayTweets';
}

$dispatcher = new Dispatcher($action);
$dispatcher->run();



