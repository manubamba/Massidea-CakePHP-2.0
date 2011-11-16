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
 *  Maintains groups related actions (browse, view, edit, delete...)
 *	TODO: -
 *  @package        Controllers
 *  @author         Manu Bamba
 *  @copyright      Manu Bamba
 *  @license        GPL v2
 *  @version        1.0
 */

class GroupsController extends AppController {
	function beforeFilter() {
		parent::beforeFilter();		
	}
	function browse() {
		$this->Group->contain(array(
			'Campaign.id',
			'GroupsUser.User.id'
		));
		$recentGroups = $this->Group->find('all',
			array(
					'limit' => 10,
					'order' => 'Group.created DESC',
					'fields' => array('name', 'lead')
				)
		);
		//debug($recentGroups);
		$campaignCount = null;
		$memberCount = null;
		
		foreach ($recentGroups as $group) {
			$campaignCount[$group['Group']['id']] = sizeof($group['Campaign']);
			$memberCount[$group['Group']['id']] = sizeof($group['GroupsUser']);
		}
		$this->set('groups', $recentGroups);
		$this->set('campaignCount', $campaignCount);
		$this->set('memberCount', $memberCount);
	}

	function view($groupId) {
// 		debug($this->Session);
		$userRole = $this->getUserRole($groupId);
		$group = $this->Group->find('first', array(
					'conditions' => array(
						'Group.id' => $groupId
					),
					'contain' => array(
						'Campaign' => array(
							'fields' => array(
								'id',
								'name',
								'start_time',
								'end_time'
							),
							'limit' =>2,
							'order' =>'end_time DESC'
						),
						'LinkedGroups' => array(
							'limit' => 2,
							'fields' => array(
								'id',
								'name'
							)
						),			
					),
					'fields' => array(
						'id',
						'name',
						'lead',
						'body',
						'created'
					),
					'recursive' => 2					
		));		
		
		$campaign_count = $this->Group->find('first', array(
			'contain' => array(
				'Campaign' => array(
					'fields' => array(
						'id'
					)
				)
			),
			'fields' => 'id',
			'conditions' => array(
				'id' => $groupId
			)
		));
		$campaign_count = count($campaign_count['Campaign']);
		$linked_group_count = $this->Group->find('first', array(
					'contain' => array(
						'LinkedGroups' => array(
							'fields' => array(
								'id'
							)
						)
					),
					'fields' => 'id',
					'conditions' => array(
						'id' => $groupId
					)
		));
		
		$linked_group_count = count($linked_group_count['LinkedGroups']);		
// 		debug($linked_group_count);
		$administrators = $this->Group->GroupsUser->find('all', array(
			'fields' => array(
				'User.username',
				'User.id',
				'user_role_id',
				'UserRole.name'
		),
			'conditions' => array(
				'UserRole.name' => 'Admin',
				'Group.id' => $groupId
		),
			'limit' => 2,
			'recursive' => 1
		));
		// 		debug($administrators);
		$admin_count = $this->Group->GroupsUser->find('count', array(
			'conditions' => array(
				'UserRole.name' => 'Admin',
				'Group.id' => $groupId
		)
		));
		$this->set('content_sidebar', 'left');
		$this->set('group', $group);		
		$this->set('administrators', $administrators);
		$this->set('admin_count', $admin_count);
		$this->set('campaign_count', $campaign_count);
		$this->set(compact('recent_linked_groups'));
		$this->set(compact('linked_group_count'));
		$this->set(compact('userRole'));
	}	
	
	function add() {
		if($this->userId) {
			if(!empty($this->data)) {
				if ($this->request->is('post')) {
					$this->request->data['GroupsUser'] = array(
					array(
										'user_id' => $this->userId,
										'user_role_id' => 2,
										'favourite' => 0					
					)
					);
					if($this->Group->saveAll($this->data)) {
						$groupId = $this->Group->id;
						$this->Session->setFlash('The group has been successfully added');
						$this->redirect(array(
															'controller' => 'Groups',
															'action' => 'view', $groupId
						));
					}			
					
				} else {
					$this->redirect('/');
				}
			}
		} else {
			$this->redirect(array(
				'controller' => 'Users',
				'action' => 'login'
			));
		} 			 
	} 
		
