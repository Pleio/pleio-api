<?php
require '../vendor/autoload.php';

\Elgg\Application::start();

$app = new \Slim\Slim();

$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function() use ($app) {
    $json = array(
        'title' => 'Pleio API',
        'version' => '2.0',
        'comments' => 'Tonight, Let It Be Code.'
    );

    $app->response->setBody(json_encode($json, JSON_PRETTY_PRINT));
});

$app->get('/blogs', function () use ($app) {
    $json = array();

    $entities = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'blog'
    ));

    foreach ($entities as $entity) {
        $json[] = array(
            'guid' => $entity->guid,
            'type' => $entity->getType(),
            'subtype' => $entity->getSubtype(),
            'time_created' => $entity->time_created,
            'title' => $entity->title
        );
    }

    $app->response->setBody(json_encode($json, JSON_PRETTY_PRINT));
});

$app->get('/users', function() use ($app) {
    $json = array();

    $entities = elgg_get_entities(array(
        'type' => 'user'
    ));

    if ($entities) {
        foreach ($entities as $entity) {
            $json[] = array(
                'guid' => $entity->guid,
                'type' => $entity->getType(),
                'subtype' => $entity->getSubtype(),
                'time_created' => $entity->time_created,
                'username' => $entity->username,
                'name' => $entity->name,
                'email' => $entity->email
            );
        }
    }

    $app->response->setBody(json_encode($json, JSON_PRETTY_PRINT));
});

$app->run();