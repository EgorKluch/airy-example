<?php
/**
 * @author EgorKluch (EgorKluch@gmail.com)
 * @date: 11.06.2014
 */

namespace Site;
use Site\User\Controller\UserController;
use Site\User\Entity\UserManager;

/**
 * Class Airy
 * @package Site
 *
 * @method static Airy getInstance()
 */
class Airy extends \Airy\Airy {
  public function __construct($options) {
    parent::__construct($options);
    $this->regManager('user', 'Site\User\Entity\UserManager');
    $this->regController('user', 'Site\User\Controller\UserController');
  }

  /**
   * @return UserManager
   */
  public function getUserManager () {
    return $this->getManager('user');
  }

  /**
   * @return UserController
   */
  public function getUserController () {
    return $this->getUserController();
  }
} 