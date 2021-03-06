<?php namespace App\Facades;

use App\Entities\UserEntity;
use Faker\Factory;
use ReflectionException;

class UserFacadeTest extends \CIDatabaseTestCase
{
  /**
   * @throws ReflectionException
   */
  public function testUpdateStats()
  {
    $checkUpdates = function($hiScore, $totalQp)
    {
      $user = $this->getPrivateProperty(UserFacade::class, 'user');
      $this->assertEquals($hiScore, $user->hi_score);
      $this->assertEquals($totalQp, $user->total_qp);
    };

    $set = ['hi_score' => null, 'total_qp' => null];
    UserFacade::set($set)->where('user.id', 1)->update();

    $user = UserFacade::getUser(1);
    UserFacade::login($user);

    $checkUpdates(0, 0);
    UserFacade::updateStats();
    $checkUpdates(0, 0);
    UserFacade::updateStats(10);
    $checkUpdates(10, 10);
    UserFacade::updateStats(5);
    $checkUpdates(10, 15);
    UserFacade::updateStats(15);
    $checkUpdates(15, 30);

    UserFacade::logout();
    $this->expectExceptionMessage(
      "Trying to get property 'hi_score' of non-object"
    );
    $checkUpdates(0, 0);
  }

  public function testUnverifiedUsername()
  {
    $this->assertNull(UserFacade::unverifiedUsername());

    $username = 'RaceCar_is_raCecaR';
    UserFacade::unverifiedUsername($username);
    $this->assertEquals($username, UserFacade::unverifiedUsername());

    UserFacade::unverifiedUsername(false);
  }

  /**
   * @depends testGetUser
   * @param UserEntity $user
   */
  public function testIsLoggedIn(UserEntity $user)
  {
    UserFacade::login($user);
    $this->assertTrue(UserFacade::isLoggedIn());

    UserFacade::logout();
    $this->assertFalse(UserFacade::isLoggedIn());
  }

  /**
   * @return object
   * @throws ReflectionException
   */
  public function testGetUser()
  {
    $this->assertNull(UserFacade::getUser());

    $userById = UserFacade::getUser(1);
    $userByUsername = UserFacade::getUser('qp', 'username');
    $userByEmail = UserFacade::getUser('user@quepenny.com', 'email');

    $this->assertEquals($userById, $userByUsername);
    $this->assertEquals($userById, $userByEmail);
    $this->assertEquals($userByUsername, $userByEmail);

    $this->checkUserAttributes($userById);
    $this->checkUserAttributes($userByUsername);
    $this->checkUserAttributes($userByEmail);

    return $userById;
  }

  /**
   * @param object $user
   * @throws ReflectionException
   */
  public function checkUserAttributes(object $user)
  {
    $this->assertInstanceOf(UserEntity::class, $user);

    $attributes = $this->getPrivateProperty($user, 'attributes');
    $this->assertArrayHasKey('league_name', $attributes);
    $this->assertArrayHasKey('photo', $attributes);
    $this->assertArrayHasKey('email_verifier', $attributes);
    $this->assertArrayHasKey('league_color', $attributes);
  }

  /**
   * @throws ReflectionException
   */
  public function testCreateUser()
  {
    $faker = Factory::create();

    $data = [
      'username' => str_replace('.', '', $faker->unique()->userName),
      'password' => $faker->password(8),
      'email' => $faker->unique()->email,
      'firstname' => $faker->firstName,
      'lastname' => $faker->lastName,
    ];

    $user = UserFacade::createUser($data);
    $this->assertEquals(60, strlen($user->password));
    $this->assertEquals(10, strlen($user->email_verifier));

    $criteria = [
      'user_id'  => $user->id,
      'verifier' => $user->email_verifier
    ];

    $this->seeInDatabase('email_verifier', $criteria);

    return $user;
  }

  /**
   * @depends testCreateUser
   * @param object $user
   */
  public function testConfirmEmailVerification(object $user)
  {
    UserFacade::confirmEmailVerification($user->id);

    $criteria = [
      'user_id'  => $user->id,
      'verifier' => $user->email_verifier
    ];

    $this->dontSeeInDatabase('email_verifier', $criteria);

    UserFacade::where('id', $user->id)->delete();
  }

  public function tearDown(): void
  {
    parent::tearDown();
    UserFacade::logout();
  }
}
