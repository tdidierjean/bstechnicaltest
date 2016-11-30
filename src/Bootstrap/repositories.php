<?php

$container['RepositoryExerciseVote'] = function(\Slim\Container $c) {
    return new \BusuuTest\Exercise\Vote\EntityRepository\ExerciseVoteRepository();
};