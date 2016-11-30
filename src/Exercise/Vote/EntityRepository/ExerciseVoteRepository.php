<?php

namespace BusuuTest\Exercise\Vote\EntityRepository;

use BusuuTest\Entity\User;
use BusuuTest\Entity\Exercise;
use BusuuTest\EntityRepository\RepositoryInterface;
use BusuuTest\Exercise\Vote\Entity\ExerciseVote;

class ExerciseVoteRepository implements RepositoryInterface
{
    /**
     * @param User $user
     * @param Exercise $exercise
     * @return ExerciseVote
     */
    public function findByUserAndExercise(User $user, Exercise $exercise)
    {
        // TODO: Implement findByUserAndExercise() method.
    }

    /**
     * @param $entityId
     * @return ExerciseVote
     */
    public function find($entityId)
    {
        // TODO: Implement find() method.
    }

    public function save($entityObject)
    {
        // TODO: Implement save() method.
    }
}