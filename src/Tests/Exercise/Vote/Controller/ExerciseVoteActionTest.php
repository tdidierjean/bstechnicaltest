<?php

namespace BusuuTest\Tests\Exercise\Vote\Controller;

use BusuuTest\Entity\Exercise;
use BusuuTest\Entity\User;
use BusuuTest\EntityRepository\ExerciseRepository;
use BusuuTest\EntityRepository\UserRepository;
use BusuuTest\Exercise\Vote\Controller\ExerciseVoteAction;
use BusuuTest\Exercise\Vote\Entity\ExerciseVote;
use BusuuTest\Exercise\Vote\EntityRepository\ExerciseVoteRepository;
use BusuuTest\Exercise\Vote\Service\ExerciseVoteService;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;

class ExerciseVoteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $userId
     * @param $exerciseId
     * @param $expectedBody
     *
     * @dataProvider userExerciseDataProvider
     */
    public function testVoting($voteType, $expectedBody, $testReason)
    {

        $request = $this->getMockRequest($voteType);

        $exerciseVoteAction = new ExerciseVoteAction(
            new ExerciseVoteService($this->getMockExerciseVoteRepository()),
            $this->getMockUserRepository(),
            $this->getMockExerciseRepository(),
            $this->getMockExerciseVoteRepository()
        );
        $response = new Response();

        $response = $exerciseVoteAction->voteAction(
            $request,
            $response,
            ['userId' => 1, 'exerciseId' => 1]
        );

        $this->assertEquals(
            (string)$response->getBody(),
            $expectedBody,
            sprintf("%s\nExpected: %s\nFound: %s", $testReason, $expectedBody, (string)$response->getBody()));
    }

    /**
     * @param $userId
     * @param $exerciseId
     * @param $expectedBody
     */
    public function testVoteFail()
    {
        $serviceMock = $this->getMockBuilder('\BusuuTest\Exercise\Vote\Service\ExerciseVoteService')
            ->disableOriginalConstructor()
            ->getMock();
        $serviceMock->expects($this->any())
            ->method('create')
            ->will($this->returnValue(1));

        $evRepositoryMock = $this->getMockBuilder('\BusuuTest\Exercise\Vote\EntityRepository\ExerciseVoteRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $evRepositoryMock->expects($this->any())
            ->method('findByUserAndExercise')
            ->will($this->returnValue(null));

        $request = $this->getMockRequest(0);

        $exerciseVoteAction = new ExerciseVoteAction(
            $serviceMock,
            $this->getMockUserRepository(),
            $this->getMockExerciseRepository(),
            $evRepositoryMock
        );
        $response = new Response();

        $response = $exerciseVoteAction->voteAction(
            $request,
            $response,
            ['userId' => 1, 'exerciseId' => 1]
        );

        $expectedBody = '{"msg":"Apologies, there was an issue with the vote. Please try again"}';

        $this->assertEquals(
            (string)$response->getBody(),
            $expectedBody,
            sprintf("%s\nExpected: %s\nFound: %s", 'Testing: Failing to save vote', $expectedBody, (string)$response->getBody()));
    }

    /**
     * @return array[$voteType, $expectedBody]
     */
    public function userExerciseDataProvider()
    {
        return [
            [0,'{"msg":"Thank you for voting!"}', 'Testing: Previous vote was different'],
            [1,'{"msg":"Thank you for having voted. Apologies, only one vote is allowed."}', 'Testing: Previous vote was the same'],
            [null,'{"msg":"Thank you for voting!"}', 'Testing: No previous vote'],
        ];
    }

    private function getMockRequest($voteType)
    {
        $mock = $this->getMockBuilder('Slim\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->any())
            ->method('getParsedBody')
            ->will($this->returnValue(array('voteType' => $voteType)));
        return $mock;
    }

    private function getMockUserRepository()
    {
        $mock = $this->getMockBuilder('\BusuuTest\EntityRepository\UserRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->any())
            ->method('find')
            ->with($this->anything())
            ->will($this->returnValue($this->getMockUser(1)));
        return $mock;
    }

    private function getMockUser($userId)
    {
        $user = new User();
        $user->setId($userId);
        return $user;
    }

    private function getMockExerciseRepository()
    {
        $mock = $this->getMockBuilder('\BusuuTest\EntityRepository\ExerciseRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->any())
            ->method('find')
            ->will($this->returnValue($this->getMockExercise(1)));
        return $mock;
    }

    private function getMockExercise($exerciseId)
    {
        $exercise = new Exercise();
        $exercise->setId($exerciseId);
        return $exercise;
    }

    private function getMockExerciseVoteRepository()
    {
        $mock = $this->getMockBuilder('\BusuuTest\Exercise\Vote\EntityRepository\ExerciseVoteRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())
            ->method('findByUserAndExercise')
            ->will($this->returnValue($this->getMockExerciseVote(1)));

        return $mock;
    }

    private function getMockExerciseVote($voteType)
    {
        $exerciseVote = new ExerciseVote();
        $exerciseVote->setId(1);
        $exerciseVote->setVoteType($voteType);
        return $exerciseVote;
    }
}