<?php

namespace BusuuTest\Exercise\Vote\Service;


use BusuuTest\Entity\Exercise;
use BusuuTest\Entity\User;
use BusuuTest\Exercise\Vote\Entity\ExerciseVote;
use BusuuTest\Exercise\Vote\EntityRepository\ExerciseVoteRepository;

class ExerciseVoteService
{
    /** @var ExerciseVoteRepository */
    private $exerciseVoteRepository;

    /**
     * ExerciseVoteService constructor.
     * @param ExerciseVoteRepository $exerciseVoteRepository
     */
    public function __construct(ExerciseVoteRepository $exerciseVoteRepository)
    {
        $this->exerciseVoteRepository = $exerciseVoteRepository;
    }

    /**
     * @param int $voteType - see ExerciseVote::UP_VOTE|ExerciseVote::DOWN_VOTE
     * @param User $voter
     * @param Exercise $exercise
     * @return ExerciseVote
     */
    public function create($voteType, User $voter, Exercise $exercise)
    {
        $exerciseVote = new ExerciseVote();
        $exerciseVote->setVoteType($voteType)
            ->setVoter($voter)
            ->setExercise($exercise);
        return $exerciseVote;
    }

    /**
     * @param ExerciseVote $exerciseVote
     */
    public function save(ExerciseVote $exerciseVote)
    {
        $this->exerciseVoteRepository->save($exerciseVote);
    }
}