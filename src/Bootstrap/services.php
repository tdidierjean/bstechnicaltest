<?php

$container['ServiceExerciseVote'] = function (\Slim\Container $c) {
    return new \BusuuTest\Exercise\Vote\Service\ExerciseVoteService($c->get('RepositoryExerciseVote'));
};