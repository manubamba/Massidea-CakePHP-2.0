<?php
/**
 * CustomAuth - Custom AuthComponent extension
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * License text found in /license/
 */

/**
 *  custom_auth -  class
 *
 *  @package    Components
 *  @author     Jaakko Paukamainen
 *  @copyright  2011 Jaakko Paukamainen
 *  @license    GPL v2
 *  @version    1.0
 */ 

app::import('component', 'Auth');
class CustomAuthComponent extends AuthComponent {
	var $User;
	var $Token;
	
// 	function __construct() {
// 		$this->User = ClassRegistry::init('User');
// 		$this->Token = ClassRegistry::init('Token');
// 		parent::__construct();
// 	}
	
	function login($data = null) {
		$this->User = ClassRegistry::init('User');
		$this->Token = ClassRegistry::init('Token');
		if(empty($data)) $data = $this->request->data;
		$userId = $this->User->find('list', array(
			'conditions' => array('User.username' => $data['User']['username']),
			'fields' => array('User.id')
		));		
		$userId = current($userId);	
		if($this->User->isOldUser($data['User']['username'])) {		
			$plainPassword = $data['User']['password'];
			$salt = $this->User->getUserSalt($data['User']['username']);
			$this->request->data = $data;
			$data['User']['password'] = $this->hashOldPassword($salt, $data['User']['password']);
// 			if($this->identify($this->request, $this->response)) {
				$data['User']['password'] = $this->updateToNewSalting($userId, $plainPassword);
			}
// 		} else {
// 			$data['User']['password'] = $this->customHashPassword($data['User']['password']);
// 		}
		if($success = $this->identify($this->request, $this->response)) {
			
			
			// Continue authentication
// 			if($this->Token->hasPendingActivation($userId)) {
// 				$this->Session->setFlash(__('Login failed due to pending email verification.', true));
// 				$success = false;
// 			} else {
				if($success = parent::login()) {
					$this->updateLastLogin($userId);
					$this->Session->setFlash(__('Successfully logged in!', true));
// 				}
			}
		}
		return $success;
	}
	
	function updateLastLogin($userId = null) {
		$this->User->create();
		$this->User->id = $userId;
		return $this->User->saveField('last_login', DboSource::expression('NOW()'));
	}
	
	function updateToNewSalting($userId = null, $plainPwd = null) {
		$data = array(
			'id' => $userId,
			'password' => $plainPwd,
			'password_salt' => ''
		);
		// Update user record for new hash (hashing occurs in UserModel, beforeSave())
		$savedData = $this->User->save($data, array(
			'validate' => false, 
			'fieldList' => array('password', 'password_salt')
		));
		if(!empty($savedData)) {
			CakeLog::write('activity', 'Updated password hashing for user id '.$userId);
			return $savedData['User']['password'];
		} else {
			return false;
		}
	}

	/**
	 * customHashPassword
	 * 
	 * Password hashing function.
	 * @param string $pwd password
	 * @return string
	 */
	function customHashPassword($pwd = null) {
		return Security::hash($pwd);
	}
	
	/**
	 * hashOldPassword
	 * 
	 * Hash password with old hashing algorithm (used in previous version of Massidea)
	 * @param string $salt
	 * @param string $password
	 * @return string
	 */
	function hashOldPassword($salt = null, $password = null) {
		return md5($salt.$password.$salt);
	}
		
}