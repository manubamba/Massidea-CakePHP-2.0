<?php
/**
 * Token - class interface for TokenModel
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
 *  Token - class
 *
 *  @package    Components
 *  @author     Jaakko Paukamainen
 *  @copyright  2011 Jaakko Paukamainen
 *  @license    GPL v2
 *  @version    1.0
 */
class TokenComponent extends Component {
	private $Token;

	function __construct() {
// 		$this->Token = Classregistry::init('Token');
	}
	function startup() {
		parent::startup($this);
	}
	function beforeRender() {
		parent::beforeRender($this);
	}
	function initialize() {
		parent::initialize($this);
	}

	function getActivationToken($code = null) {
		$return = $this->Token->find(
			'first', 
				array('conditions' => array('Token.value' => (string)$code))
		);
		return $return;
	}

	function clearActivationToken($id = null) {
		return $this->Token->delete($id);
	}

	function hasPendingActivation($userId = null) {
		$return = $this->Token->find(
			'count', array(
				'conditions' => array(
					'Token.user_id' => $userId,
					'Token.type' => 'activation'
		)
		)
		);
		return ($return > 0) ? true: false;
	}

	function createActivationCode($userId = null) {
		if(isset($userId)) {
			$hash = sha1($userId.microtime());
			$data = array(
				'Token' => array(
					'user_id' => $userId,
					'type' => 'activation',
					'value' => $hash,
					'expires' => date('Y-m-d H:i:s', strtotime("+24 hours"))
			)
			);
			if($this->Token->save($data)) {
				return $hash;
			}
		}
		return false;
	}
}