<?php
 class PrivateMessage_Component extends Component {
 	
 	function initialize(&$controller, $settings = array()) {
 		$this->PrivateMessage = ClassRegistry::init('PrivateMessage');
 	}
 	
 	public function _isOwnerOf($userId, $messageId, $checkReceiver = null) {
 		if (!$checkReceiver === false) {
 			$message = $this->PrivateMessage->UserPrivateMessage->find('first',
 			array('conditions' => array(
 										'private_message_id' => $messageId,
 										'receiver_id' => $userId),
 									'recursive' => '-1'
 			)
 			);
 			$id = (isset($message['UserPrivateMessage']['id'])) ? $message['UserPrivateMessage']['id'] : null;
 		}
 	
 		if (!$checkReceiver === true) {
 			// checking for the sender!
//  			debug($this);
 			$message = $this->PrivateMessage->find('first',
 			array('conditions' =>
 			array('PrivateMessage.id' => $messageId, 'PrivateMessage.sender_id' => $userId)
 			)
 			);
 			$id = (isset($message['PrivateMessage']['id'])) ? $message['PrivateMessage']['id'] : null;
 		}
 	
 		if (empty($id)) {
 			return false;
 		} else {
 			return $id;
 		}
 	}
 } 