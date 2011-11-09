<?php

/**
 *  PrivateMessagesController
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 *  Software Foundation, Inc., 59 Temple P	lace, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/
 */

/**
 *  PrivateMessages - class
 *  Handles private messages
 *
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright
 *  @license        GPL v2
 *  @version        1.0
 */
class PrivateMessagesController extends AppController {

	var $components = array('RequestHandler','PrivateMessage_');
	var $time;
	public function beforeFilter() {
		parent::beforeFilter();
// 		if (!$this->userId) {
// 			$this->redirect('/');
// 		}
	}

	
	
	protected function _init_fetch_messages() {
		App::import('Helper', 'smart_time');
		$this->time = new SmarttimeHelper();
		$this->autoRender = false;
	}

	public function send() {
		$this->autoRender = false;
		$this->autoLayout = false;
		if ($this->RequestHandler->isAjax()) {
			if (!empty($this->data)) {
				//When users are ready this needs validation because data can be altered by end user.
				$this->data['PrivateMessage']['sender_id'] = $this->userId; //replaced with user id from session!
				$this->data['PrivateMessage']['message'] = trim($this->data['PrivateMessage']['message']);
				$this->data['PrivateMessage']['title'] = trim($this->data['PrivateMessage']['title']);
				
				if ($this->PrivateMessage->save($this->data)) {
					$this->data['UserPrivateMessage']['private_message_id'] = $this->PrivateMessage->id;
					if (isset($this->data['UserPrivateMessage']['receivers'])) {
						if(empty($this->data['UserPrivateMessage']['receivers'])) {
							$this->data['UserPrivateMessage']['receiver_id'] = $this->userId;
							$this->PrivateMessage->UserPrivateMessage->save($this->data);
						} else {
							foreach (explode(',', $this->data['UserPrivateMessage']['receivers']) as $receiver_id) {
	 							$this->data['UserPrivateMessage']['receiver_id'] = $receiver_id;					
								$this->PrivateMessage->UserPrivateMessage->save($this->data);
								$this->PrivateMessage->UserPrivateMessage->id = null;
							}
						}
					} else {
						$this->PrivateMessage->UserPrivateMessage->save($this->data);
					}
					echo 1;
				} else {
					die;
				}
			} else {
				$this->redirect('/');
			}
		} else {
			$this->redirect('/');
		}
	}

	public function delete() {
		$this->autoRender = false;
		$this->autoLayout = false;
		if ($this->RequestHandler->isAjax()) {
			foreach ($this->data['messageId'] as $messageId) {
				if ($this->params['page'] == 'inbox' || $this->params['page'] == 'conversation') {
					if ($id = $this->PrivateMessage_->_isOwnerOf($this->userId, $messageId, true)) {
						$this->PrivateMessage->UserPrivateMessage->id = $id;
						$this->PrivateMessage->UserPrivateMessage->set(array('deleted' => true));
						$this->PrivateMessage->UserPrivateMessage->save();
						echo 1;
					} else {
						echo 0;
					}
				}
				if ($this->params['page'] == 'sent' || $this->params['page'] == 'conversation' || $this->params['page'] == 'thread'|| $this->params['page'] == 'myNotes') {
					if ($id = $this->PrivateMessage_->_isOwnerOf($this->userId, $messageId, false)) {
						$this->PrivateMessage->id = $id;
						$this->PrivateMessage->set(array('deleted' => true));
						$this->PrivateMessage->save();
						echo 1;
					} else {
						echo 0;
					}
				}
			}
		} else {
			$this->redirect('/');
		}
	}

	public function browse() {
		$this->autoRender = true;
		$messages_in_count = $this->count('inbox');
		$messages_out_count = $this->PrivateMessage->PrivateMessagesUser->find('count', array(
					'conditions' => array(
// 						'PrivateMessage.sender_id' => $this->userId,
						'PrivateMessage.deleted' => false,
						'Receiver.id <>' => $this->userId
					)
						)
		);
		$messages_myNotes_count = $this->PrivateMessage->PrivateMessagesUser->find('count', array(
					'conditions' => array(
// 						'PrivateMessage.sender_id' => $this->userId,
						'PrivateMessage.deleted' => false,
						'Receiver.id' => $this->userId
					)
						)
		);
// 		$PrivateMessageTag = ClassRegistry::init('PrivateMessageTag');
// 		$allTags = $PrivateMessageTag->find('all', array(
// 			'conditions' => array(
// 				'user_id' => $this->userId	
// 			),
// 			'recursive' => '-1',
// 			'order' => 'name'
// 		));
		
		
		$this->set('content_sidebar', 'left');
		$this->set('messages_in_count', $messages_in_count);
		$this->set('messages_out_count', $messages_out_count);
		$this->set('messages_myNotes_count', $messages_myNotes_count);
		$this->set('notifications_count', '0');
// 		$this->set('allTags', $allTags);
	}

