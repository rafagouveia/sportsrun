<?php
use Slim\Views\PhpRenderer;

require_once "vendor/autoload.php";

$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('views', [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// Define named route
$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.html', [
        "title" => "Sports Run"
    ]);
})->setName('profile');


// Run app
$app->run();