	function edit($groupId) {
			if($this->getUserRole($groupId) == 'Admin') {
				if($this->request->data) {
					if($this->Group->save($this->request->data)) {
						$this->redirect(array(
						'controller' => 'Groups',
						'action' => 'view', $groupId
						));
					}
				} else {
					$this->Group->id = $groupId;
					$this->data = $this->Group->read();
				}
			} else {
				$this->redirect('/');
			}
	}
	
	function delete($groupId) {
		if($this->getUserRole($groupId) == 'Admin') {
			$this->Group->id = $groupId;
			$this->Group->GroupsUser->deleteAll(array(
				'group_id' => $groupId
			));
			if($this->Group->delete($groupId)) {
				$this->Session->setFlash('Group successfully Deleted');
				$this->redirect('/Groups/browse'); 
			} else {				
				$this->Session->setFlash('Group not Deleted');
				$this->redirect(array(
					'controller' => 'Groups',
					'action' => 'view', $groupId
				));
			}
			
		}

	}
	
function join($groupId) {
		if(!$this->getUserRole($groupId)) {				
			$this->request->data['GroupsUser'] = array(
					'group_id' => $groupId,
					'user_id' => $this->userId,
					'user_role_id' => 1,
					'favourite' => 0	
			);
// 			debug($this->data); 
			$this->Group->GroupsUser->save($this->data);					
		} else {
			$this->Session->setFlash('You are already a member!');
		}
		$this->redirect(array(
						'controller' => 'Groups',
						'action' => 'view', $groupId
		));
	}
	function unjoin($groupId) {
		if($this->getUserRole($groupId)) {			
			$this->Group->GroupsUser->deleteAll(array(
				'group_id' => $groupId,
				'user_id' => $this->userId
			));
		} else {
			$this->Session->setFlash('You are not a member!');
		}
		$this->redirect(array(
							'controller' => 'Groups',
							'action' => 'view', $groupId
		));
	}

	function getCampaignList($groupId) {		
		$this->autoRender = false;
		$this->autoLayout = false;
		$campaigns = $this->Group->find('first', array(
							'conditions' => array(
								'Group.id' => $groupId
							),
							'contain' => array(
								'Campaign' => array(
									'fields' => array(
										'id',
										'name',
										'start_time',
										'end_time'
									),
									'order' =>'end_time DESC'
								)
							),
							'fields' => array(
								'id'
							),
							'recursive' => 2					
		));
		echo json_encode($campaigns);
	}
	
	function getMemberList($groupId) {
		$this->autoRender = false;
		$this->autoLayout = false;
		$members = $this->Group->GroupsUser->find('all', array(
			'fields' => array(
				'User.username',
				'User.id',
				'user_role_id',
				'UserRole.name'
			),
			'conditions' => array(
// 				'UserRole.name' => 'Admin',
				'Group.id' => $groupId
			),
			'recursive' => 1
		));
		echo json_encode($members);
	}

	
	function getAdminList($groupId) {
		$this->autoRender = false;
		$this->autoLayout = false;
		$members = $this->Group->GroupsUser->find('all', array(
			'fields' => array(
				'User.username',
				'User.id',
				'user_role_id',
				'UserRole.name'
			),
			'conditions' => array(
				'UserRole.name' => 'Admin',
				'Group.id' => $groupId
			),
			'recursive' => 1
		));
		echo json_encode($members);
	}
	
	function getUserRole($groupId, $userId = null) {
		$userId = $userId == null ? $this->userId : $userId;
		$userIsAdmin = $this->Group->GroupsUser->find('first', array(
										'conditions' => array(
											'User.id' => $userId,
											'Group.id' => $groupId
										),
										'recursive' => 2					
		));		
		return $userIsAdmin['UserRole']['name'];
	}
}

