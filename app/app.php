<?php

// Register global errors and exception handlers
use MyBooksApp\DAO\AuthorDAO;
use MyBooksApp\DAO\BookDAO;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

ErrorHandler::register();
ExceptionHandler::register();

// Register service providers
$app->register(new DoctrineServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));
$app->register(new AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

// Register services
$app['dao.author'] = function ($app) {
    return new AuthorDAO($app['db']);
};
$app['dao.book'] = function ($app) {
    $bookDAO = new BookDAO($app['db']);
    $bookDAO->setAuthorDAO($app['dao.author']);

    return $bookDAO;
};
