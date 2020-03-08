<?php namespace App\Facades;

use App\Models\GameModel;

/**
 * Class GameFacade
 * @package App\Facades
 *
 * @method static startTime(bool $startGame = false)
 * @method static score($score = false)
 * @method static level(bool $increment = false, bool $reset = false)
 * @method static scoreIsValid(float $remainder, int $diff = 0, int $count = null, string $ignoreIndices = null)
 * @method static reset()
 *
 * @mixin GameModel
 */
abstract class GameFacade extends BaseFacade
{
  private static $gameModel;

  //--------------------------------------------------------------------

  /**
   * Initialise class static properties for session
   */
  public static function __static()
  {
    parent::__static();

    self::$gameModel || self::$gameModel = &$_SESSION['gameModel'];
    self::$gameModel || self::$gameModel = new GameModel();
  }

  //--------------------------------------------------------------------

  public static function __callStatic($method, $args)
  {
    return self::callMethod(self::$gameModel, $method, $args);
  }
}