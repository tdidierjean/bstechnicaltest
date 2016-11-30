<?php

namespace BusuuTest\Exercise\Vote\Controller;

use BusuuTest\Entity\User;
use BusuuTest\Entity\Exercise;
use BusuuTest\EntityRepository\ExerciseRepository;
use BusuuTest\EntityRepository\UserRepository;
use BusuuTest\Exercise\Vote\EntityRepository\ExerciseVoteRepository;
use BusuuTest\Exercise\Vote\Service\ExerciseVoteService;
use Slim\Http\Request;
use Slim\Http\Response;

class ExerciseVoteAction
{
    /** @var  ExerciseVoteService */
    private $exerciseVoteService;
    /** @var  UserRepository */
    private $userRepository;
    /** @var  ExerciseRepository */
    private $exerciseRepository;
    /** @var  ExerciseVoteRepository */
    private $exerciseVoteRepository;

    /**
     * ExerciseVoteAction constructor.
     *
     * The number of repositories being injected can be reduced if we created a repository locator. Out of scope
     * for this test.
     *
     * @param ExerciseVoteService $exerciseVoteService
     * @param UserRepository $userRepository
     * @param ExerciseRepository $exerciseRepository
     * @param ExerciseVoteRepository $exerciseVoteRepository
     */
    public function __construct(ExerciseVoteService $exerciseVoteService,
                                UserRepository $userRepository,
                                ExerciseRepository $exerciseRepository,
                                ExerciseVoteRepository $exerciseVoteRepository
    ) {
        $this->exerciseVoteService = $exerciseVoteService;
        $this->userRepository = $userRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->exerciseVoteRepository = $exerciseVoteRepository;
    }

    public function voteAction(Request $request, Response $response, array $args)
    {
        $voterId = isset($args['userId']) ? $args['userId'] : null;
        $exerciseId = isset($args['exerciseId']) ? $args['exerciseId'] : null;

        $input = $request->getParsedBody();
        $voteType = isset($input['voteType']) ? $input['voteType'] : null;

        /** @var User $voter */
        $voter = $this->userRepository->find($voterId);
        /** @var Exercise $exercise */
        $exercise = $this->exerciseRepository->find($exerciseId);

        try {
            $exerciseVote = $this->exerciseVoteRepository->findByUserAndExercise($voter, $exercise);
            if ($exerciseVote && $exerciseVote->getVoteType() == $voteType) {
                return $response->withJson(['msg' => 'Thank you for having voted. Apologies, only one vote is allowed.']);
            }

            if (!$exerciseVote) {
                $exerciseVote = $this->exerciseVoteService->create($voteType, $voter, $exercise);
            }
            $this->exerciseVoteService->save($exerciseVote);

            return $response->withJson(['msg' => 'Thank you for voting!']);
        } catch (\Exception $e) {
            //Rollback transaction here if we had one
            return $response->withStatus(400)
                ->withJson(['msg' => 'Apologies, there was an issue with the vote. Please try again']);
        }
    }
}