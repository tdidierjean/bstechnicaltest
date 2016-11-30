<?php

$container['ControllerExerciseVote'] = function (\Slim\Container $c) {
    return new \BusuuTest\Exercise\Vote\Controller\ExerciseVoteAction($c->get('ServiceExerciseVote'),
        new \BusuuTest\EntityRepository\UserRepository(),
        new \BusuuTest\EntityRepository\ExerciseRepository(),
        $c->get('RepositoryExerciseVote'));
};