#
# Busuu backend engineer test
#


This test allows you to demonstrate knowledge directly relevant to the work we do at busuu: use of a PHP framework, creation of a REST API, unit testing, and use of git.

This repository uses the SLIM framework (http://www.slimframework.com/). It's a very simple, lightweight PHP framework.
Note that the classes in the EntityRepository are incomplete, this is on purpose: we are not interested in the database storage, and we don't need to be able to execute the code. You don't need to complete the code in those classes.
The point of this exercise is too see how you would structure the logic of your code, not to execute it.


The file /src/index.php already contains a REST endpoint to allow users to create exercises. An exercise contains text and is associated with a user.

**Please answer the following question (in writing), and complete the code task.**

##### Question:
Read the existing code for the endpoint to create an exercise. Do you see anything that is missing or could be improved?

##### Answer:

- Check json_decode for null return which indicates an error in parsing json
- This could be my unfamiliarity with SLIM but it looks like :userId is from SLIM v2, and in v3 should be wrapped in braces to be {userId} or if we're ensuring numerical userId then the format would be {userId:[0-9]+}
- Instead of $response->getBody()->write() we can use $response->withJson(['msg' => '...']) as SLIM appears to offer a helper method to make life easier for us (downside being that our code will then no longer be PSR-7 compatible)
- $response is cloned, as a result we would need to use the return value to effect sequential changes on the response. Currently the withStatus(400) would be lost and the default of (200) would be returned.
- Repositories should be services retrieved from the container. As they are not mutable there is no need to instantiate new ones.
- Service/factory to create a new Exercise entity would be good. Haphazard creation of new entities especially after modification of entity classes can be a pain.
- Given Exercise->getAuthor() returns User, I assume Exercise->setAuthor() has the wrong docblock. If so, I would type hint the argument with User. Not knowing the specifics of the ORM, I'm leaving the translation of object to id during saves alone.
- Status is 200 by default, so no need to set and we can reduce the cloning by 1.
- Again we can use withJson if we are not sticking to PSR-7
- Assuming index.php is the entrypoint into the application, I would not stick routing into index.php. Instead a controller in the correct namespace should be used.
- In fact, my preference would be for index.php to be bootstrapping the rest of the application - see: https://github.com/akrabat/slim3-skeleton/blob/master/public/index.php (Not necessarily that separation, just the general idea)

##### Code task:
In the file /src/index.php, create a new endpoint to allow a user to vote for another user's exercise. A vote is a "thumb up" or a "thumb down".
You are free to create new classes and unit/functional tests.
Use of git to version your code is a plus.

##### Running unit tests
* Install PHPUnit by running ```composer install``` (please modify as appropriate for your system)
* Run tests with ```vendor/bin/phpunit src/```


Thanks for taking the time to complete this test and don't hesitate to email us if you have any question!
