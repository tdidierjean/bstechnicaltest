<?php

// Routes file - let's break this up if it gets too large

$app->put('/users/{userId:[0-9]+}/exercises/{exerciseId:[0-9]+}/vote',
    'BusuuTest\Exercise\Vote\Controller\ExerciseVoteAction::voteAction')
    ->setName('exerciseVote');