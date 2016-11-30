<?php

namespace BusuuTest\Exercise\Vote\Entity;


use BusuuTest\Entity\Exercise;
use BusuuTest\Entity\User;

class ExerciseVote
{
    // $voteType constants
    const UP_VOTE = 1;
    const DOWN_VOTE = 0;

    /** @var int */
    private $id;

    /**
     * @var Exercise
     */
    private $exercise;

    /** @var  int $voteType (0 - Down vote, 1 - Up vote) */
    private $voteType;

    /** @var  User */
    private $voter;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ExerciseVote
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     * @return $this
     */
    public function setExercise(Exercise $exercise)
    {
        $this->exercise = $exercise;

        return $this;
    }

    /**
     * @return int
     */
    public function getVoteType()
    {
        return $this->voteType;
    }

    /**
     * @param int $voteType
     * @return $this
     */
    public function setVoteType($voteType)
    {
        $this->voteType = $voteType;
        return $this;
    }

    /**
     * @return User
     */
    public function getVoter()
    {
        return $this->voter;
    }

    /**
     * @param User $voter
     * @return $this
     */
    public function setVoter(User $voter)
    {
        $this->voter = $voter;
        return $this;
    }
}