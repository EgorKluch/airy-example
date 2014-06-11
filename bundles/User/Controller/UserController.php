<?php
/**
 * @author EgorKluch (EgorKluch@gmail.com)
 * @date: 11.06.2014
 */

namespace Site\User\Controller;

use Site\Airy;

class UserController {
  public function signUp () {
    $app = Airy::getInstance();
    $data = array (
      'login' => 'EgorKluch',
      'password' => 'password',
      'email' => 'EgorKluch@gmail.com',
      'roles' => 'user'
    );

    $userManager = $app->getUserManager();
    $userManager->signUp($data);
    $userManager->signIn($data['login'], $data['password']);
    $app->sendAjax(array('result' => 1));
  }

  public function signIn () {
    $app = Airy::getInstance();
    $userManager = $app->getUserManager();
    $userManager->signIn('EgorKluch', 'password');
    $app->sendAjax(array('result' => 1));
  }

  public function signOut () {
    $app = Airy::getInstance();
    $userManager = $app->getUserManager();
    $userManager->signOut();
    $app->sendAjax(array('result' => 1));
  }
}
