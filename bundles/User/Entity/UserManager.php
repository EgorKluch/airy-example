<?php
/**
 * @author EgorKluch (EgorKluch@gmail.com)
 * @date: 10.06.2014
 */

namespace Site\User\Entity;

use Airy\BaseEntityManager;

class UserManager extends BaseEntityManager {
  public function __construct() {
    parent::__construct('user', 'Site\User\Entity\User');
    $this->_initCurrentUser();
  }

  /**
   * @return bool
   */
  public function isAuthorized () {
    return (bool) $this->currentUser;
  }

  /**
   * @param string $login
   * @param string $pass
   * @throws \Exception
   */
  public function signIn ($login, $pass) {
    $pass = $this->_getHashedPassword($pass);
    $where = array('login' => $login, 'password' => $pass);
    $data = $this->db->one($where);

    if (!$data) throw new \Exception('Wrong login or password');

    $this->currentUser = $this->getByField('id', $data['id']);

    $token = $this->_createToken();
    $_SESSION['token'] = $token;

    $this->currentUser->token = $token;
    $this->currentUser->save();
  }

  /**
   * @param array $data
   * @throws \Exception
   */
  public function signUp ($data) {
    $user = new User($this, $data);
    $user->password = $this->_getHashedPassword($data['password']);

    if ($this->getByField('login', $user->login, true)) {
      throw new \Exception('User with this login already exists');
    }
    if ($this->getByField('email', $user->email, true)) {
      throw new \Exception('User with this email already exists');
    }

    $user->save();
  }

  public function signOut () {
    unset($_SESSION['token']);
  }

  /**
   * @return string
   */
  protected function _createToken () {
    return md5(microtime().rand());
  }

  /**
   * @param string $pass
   * @return string
   */
  protected function _getHashedPassword ($pass) {
    return md5(md5($pass));
  }

  protected function _initCurrentUser () {
    $token = null;
    if (array_key_exists('token', $_SESSION)) {
      $token = $_SESSION['token'];
    }
    if (!$token) return;

    $where = array('token' => $token);
    $data = $this->db->one($where);

    if (!$data) {
      unset($_SESSION['token']);
      $this->currentUser = null;
      return;
    }

    $this->currentUser = new User($this, $data);
  }

  protected function _initAccessManager () {
  }

  /**
   * @var User|null
   */
  public $currentUser;
} 