<?php
use BusuuTest\Entity\Exercise;
use BusuuTest\EntityRepository\ExerciseRepository;
use BusuuTest\EntityRepository\UserRepository;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();

// Load services - break up / move if too large
require __DIR__ . '/Bootstrap/services.php';

// Load repositories - break up / move if too large
require __DIR__ . '/Bootstrap/repositories.php';

// Load controllers - break up / move if too large
require __DIR__ . '/Bootstrap/controllers.php';

// Load routes - break up / move if too large
require __DIR__ . '/Bootstrap/routes.php';

// We should probably have some sort of auth middleware
//require __DIR__ . '/Bootstrap/middleware.php';

/**
 * Endpoint to create an exercise. An exercise contains text submitted by a user.
 */
$app->post('/users/:userId/exercises', function (Request $request, Response $response, $args) {
    $data = json_decode($request->getBody());
    $userId = $args['userId'];

    // Check parameter validity
    if (empty($data->text)) {
        $response->withStatus(400);
        $response->getBody()->write(json_encode(['msg' => 'Text is missing!']));
        return $response;
     }

    $userRepository = new UserRepository();
    $exerciseRepository = new ExerciseRepository();

    // Create exercise
    $exercise = new Exercise();
    $exercise->setText($data->text);
    $exercise->setAuthor($userRepository->find($userId));
    $exerciseRepository->save($exercise);

    // Return response
    $response->withStatus(200);
    $response->getBody()->write(json_encode(['status' => 'ok']));
    return $response;
});



/**
 * Create here the voting endpoint
 */
$app->run();