	public function fetch_messages_sent() {
		$this->_init_fetch_messages();
		$messages = $this->PrivateMessage->UserPrivateMessage->find('all', array(
					'contain' => array(
						'PrivateMessage.Sender' => array(
							'fields' => array('username')
						),
						'Receiver' => array(
							'fields' => array('username', 'id'),
						),
						'PrivateMessage' => array(
							'OutboxTag' => array(
								'PrivateMessageTag' => array(
									'fields' => array('name','color'))
							),
							'fields' => array('id', 'parent_id', 'read_receipt', 'title', 'message', 'created')
						)),
					'conditions' => array('sender_id' =>  $this->userId, 'Receiver.id <>' =>  $this->userId, 'PrivateMessage.deleted' => false)
				));
		$messages = $this->_format_fields($messages);
		echo json_encode(array('messages' => $messages));
	}

	public function fetch_messages_conversation() {
		$this->_init_fetch_messages();
		$associate_id = $this->params['associate_id'];
		$path = $this->PrivateMessage->getpath($associate_id, 'id', -1);
		if (empty($path)) {
			echo 0;
		} else {
			$highestParent = $path[0]['PrivateMessage']['id'];
			$unparsedMessageTree = $this->PrivateMessage->children(
							$highestParent,
							null,
							null,
							array(
								'id'
							),
							null,
							null,
							null,
							2
			);
			foreach ($unparsedMessageTree as $k => $item) {
				$unparsedMessagesIds[$k] = $item['PrivateMessage']['id'];
			}

			$unparsedMessagesIds[] = $highestParent;
			$messages = $this->PrivateMessage->UserPrivateMessage->find('all', array(
						'contain' => array(
							'PrivateMessage.Sender' => array(
								'fields' => array('username', 'id')
							),
							'Receiver' => array(
								'fields' => array('username', 'id')
							),
							'PrivateMessage' => array(
								'OutboxTag' => array(
									'PrivateMessageTag' => array(
										'fields' => array('name','color'))
								),
								'fields' => array('id', 'sender_id', 'parent_id', 'read_receipt', 'title', 'deleted', 'message', 'created')
							),
							'InboxTag' => array(
							'PrivateMessageTag' => array(
								'fields' => array('name','color'))
							)),
						'conditions' => array(
							'XOR' => array(
								array('Receiver.id' =>  $this->userId, 'UserPrivateMessage.deleted' => false),
								array('sender_id' =>  $this->userId, 'PrivateMessage.deleted' => false)
							),
							
							'PrivateMessage.id' => $unparsedMessagesIds,
						)
					));


			foreach ($messages as $k => $message) {

				if ($message['PrivateMessage']['Sender']['id'] == $this->userId) {
					$messages[$k]['UserPrivateMessage']['read'] = 1;
				}
			}
		}
		$messages = $this->_format_fields($messages);
		echo json_encode(array('messages' => $messages));
	}
	
	public function fetch_messages_tag() {
		$this->_init_fetch_messages();
		$tagId = $this->params['tag_id'];
		
	}

