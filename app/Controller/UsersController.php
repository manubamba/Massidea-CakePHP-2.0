<?php
/**
 *  UsersController
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 *  Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/
 */

/**
 *  UsersController - class
 *  Maintains authentication related actions (signup, login, logout...)
 *	TODO: -
 *  @package        controllers
 *  @author         Jaakko Paukamainen
 *  @copyright      Jaakko Paukamainen
 *  @license        GPL v2
 *  @version        1.0
 */

class UsersController extends AppController {
	public $name = 'Users';
// 	public $components = array('RecaptchaPlugin.Recaptcha', 'RequestHandler', 'Email', 'Token'); 
// 	public $helpers = array('RecaptchaPlugin.Recaptcha', 'Time');
	public $components = array('RequestHandler', 'Email', 'Token');
	public $helpers = array('Time');
	
	function beforeFilter() {
		parent::beforeFilter();
// 		$this->Auth->authenticate = array('Form');
		$this->Auth->allow('ajaxValidateField');
	}
	
	function login() {
		$this->set('content_class', 'contentWithFullPage');
		if(!empty($this->request->data)) {
			$this->Auth->login();
		}
		
		
		// If already logged in, redirect to home
		// TODO: redirect back where came from
		if($this->Session->read('Auth.User')) {			
			$this->redirect('/');
		}
	}
	
	function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}
	
	function signup() {
		// If already logged in, redirect to home
		// TODO: redirect back where came from
		if($this->Session->read('Auth.User')) {
			$this->redirect('/');
		}
		
		if(!empty($this->data)) {
			// Validate fields
			$validUserData = $this->User->saveAll($this->data['User'], array('validate' => 'only'));
			$validProfileData = $this->User->Profile->saveAll($this->data['Profile'], array('validate' => 'only'));
			
			if($validUserData && $validProfileData) {
				// Save user data
				$userSaved = $this->User->saveAll($this->data['User'], array('validate' => false));

				$signupError = null;
				if($userSaved) {
					// Reformat array structure for saving multiple key-value pairs
					$this->data['Profile'] = $this->__reformatProfileData($this->User->id, $this->data['Profile']);
					// Save profile data
					$profileSaved = $this->User->Profile->saveAll($this->data['Profile'], array('validate' => false));
					if($profileSaved) {
						// Send activation token via email
						if($this->__sendActivationMail($this->User->id, $this->data['User'])) {
							$this->Session->write('Activation.mail', $this->data['User']['email']);
							$this->Session->setFlash(__('Registration confirmation mail sent', true));
							$this->redirect('/users/activate');
						} else {
							$signupError = "Couldn't create/send activation token"; 
						}
					} else {
						$signupError = "Couldn't save profile data";
					}
				}
				// Log possible signup errors
				if(!empty($signupError)) {
					// Rollback user from database
					CakeLog::write('error', "Registration failed, reason: ".$signupError);
					$this->User->delete($this->User->id);
					$this->Session->setFlash(__('Registration failed', true));
				}
			}
		}
	}
	
	function activate($code = null) {
		$this->set('content_class', 'contentWithFullPage');
		$this->set('message', 'invalid');
		if(!empty($code)) {
			$token = $this->Token->getActivationToken($code);
			if(!empty($token)) {
				if($this->Token->clearActivationToken($token['Token']['id'])) {
					$this->Session->delete('Activation.mail');
					$this->set('message', 'activated');
				}
			} else {
				$this->set('message', 'invalid');
			}
		} else {
			$address = $this->Session->read('Activation.mail');
			if(isset($address)) {
				$this->set('message', 'sent');
				$this->set('address', $address);
			} else {
				$this->redirect('/');
			}
		}
	}
	
	function view($userName = null) {
		if(!isset($userName)) {
			$this->redirect('/');
		}
		
		$this->set('content_class', 'contentWithFullPage');
		$userdata = $this->User->getPublicUserdata($userName);
		
		if(!$userdata) {
			$this->redirect('/');
		}
		
		$this->set('username', $userdata['User']['username']);
		$this->set('joinedDate', $userdata['User']['created']);
		$this->set('loggedDate', $userdata['User']['last_login']);
		$this->set('owner', ($this->Session->read('Auth.User.username') == $userdata['User']['username']));
		
		$excludeProfileData = array('status', 'openid', 'permissions');
		foreach($userdata['Profile'] as $key => $child) {
			if(in_array($child['key'], $excludeProfileData)) unset($userdata['Profile'][$key]);
		}

		$this->set('profileData', $userdata['Profile']);
	}
	
	/**
	 * __sendActivationMail
	 * 
	 * Generates and sends an activation token code to given users email address.
	 * 
	 * @param string $userId
	 * @param array $userData
	 */
	private function __sendActivationMail($userId = null, $userData = null) {
		if(!empty($userId) && !empty($userData)) {
			$code = $this->Token->createActivationCode($userId);
			$this->Email->to = $userData['email'];
			$this->Email->subject = 'Massidea.org account verification';
			$this->Email->from = 'Massidea.org <massidea@massidea.org>';
			$this->Email->template = 'activate';
			$this->Email->sendAs = 'html';
			$this->set('name', $userData['username']);
			$this->set('link', 'activate/'.$code);
			
			return $this->Email->send();
		} else {
			return false;
		}
	}
	
	/**
	 * __reformatProfileData
	 * 
	 * Reformats given $array's structure for profile-model.
	 * @param string $userId User record's id
	 * @param array $array Profile data
	 */
	private function __reformatProfileData($userId, $array) {
		$i = 0;
		$return = array();
		foreach($array as $key => $value) {
			$return[$i] = array(
				'user_id' => $userId,
				'key' => $key,
				'value' => $value
			);
			$i++;			
		}
		return $return;
	}
	
	
	public function listUsers() {
// 		code to filter the contacts shown will come here this week!
		$term = $this->params['url']['term']; 
		$this->autoRender = false;
		$allUsers = $this->User->find('all', array(
			'fields' => array('id', 'username'),
			'conditions' => array('username LIKE' => "%$term%"),
			'recursive' => '0'
		));
		$parsedUserList = array();
		foreach ($allUsers as $k => $user) {
			$parsedUserList[$k]['value'] = $user['User']['username'];
			$parsedUserList[$k]['id'] = $user['User']['id'];
		}
		echo json_encode($parsedUserList);
	}
}