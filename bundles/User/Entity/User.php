<?php
/**
 * @author EgorKluch (EgorKluch@gmail.com)
 * @date: 10.06.2014
 *
 * Fields: id, login, email, password, session, roles
 */

namespace Site\User\Entity;

use Airy\BaseEntityManager;
use Airy\BaseEntity;

class User extends BaseEntity {
  /**
   * @param BaseEntityManager $manager
   * @param $data
   */
  public function __construct($manager, $data) {
    parent::__construct($manager);
    $this->_data = $data;
    if (!array_key_exists('id', $data)) $this->_data['id'] = null;
    if (!array_key_exists('token', $data)) $this->_data['token'] = null;
    if (!array_key_exists('roles', $data)) $this->_data['roles'] = 'user';
    $this->roles = explode('|', $this->roles);
  }

  /**
   * @param string $role
   * @return bool
   */
  public function hasRole ($role) {
    return (bool) array_search($role, $this->roles);
  }

  /**
   * @param array $roles
   * @return bool
   */
  public function inRoles ($roles) {
    return (bool) array_uintersect($this->roles, $roles, "strcasecmp");
  }

  protected function getMysqlData () {
    $data = $this->_data;
    $data['roles'] = implode('|', $data['roles']);
    return $data;
  }
}