	public function fetch_messages_thread() {
		$this->_init_fetch_messages();
		$associate_id = $this->params['associate_id'];
		$path = $this->PrivateMessage->getpath($associate_id, 'id', -1);
		if (empty($path)) {
			echo 0;
		} else {
			$highestParent = $path[0]['PrivateMessage']['id'];
			$unparsedMessages = $this->PrivateMessage->children(
							$highestParent,
							null,
							null,
							// 					array(
							// 						'PrivateMessage.id',
							// 						'PrivateMessage.sender_id',
							// 						'PrivateMessage.parent_id',
							// 						'PrivateMessage.title',
							// 						'PrivateMessage.message',
							// 						'PrivateMessage.created',
							// 						'Sender.username',
							// 						'UserPrivateMessage'.'receiver_id',
							// 						'UserPrivateMessage'.'deleted'
							// 					),
							'PrivateMessage.created DESC',
							null,
							null,
							1
			);

			$parentMessage = $this->PrivateMessage->find('all', array(
						// 					'fields' => array(
						// 						'PrivateMessage.id',
						// 						'PrivateMessage.sender_id',
						// 						'PrivateMessage.parent_id',
						// 						'PrivateMessage.title',
						// 						'PrivateMessage.message',
						// 						'PrivateMessage.created',
						// 						'Sender.username',
						// 						'UserPrivateMessage'.'receiver_id',
						// 						'UserPrivateMessage'.'deleted'
						// 					),
						'conditions' => array(
							'PrivateMessage.id' => $highestParent,
						),
						'recursive' => '1'
					));

			$unparsedMessages[] = $parentMessage[0];
			$messages = array();
			foreach ($unparsedMessages as $message) {
				if ($message['PrivateMessage']['sender_id'] == $this->userId) {
					if (!$message['PrivateMessage']['deleted']) {
						$messages[] = $message;
					}
				} else {
					foreach ($message['UserPrivateMessage'] as $UserPrivateMessage) {
						if (($UserPrivateMessage['receiver_id'] == $this->userId) &&
								(!$UserPrivateMessage['deleted'])) {
							$messages[] = $message;
						}
					}
				}
			}
		}
		$messages = $this->_format_fields($messages);
		echo json_encode(array('messages' => $messages));
	}

	public function fetch_messages_myNotes() {
		$this->_init_fetch_messages();
		$messages = $this->PrivateMessage->UserPrivateMessage->find('all', array(
					'contain' => array(
						'PrivateMessage.Sender' => array(
							'fields' => array('username', 'id'),
						),
						'Receiver' => array(
							'fields' => array('username')
						),
						'PrivateMessage' => array(
							'OutboxTag' => array(
								'PrivateMessageTag' => array(
									'fields' => array('name','color'))
							),
							'fields' => array('id', 'sender_id', 'parent_id', 'read_receipt', 'title', 'message', 'created')
						)),
					'conditions' => array('Receiver.id' =>  $this->userId, 'sender_id' =>  $this->userId, 'PrivateMessage.deleted' => false)
				));
		$messages = $this->_format_fields($messages);
		echo json_encode(array('messages' => $messages));
	}

	public function fetch_messages_inbox() {
		$this->_init_fetch_messages();
		$messages = $this->PrivateMessage->UserPrivateMessage->find('all', array(
					'contain' => array(
						'PrivateMessage.Sender' => array(
							'fields' => array('username', 'id'),
						),
						'Receiver' => array(
							'fields' => array('username')
						),
						'PrivateMessage' => array(
							'fields' => array('id', 'sender_id', 'parent_id', 'read_receipt', 'title', 'message', 'created')
						),
						'InboxTag' => array(
							'PrivateMessageTag' => array(
								'fields' => array('name','color'))
						)),
					'conditions' => array('Receiver.id' =>  $this->userId, 'sender_id <>' =>  $this->userId, 'UserPrivateMessage.deleted' => false)
				));
		$messages = $this->_format_fields($messages);
		echo json_encode(array('messages' => $messages));
	}
	
	protected function _format_fields($messages) {
		foreach ($messages as $k => $message) {
			$this->time->end = '+1 day';
			$messages[$k]['PrivateMessage']['timeago'] =
			$this->time->timeAgoInWords($message['PrivateMessage']['created']);
			$messages[$k]['PrivateMessage']['title'] = htmlspecialchars($message['PrivateMessage']['title']);
		}
		return $messages;
	}

	function mark() {
		$id = $this->userId;
		$this->autoRender = false;
		foreach ($this->data['messageId'] as $messageId) {
			if ($id = $this->PrivateMessage_->_isOwnerOf($this->userId, $messageId, true)) {
				$this->PrivateMessage->UserPrivateMessage->id = $id;
				$this->PrivateMessage->UserPrivateMessage->set(array('read' => (bool) $this->data['markRead']));
				$this->PrivateMessage->UserPrivateMessage->save();
			}
		}
	}

	function count($page) {
		$id = $this->userId;
		$count = $this->PrivateMessage->PrivateMessagesUser->find('count', array(
					'conditions' => array(
						'receiver' => $this->userId,
						'PrivateMessagesUser.deleted' => false,
// 						'sender_id <>' => $this->userId,
						'read' => false
					)
						)
		);
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			if (!isset($count))
				$count = null;
			echo $count;
		} else {
			return $count;
		}
	}

}
